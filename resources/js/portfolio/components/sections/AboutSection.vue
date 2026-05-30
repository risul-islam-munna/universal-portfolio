<template>
    <section id="about" class="section-padding" style="background: var(--p-surface)">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <SectionTitle label="About Me" title="Passionate Developer & Entrepreneur" subtitle="Building products that matter, one line of code at a time." />

            <div class="grid items-center gap-12 lg:grid-cols-2">
                <!-- Photo -->
                <div class="flex justify-center">
                    <div class="relative">
                        <div class="absolute -inset-3 rounded-2xl opacity-20 blur-xl" style="background: var(--p-primary)" />
                        <div class="relative h-80 w-80 overflow-hidden rounded-2xl border" style="border-color: var(--p-border)">
                            <img v-if="about?.profile_photo" :src="about.profile_photo" alt="Profile" class="h-full w-full object-cover" loading="lazy" />
                            <div v-else class="flex h-full w-full items-center justify-center text-8xl font-bold gradient-text" style="background: var(--p-bg)">M</div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="space-y-6">
                    <div class="prose prose-invert max-w-none">
                        <p class="text-base leading-relaxed md:text-lg" style="color: var(--p-muted)">
                            {{ about?.bio || 'Full-stack developer with 7 years of experience building scalable web & mobile applications. Founder of Bee Hook — an e-commerce SaaS platform. Passionate about clean code, DevOps automation, and AI-powered tools.' }}
                        </p>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4">
                        <div v-for="stat in stats" :key="stat.label" class="glass-card p-4 text-center">
                            <div class="text-3xl font-extrabold gradient-text">{{ stat.value }}+</div>
                            <div class="mt-1 text-xs" style="color: var(--p-muted)">{{ stat.label }}</div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <a
                            v-if="about?.cv_url"
                            :href="about.cv_url"
                            download
                            class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 font-semibold text-white transition-all hover:scale-105"
                            style="background: linear-gradient(135deg, var(--p-primary), var(--p-accent))"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download CV
                        </a>
                        <a href="#contact" class="inline-flex items-center gap-2 rounded-xl border px-5 py-2.5 font-semibold transition-all hover:scale-105" style="border-color: var(--p-border); color: var(--p-text)" @click.prevent="scrollTo('#contact')">
                            Hire Me
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { computed } from 'vue';
import SectionTitle from '@/portfolio/components/ui/SectionTitle.vue';
import { useContentStore } from '@/portfolio/stores/useContentStore';

const { about } = storeToRefs(useContentStore());

const stats = computed(() => [
    { label: 'Years Experience', value: about.value?.stats?.years_experience ?? 7 },
    { label: 'Projects Completed', value: about.value?.stats?.projects_completed ?? 150 },
    { label: 'Clients Served', value: about.value?.stats?.clients_served ?? 80 },
    { label: 'Technologies Used', value: about.value?.stats?.technologies_used ?? 30 },
]);

function scrollTo(hash: string) {
    const el = document.querySelector(hash);

    if (el) {
el.scrollIntoView({ behavior: 'smooth' });
}
}
</script>
