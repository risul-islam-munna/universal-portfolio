<template>
    <section id="portfolio" class="section-padding">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <SectionTitle label="Portfolio" title="Featured Projects" subtitle="A selection of work I'm proud of." />

            <!-- Filter buttons -->
            <div class="mb-8 flex flex-wrap justify-center gap-2">
                <button
                    v-for="cat in categories"
                    :key="cat"
                    class="rounded-full border px-4 py-1.5 text-sm font-medium transition-all"
                    :style="activeFilter === cat
                        ? 'background: var(--p-primary); color: white; border-color: var(--p-primary)'
                        : 'border-color: var(--p-border); color: var(--p-muted)'"
                    @click="activeFilter = cat"
                >
                    {{ cat }}
                </button>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <RouterLink
                    v-for="project in filteredProjects"
                    :key="project.id"
                    :to="`/projects/${project.slug}`"
                    class="glass-card group block overflow-hidden transition-all hover:-translate-y-2 hover:shadow-xl"
                >
                    <!-- Thumbnail -->
                    <div class="relative h-48 overflow-hidden">
                        <img
                            v-if="project.thumbnail"
                            :src="project.thumbnail"
                            :alt="project.title"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                            loading="lazy"
                        />
                        <div v-else class="flex h-full w-full items-center justify-center text-4xl" style="background: var(--p-bg)">🚀</div>
                        <div class="absolute inset-0 flex items-center justify-center gap-3 opacity-0 transition-all duration-300 group-hover:opacity-100" style="background: rgba(0,0,0,0.7)">
                            <span class="rounded-lg px-4 py-2 text-sm font-semibold text-white" style="background: var(--p-primary)">View Details</span>
                        </div>
                        <div v-if="project.is_featured" class="absolute left-3 top-3 rounded-full px-2 py-0.5 text-xs font-bold text-white" style="background: var(--p-primary)">Featured</div>
                    </div>

                    <div class="p-5">
                        <div class="mb-1 text-xs font-medium uppercase" style="color: var(--p-accent)">{{ project.category }}</div>
                        <h3 class="mb-2 font-bold text-white">{{ project.title }}</h3>
                        <p class="mb-4 line-clamp-2 text-sm" style="color: var(--p-muted)">{{ project.description }}</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span
                                v-for="tech in (project.tech_stack || []).slice(0, 4)"
                                :key="tech"
                                class="rounded-md px-2 py-0.5 text-xs"
                                style="background: var(--p-bg); color: var(--p-primary); border: 1px solid var(--p-border)"
                            >{{ tech }}</span>
                        </div>
                    </div>
                </RouterLink>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { storeToRefs } from 'pinia';
import { useContentStore } from '@/portfolio/stores/useContentStore';
import SectionTitle from '@/portfolio/components/ui/SectionTitle.vue';

const { projects } = storeToRefs(useContentStore());
const activeFilter = ref('All');

const categories = computed(() => {
    const cats = new Set((projects.value ?? []).map((p: any) => p.category).filter(Boolean));
    return ['All', ...Array.from(cats)];
});

const filteredProjects = computed(() =>
    activeFilter.value === 'All' ? projects.value : projects.value.filter((p: any) => p.category === activeFilter.value),
);
</script>
