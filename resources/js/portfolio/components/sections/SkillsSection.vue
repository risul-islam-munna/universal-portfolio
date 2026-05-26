<template>
    <section id="skills" class="section-padding">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <SectionTitle label="Skills" title="Technologies I Work With" subtitle="A curated set of tools and technologies I've mastered over 7 years." />

            <div v-if="loading" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div v-for="i in 6" :key="i" class="skeleton h-40" />
            </div>

            <template v-else>
                <!-- Category tabs -->
                <div class="mb-8 flex flex-wrap justify-center gap-2">
                    <button
                        v-for="cat in categories"
                        :key="cat"
                        class="rounded-full border px-4 py-1.5 text-sm font-medium transition-all"
                        :style="activeCategory === cat
                            ? 'background: var(--p-primary); color: white; border-color: var(--p-primary)'
                            : 'border-color: var(--p-border); color: var(--p-muted)'"
                        @click="activeCategory = cat"
                    >
                        {{ cat }}
                    </button>
                </div>

                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="skill in filteredSkills"
                        :key="skill.id"
                        class="glass-card p-4 transition-transform hover:-translate-y-1"
                    >
                        <div class="mb-3 flex items-center gap-3">
                            <img v-if="skill.icon" :src="skill.icon" :alt="skill.name" class="h-8 w-8 rounded object-contain" loading="lazy" />
                            <div v-else class="flex h-8 w-8 items-center justify-center rounded text-xs font-bold text-white" style="background: var(--p-primary)">
                                {{ skill.name.slice(0, 2).toUpperCase() }}
                            </div>
                            <span class="font-semibold text-white">{{ skill.name }}</span>
                            <span class="ml-auto text-xs font-bold" style="color: var(--p-primary)">{{ skill.proficiency }}%</span>
                        </div>
                        <div class="h-1.5 overflow-hidden rounded-full" style="background: var(--p-border)">
                            <div
                                class="skill-bar-fill h-full rounded-full"
                                style="background: linear-gradient(to right, var(--p-primary), var(--p-accent))"
                                :style="{ width: animated ? skill.proficiency + '%' : '0%' }"
                            />
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { storeToRefs } from 'pinia';
import { useContentStore } from '@/portfolio/stores/useContentStore';
import SectionTitle from '@/portfolio/components/ui/SectionTitle.vue';

const { skills, loading } = storeToRefs(useContentStore());
const activeCategory = ref('All');
const animated = ref(false);

const categories = computed(() => {
    const cats = new Set(skills.value.map((s: any) => s.category));
    return ['All', ...Array.from(cats)];
});

const filteredSkills = computed(() =>
    activeCategory.value === 'All' ? skills.value : skills.value.filter((s: any) => s.category === activeCategory.value),
);

onMounted(() => setTimeout(() => { animated.value = true; }, 300));
</script>
