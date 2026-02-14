<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SearchablePatientSelect from '@/Components/SearchablePatientSelect.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    students: Array,
    personnel: Array,
    departments: Array,
});

const form = useForm({
    patient_type: 'student',
    patient_id: '',
    diagnosis: '',
    treatment_given: '',
    medication_given: '',
    notes: '',
    status: 'completed',
});

const patientList = computed(() => form.patient_type === 'student' ? props.students : props.personnel);

const submit = () => form.post(route('treatments.store'));
</script>

<template>
    <Head title="Record Treatment" />
    <AuthenticatedLayout>
        <template #header>Record New Treatment</template>

        <form @submit.prevent="submit" class="w-full">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-navy-800">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Treatment Form</h3>
                </div>
                <div class="p-6 space-y-4">
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
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Diagnosis *</label>
                        <input v-model="form.diagnosis" type="text" required placeholder="e.g., Headache, Fever, Cough" class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Treatment Given</label>
                        <textarea v-model="form.treatment_given" rows="2" placeholder="Describe the treatment provided" class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Medication Given</label>
                        <input v-model="form.medication_given" type="text" placeholder="e.g., Biogesic 500mg x 2" class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Notes</label>
                        <textarea v-model="form.notes" rows="2" class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
                        <select v-model="form.status" class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500">
                            <option value="completed">Completed</option>
                            <option value="follow-up">Follow-up Required</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 mt-6">
                <a :href="route('treatments.index')" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancel</a>
                <button type="submit" :disabled="form.processing" class="px-6 py-2.5 text-sm font-bold text-white rounded-lg shadow-sm hover:shadow-md disabled:opacity-50 transition-all" style="background: linear-gradient(135deg, #1b2a4a, #2d4a7a);">
                    {{ form.processing ? 'Saving...' : 'Record Treatment' }}
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
