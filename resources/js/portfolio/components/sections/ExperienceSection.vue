<template>
    <section id="experience" class="section-padding" style="background: var(--p-surface)">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <SectionTitle label="Journey" title="Experience & Education" />

            <!-- Tab switcher -->
            <div class="mb-10 flex justify-center gap-2">
                <button
                    v-for="tab in tabs"
                    :key="tab"
                    class="rounded-xl px-6 py-2.5 font-semibold transition-all"
                    :style="activeTab === tab
                        ? 'background: var(--p-primary); color: white'
                        : 'background: var(--p-bg); color: var(--p-muted)'"
                    @click="activeTab = tab"
                >
                    {{ tab }}
                </button>
            </div>

            <!-- Timeline -->
            <div class="relative mx-auto max-w-3xl">
                <div class="absolute left-6 top-0 h-full w-px md:left-1/2" style="background: var(--p-border)" />

                <!-- Experience timeline -->
                <template v-if="activeTab === 'Work'">
                    <div
                        v-for="(item, i) in experience"
                        :key="item.id"
                        class="relative mb-8 pl-16 md:pl-0"
                        :class="i % 2 === 0 ? 'md:pr-[calc(50%+2rem)]' : 'md:pl-[calc(50%+2rem)]'"
                    >
                        <!-- Dot -->
                        <div class="absolute left-4 top-5 h-4 w-4 rounded-full border-2 md:left-1/2 md:-translate-x-1/2" style="background: var(--p-primary); border-color: var(--p-bg)" />

                        <div class="glass-card p-5">
                            <div class="mb-1 text-xs font-medium" style="color: var(--p-accent)">
                                {{ item.start_date }} — {{ item.is_current ? 'Present' : item.end_date }}
                            </div>
                            <h3 class="font-bold text-white">{{ item.role }}</h3>
                            <p class="text-sm font-medium" style="color: var(--p-primary)">{{ item.company_name }}</p>
                            <p v-if="item.description" class="mt-2 text-sm leading-relaxed" style="color: var(--p-muted)">{{ item.description }}</p>
                        </div>
                    </div>
                </template>

                <!-- Education timeline -->
                <template v-else>
                    <div
                        v-for="(item, i) in education"
                        :key="item.id"
                        class="relative mb-8 pl-16 md:pl-0"
                        :class="i % 2 === 0 ? 'md:pr-[calc(50%+2rem)]' : 'md:pl-[calc(50%+2rem)]'"
                    >
                        <div class="absolute left-4 top-5 h-4 w-4 rounded-full border-2 md:left-1/2 md:-translate-x-1/2" style="background: var(--p-accent); border-color: var(--p-bg)" />

                        <div class="glass-card p-5">
                            <div class="mb-1 text-xs font-medium" style="color: var(--p-primary)">
                                {{ item.start_year }} — {{ item.end_year ?? 'Present' }}
                            </div>
                            <h3 class="font-bold text-white">{{ item.degree }}</h3>
                            <p class="text-sm font-medium" style="color: var(--p-accent)">{{ item.institution_name }}</p>
                            <p v-if="item.field_of_study" class="mt-1 text-xs" style="color: var(--p-muted)">{{ item.field_of_study }}</p>
                            <p v-if="item.description" class="mt-2 text-sm leading-relaxed" style="color: var(--p-muted)">{{ item.description }}</p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { ref } from 'vue';
import SectionTitle from '@/portfolio/components/ui/SectionTitle.vue';
import { useContentStore } from '@/portfolio/stores/useContentStore';

const { experience, education } = storeToRefs(useContentStore());
const tabs = ['Work', 'Education'];
const activeTab = ref('Work');
</script>
