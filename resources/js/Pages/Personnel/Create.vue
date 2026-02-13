<script setup>
import Form from './Form.vue';
defineProps({ departments: Array });
</script>
<template><Form :departments="departments" /></template>
