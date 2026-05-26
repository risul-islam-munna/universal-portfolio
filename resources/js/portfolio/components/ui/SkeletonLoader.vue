<template>
    <div class="animate-pulse space-y-4">
        <div v-for="i in lines" :key="i" class="skeleton h-4" :style="{ width: i % 3 === 0 ? '60%' : '100%' }" />
    </div>
</template>

<script setup lang="ts">
defineProps<{ lines?: number }>();
</script>
