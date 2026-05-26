<template>
    <section id="services" class="section-padding" style="background: var(--p-surface)">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <SectionTitle label="Services" title="What I Offer" subtitle="From concept to deployment — I deliver end-to-end digital solutions." />

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="service in services"
                    :key="service.id"
                    class="glass-card group p-6 transition-all hover:-translate-y-2 hover:shadow-xl"
                    :style="service.is_featured ? 'border-color: var(--p-primary)' : ''"
                >
                    <div v-if="service.is_featured" class="mb-4 inline-block rounded-full px-3 py-1 text-xs font-semibold text-white" style="background: var(--p-primary)">Featured</div>
                    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl text-3xl" style="background: var(--p-bg)">
                        {{ service.icon || '💡' }}
                    </div>
                    <h3 class="mb-2 text-lg font-bold text-white">{{ service.title }}</h3>
                    <p class="text-sm leading-relaxed" style="color: var(--p-muted)">{{ service.description }}</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { useContentStore } from '@/portfolio/stores/useContentStore';
import SectionTitle from '@/portfolio/components/ui/SectionTitle.vue';

const { services } = storeToRefs(useContentStore());
</script>
