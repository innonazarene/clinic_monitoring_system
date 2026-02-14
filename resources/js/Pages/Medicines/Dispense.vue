<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SearchablePatientSelect from '@/Components/SearchablePatientSelect.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    medicines: Array,
    students: Array,
    personnel: Array,
    departments: Array,
});

const form = useForm({
    medicine_id: '',
    patient_type: 'student',
    patient_id: '',
    quantity: 1,
    notes: '',
});

const selectedMedicine = computed(() => props.medicines.find(m => m.id == form.medicine_id));
const patientList = computed(() => form.patient_type === 'student' ? props.students : props.personnel);

const submit = () => {
    form.post(route('medicines.dispense'));
};
</script>

<template>
    <Head title="Dispense Medicine" />
    <AuthenticatedLayout>
        <template #header>Dispense Medicine</template>

        <form @submit.prevent="submit" class="w-full">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-mustard-500">
                    <h3 class="text-sm font-bold text-navy-900 uppercase tracking-wider">Dispense Form</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Medicine *</label>
                        <select v-model="form.medicine_id" required class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500">
                            <option value="">Select Medicine</option>
                            <option v-for="m in medicines" :key="m.id" :value="m.id">{{ m.name }} ({{ m.stock_quantity }} {{ m.unit }} available)</option>
                        </select>
                    </div>

                    <div v-if="selectedMedicine" class="p-3 rounded-lg bg-blue-50 border border-blue-100 text-sm">
                        <p class="font-medium text-blue-800">{{ selectedMedicine.name }}</p>
                        <p class="text-blue-600 text-xs">Available: {{ selectedMedicine.stock_quantity }} {{ selectedMedicine.unit }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Patient Type *</label>
                            <select v-model="form.patient_type" @change="form.patient_id = ''" class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500">
                                <option value="student">Student</option>
                                <option value="personnel">Personnel</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Patient *</label>
                            <SearchablePatientSelect
                                v-model="form.patient_id"
                                :patients="patientList"
                                :departments="departments"
                                :patient-type="form.patient_type"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Quantity *</label>
                        <input v-model="form.quantity" type="number" min="1" :max="selectedMedicine?.stock_quantity || 9999" required class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500" />
                        <p v-if="form.errors.quantity" class="text-xs text-red-500 mt-1">{{ form.errors.quantity }}</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Notes</label>
                        <textarea v-model="form.notes" rows="2" class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500"></textarea>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 mt-6">
                <a :href="route('medicines.index')" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancel</a>
                <button type="submit" :disabled="form.processing" class="px-6 py-2.5 text-sm font-bold text-white rounded-lg shadow-sm hover:shadow-md disabled:opacity-50 transition-all" style="background: linear-gradient(135deg, #d4a017, #f0c040); color: #0f1b35;">
                    {{ form.processing ? 'Dispensing...' : 'Dispense Medicine' }}
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
