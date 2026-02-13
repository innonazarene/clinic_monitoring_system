<script setup>
import Create from './Create.vue';
defineProps({ medicine: Object });
</script>
<template><Create :medicine="medicine" /></template>
