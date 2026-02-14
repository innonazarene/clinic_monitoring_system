<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { formatDate, formatTime } from '@/utils/dateFormat';

const props = defineProps({
    logs: Object,
    medicines: Array,
    filters: Object,
});

const medicineId = ref(props.filters?.medicine_id || '');
const patientType = ref(props.filters?.patient_type || '');
const dateFrom = ref(props.filters?.date_from || '');
const dateTo = ref(props.filters?.date_to || '');

const applyFilters = () => {
    router.get(route('medicines.logs'), {
        medicine_id: medicineId.value || undefined,
        patient_type: patientType.value || undefined,
        date_from: dateFrom.value || undefined,
        date_to: dateTo.value || undefined,
    }, { preserveState: true, preserveScroll: true });
};
</script>

<template>
    <Head title="Medicine Log Book" />
    <AuthenticatedLayout>
        <template #header>Medicine Log Book</template>

        <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <select v-model="medicineId" @change="applyFilters" class="text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500">
                    <option value="">All Medicines</option>
                    <option v-for="m in medicines" :key="m.id" :value="m.id">{{ m.name }}</option>
                </select>
                <select v-model="patientType" @change="applyFilters" class="text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500">
                    <option value="">All Types</option>
                    <option value="student">Student</option>
                    <option value="personnel">Personnel</option>
                </select>
                <input v-model="dateFrom" @change="applyFilters" type="date" class="text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500" placeholder="From" />
                <input v-model="dateTo" @change="applyFilters" type="date" class="text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500" placeholder="To" />
            </div>
            <Link :href="route('medicines.index')" class="text-sm text-navy-600 hover:text-navy-800 font-medium">← Back to Inventory</Link>
        </div>

        <div class="grid grid-cols-1 gap-6">
            <!-- Medicine Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-navy-800 text-white">
                            <th class="px-4 py-3 text-left font-medium text-xs uppercase">Date</th>
                                <th class="px-4 py-3 text-left font-medium text-xs uppercase">Medicine</th>
                                <th class="px-4 py-3 text-left font-medium text-xs uppercase">Qty</th>
                                <th class="px-4 py-3 text-left font-medium text-xs uppercase">Patient</th>
                                <th class="px-4 py-3 text-left font-medium text-xs uppercase">Type</th>
                                <th class="px-4 py-3 text-left font-medium text-xs uppercase">Dispensed By</th>
                                <th class="px-4 py-3 text-left font-medium text-xs uppercase">Notes</th>
                                <th class="px-4 py-3 text-left font-medium text-xs uppercase">Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr v-for="log in logs.data" :key="log.id" class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-4 py-3 text-gray-600 text-xs whitespace-nowrap">{{ formatDate(log.dispensed_at) }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ log.medicine?.name }}</td>
                                <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs font-bold bg-mustard-100 text-mustard-800">{{ log.quantity }}</span></td>
                                <td class="px-4 py-3 text-gray-700">{{ log.patient_name }}</td>
                                <td class="px-4 py-3"><span :class="log.patient_type_label === 'Student' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700'" class="text-xs px-2 py-0.5 rounded-full font-medium">{{ log.patient_type_label }}</span></td>
                                <td class="px-4 py-3 text-gray-600">{{ log.dispenser?.name }}</td>
                                <td class="px-4 py-3 text-gray-400 text-xs truncate max-w-xs">{{ log.notes || '-' }}</td>
                                <td class="px-4 py-3 text-gray-500 text-xs whitespace-nowrap">{{ formatTime(log.dispensed_at) }}</td>
                            </tr>
                            <tr v-if="!logs.data?.length"><td colspan="8" class="px-4 py-12 text-center text-gray-400">No dispensing records</td></tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="logs.links?.length > 3" class="px-4 py-3 border-t border-gray-100 flex items-center justify-between">
                    <p class="text-xs text-gray-500">{{ logs.from }}–{{ logs.to }} of {{ logs.total }}</p>
                    <div class="flex gap-1">
                        <template v-for="link in logs.links" :key="link.label">
                            <Link v-if="link.url" :href="link.url" :class="link.active ? 'bg-navy-800 text-white' : 'bg-gray-50 text-gray-600'" class="px-3 py-1 rounded-lg text-xs font-medium" v-html="link.label" />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
