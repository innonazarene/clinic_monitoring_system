/**
 * Shared date/time formatting utilities.
 * Converts ISO date strings (e.g. "2027-12-13T00:00:00.000000Z")
 * into human-readable formats.
 */

/**
 * Format a date string to "Feb 14, 2026" style.
 * @param {string|null} datetime
 * @returns {string}
 */
export function formatDate(datetime) {
    if (!datetime) return '-';
    const d = new Date(datetime);
    if (isNaN(d.getTime())) return datetime;
    return d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

/**
 * Format a time string to "8:17 AM" style.
 * @param {string|null} datetime
 * @returns {string}
 */
export function formatTime(datetime) {
    if (!datetime) return '-';
    const d = new Date(datetime);
    if (isNaN(d.getTime())) return datetime;
    return d.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
}

/**
 * Format a datetime string to "Feb 14, 2026 8:17 AM" style.
 * @param {string|null} datetime
 * @returns {string}
 */
export function formatDateTime(datetime) {
    if (!datetime) return '-';
    const d = new Date(datetime);
    if (isNaN(d.getTime())) return datetime;
    return d.toLocaleDateString('en-US', {
        year: 'numeric', month: 'short', day: 'numeric',
        hour: 'numeric', minute: '2-digit', hour12: true,
    });
}
