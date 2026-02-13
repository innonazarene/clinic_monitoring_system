<script setup>
import Form from './Form.vue';
defineProps({ personnel: Object, departments: Array });
</script>
<template><Form :personnel="personnel" :departments="departments" /></template>
