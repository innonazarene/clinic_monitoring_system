<script setup>
import Form from './Form.vue';

defineProps({ student: Object, departments: Array });
</script>

<template>
    <Form :student="student" :departments="departments" />
</template>
