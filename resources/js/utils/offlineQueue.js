import { ref, readonly } from 'vue';
import axios from 'axios';

const DB_NAME = 'clinic_offline_queue';
const DB_VERSION = 1;
const STORE_NAME = 'transactions';

// Reactive state (shared singleton)
const isOnline = ref(navigator.onLine);
const pendingCount = ref(0);
const isSyncing = ref(false);
const lastSyncResult = ref(null); // { success: true/false, message: '' }

// ── IndexedDB helpers ──────────────────────────────────────────────
function openDB() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(DB_NAME, DB_VERSION);
        request.onupgradeneeded = (e) => {
            const db = e.target.result;
            if (!db.objectStoreNames.contains(STORE_NAME)) {
                db.createObjectStore(STORE_NAME, { keyPath: 'id', autoIncrement: true });
            }
        };
        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);
    });
}

async function addToQueue(type, url, data) {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(STORE_NAME, 'readwrite');
        const store = tx.objectStore(STORE_NAME);
        const item = {
            type,
            url,
            data,
            createdAt: new Date().toISOString(),
        };
        const request = store.add(item);
        request.onsuccess = () => {
            refreshCount();
            resolve(request.result);
        };
        request.onerror = () => reject(request.error);
    });
}

async function getQueue() {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(STORE_NAME, 'readonly');
        const store = tx.objectStore(STORE_NAME);
        const request = store.getAll();
        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);
    });
}

async function removeFromQueue(id) {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(STORE_NAME, 'readwrite');
        const store = tx.objectStore(STORE_NAME);
        const request = store.delete(id);
        request.onsuccess = () => {
            refreshCount();
            resolve();
        };
        request.onerror = () => reject(request.error);
    });
}

async function clearQueue() {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(STORE_NAME, 'readwrite');
        const store = tx.objectStore(STORE_NAME);
        const request = store.clear();
        request.onsuccess = () => {
            pendingCount.value = 0;
            resolve();
        };
        request.onerror = () => reject(request.error);
    });
}

async function refreshCount() {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(STORE_NAME, 'readonly');
        const store = tx.objectStore(STORE_NAME);
        const request = store.count();
        request.onsuccess = () => {
            pendingCount.value = request.result;
            resolve(request.result);
        };
        request.onerror = () => reject(request.error);
    });
}

// ── Sync logic ─────────────────────────────────────────────────────
async function syncQueue() {
    if (isSyncing.value || !isOnline.value) return;

    const items = await getQueue();
    if (items.length === 0) return;

    isSyncing.value = true;
    lastSyncResult.value = null;

    let successCount = 0;
    let failCount = 0;
    const errors = [];

    for (const item of items) {
        try {
            await axios.post('/api/offline-queue/sync', {
                type: item.type,
                data: item.data,
            });
            await removeFromQueue(item.id);
            successCount++;
        } catch (err) {
            failCount++;
            const msg = err.response?.data?.message || err.message || 'Unknown error';
            errors.push(`${item.type}: ${msg}`);
        }
    }

    isSyncing.value = false;

    if (failCount === 0) {
        lastSyncResult.value = {
            success: true,
            message: `${successCount} item${successCount !== 1 ? 's' : ''} synced successfully!`,
        };
    } else {
        lastSyncResult.value = {
            success: false,
            message: `${successCount} synced, ${failCount} failed. ${errors[0]}`,
        };
    }

    // Auto-clear the success toast after 4 seconds
    setTimeout(() => {
        lastSyncResult.value = null;
    }, 4000);
}

// ── Online / Offline listeners ─────────────────────────────────────
function setupListeners() {
    window.addEventListener('online', () => {
        isOnline.value = true;
        // Auto-sync after a short delay when coming back online
        setTimeout(() => syncQueue(), 1500);
    });
    window.addEventListener('offline', () => {
        isOnline.value = false;
    });
    // Refresh count on init
    refreshCount();
}

// Run once on import
setupListeners();

// ── Composable ─────────────────────────────────────────────────────
export function useOfflineQueue() {
    return {
        isOnline: readonly(isOnline),
        pendingCount: readonly(pendingCount),
        isSyncing: readonly(isSyncing),
        lastSyncResult: readonly(lastSyncResult),
        addToQueue,
        syncQueue,
        getQueue,
        clearQueue,
        refreshCount,
    };
}
