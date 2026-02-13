<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({ medicine: { type: Object, default: null } });
const isEdit = computed(() => !!props.medicine);

const form = useForm({
    name: props.medicine?.name || '',
    description: props.medicine?.description || '',
    category: props.medicine?.category || '',
    unit: props.medicine?.unit || '',
    stock_quantity: props.medicine?.stock_quantity ?? 0,
    reorder_level: props.medicine?.reorder_level ?? 10,
    expiry_date: props.medicine?.expiry_date ? props.medicine.expiry_date.split('T')[0] : '',
});

const submit = () => {
    if (isEdit.value) form.put(route('medicines.update', props.medicine.id));
    else form.post(route('medicines.store'));
};
</script>

<template>
    <Head :title="isEdit ? 'Edit Medicine' : 'Add Medicine'" />
    <AuthenticatedLayout>
        <template #header>{{ isEdit ? 'Edit Medicine' : 'Add New Medicine' }}</template>

        <form @submit.prevent="submit">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-navy-800">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Medicine Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Medicine Name *</label>
                        <input v-model="form.name" type="text" required class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500" />
                        <p v-if="form.errors.name" class="text-xs text-red-500 mt-1">{{ form.errors.name }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Description</label>
                        <textarea v-model="form.description" rows="2" class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Category</label>
                            <input v-model="form.category" type="text" placeholder="e.g., Analgesic" class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Unit *</label>
                            <select v-model="form.unit" required class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500">
                                <option value="">Select</option>
                                <option value="tablet">Tablet</option>
                                <option value="capsule">Capsule</option>
                                <option value="bottle">Bottle</option>
                                <option value="sachet">Sachet</option>
                                <option value="ml">ml</option>
                                <option value="piece">Piece</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Stock Quantity *</label>
                            <input v-model="form.stock_quantity" type="number" min="0" required class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Reorder Level</label>
                            <input v-model="form.reorder_level" type="number" min="0" class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Expiry Date</label>
                            <input v-model="form.expiry_date" type="date" class="w-full text-sm rounded-lg border-gray-200 focus:ring-mustard-500 focus:border-mustard-500" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 mt-6">
                <a :href="route('medicines.index')" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancel</a>
                <button type="submit" :disabled="form.processing" class="px-6 py-2.5 text-sm font-bold text-white rounded-lg shadow-sm hover:shadow-md disabled:opacity-50 transition-all" style="background: linear-gradient(135deg, #1b2a4a, #2d4a7a);">
                    {{ form.processing ? 'Saving...' : (isEdit ? 'Update Medicine' : 'Add Medicine') }}
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
