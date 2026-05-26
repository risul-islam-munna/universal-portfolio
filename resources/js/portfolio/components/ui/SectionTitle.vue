<template>
    <div class="mb-12 text-center">
        <p class="mb-2 text-sm font-semibold uppercase tracking-widest" style="color: var(--p-primary)">{{ label }}</p>
        <h2 class="text-3xl font-bold text-white md:text-4xl">{{ title }}</h2>
        <div class="mx-auto mt-4 h-1 w-16 rounded-full" style="background: linear-gradient(to right, var(--p-primary), var(--p-accent))"></div>
        <p v-if="subtitle" class="mx-auto mt-4 max-w-2xl" style="color: var(--p-muted)">{{ subtitle }}</p>
    </div>
</template>

<script setup lang="ts">
defineProps<{ label: string; title: string; subtitle?: string }>();
</script>
