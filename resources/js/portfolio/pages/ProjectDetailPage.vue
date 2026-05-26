<template>
    <div class="min-h-screen pt-24">
        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
            <div v-if="loading" class="space-y-6">
                <div class="skeleton h-10 w-3/4" />
                <div class="skeleton h-64 w-full" />
                <div class="skeleton h-4" />
                <div class="skeleton h-4 w-5/6" />
            </div>

            <div v-else-if="project">
                <!-- Back -->
                <RouterLink to="/#portfolio" class="mb-6 inline-flex items-center gap-2 text-sm transition-colors hover:opacity-80" style="color: var(--p-primary)">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to Portfolio
                </RouterLink>

                <!-- Category & Title -->
                <div class="mb-2 text-sm font-semibold uppercase" style="color: var(--p-accent)">{{ project.category }}</div>
                <h1 class="mb-6 text-3xl font-extrabold text-white md:text-4xl">{{ project.title }}</h1>

                <!-- Main thumbnail -->
                <div class="mb-8 overflow-hidden rounded-2xl">
                    <img v-if="project.thumbnail" :src="project.thumbnail" :alt="project.title" class="h-72 w-full object-cover md:h-96" />
                </div>

                <!-- Gallery -->
                <div v-if="project.gallery?.length" class="mb-8 grid grid-cols-2 gap-3 sm:grid-cols-3">
                    <img v-for="(img, i) in project.gallery" :key="i" :src="img" :alt="`Gallery ${i + 1}`" class="cursor-pointer rounded-xl object-cover transition hover:opacity-80" style="height:140px; width:100%" loading="lazy" @click="lightbox = img" />
                </div>

                <!-- Lightbox -->
                <Transition name="fade">
                    <div v-if="lightbox" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.9)" @click="lightbox = null">
                        <img :src="lightbox" alt="Full size" class="max-h-[90vh] max-w-full rounded-xl object-contain" />
                    </div>
                </Transition>

                <div class="grid gap-8 lg:grid-cols-3">
                    <!-- Description -->
                    <div class="lg:col-span-2">
                        <h2 class="mb-3 text-xl font-bold text-white">About this project</h2>
                        <div class="prose prose-invert max-w-none text-base leading-relaxed" style="color: var(--p-muted)" v-html="project.description?.replace(/\n/g, '<br>')" />
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Tech Stack -->
                        <div class="glass-card p-5">
                            <h3 class="mb-3 font-semibold text-white">Tech Stack</h3>
                            <div class="flex flex-wrap gap-2">
                                <span v-for="tech in project.tech_stack" :key="tech" class="rounded-lg px-3 py-1 text-sm" style="background: var(--p-bg); color: var(--p-primary); border: 1px solid var(--p-border)">{{ tech }}</span>
                            </div>
                        </div>

                        <!-- Links -->
                        <div class="glass-card p-5 space-y-3">
                            <h3 class="mb-3 font-semibold text-white">Links</h3>
                            <a v-if="project.project_url" :href="project.project_url" target="_blank" class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold text-white transition-all hover:scale-105" style="background: linear-gradient(135deg, var(--p-primary), var(--p-accent))">
                                🌐 Live Demo
                            </a>
                            <a v-if="project.github_url" :href="project.github_url" target="_blank" class="flex items-center gap-2 rounded-xl border px-4 py-2.5 text-sm font-semibold transition-all hover:scale-105" style="border-color: var(--p-border); color: var(--p-text)">
                                🐙 GitHub
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="text-center py-20" style="color: var(--p-muted)">Project not found.</div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useApi } from '@/portfolio/composables/useApi';

const route = useRoute();
const { get } = useApi();
const project = ref<any>(null);
const loading = ref(true);
const lightbox = ref<string | null>(null);

onMounted(async () => {
    try {
        const data = await get<any>(`/projects/${route.params.slug}`);
        project.value = data;
    } catch {
        project.value = null;
    } finally {
        loading.value = false;
    }
});
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
