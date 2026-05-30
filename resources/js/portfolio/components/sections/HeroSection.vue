<template>
    <section id="hero" class="relative flex min-h-screen items-center overflow-hidden">
        <!-- Background gradient -->
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute left-1/4 top-1/4 h-96 w-96 -translate-x-1/2 -translate-y-1/2 rounded-full opacity-20 blur-3xl" style="background: var(--p-primary)" />
            <div class="absolute right-1/4 bottom-1/4 h-96 w-96 translate-x-1/2 translate-y-1/2 rounded-full opacity-10 blur-3xl" style="background: var(--p-accent)" />
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-32 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <!-- Text Content -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="h-px w-12" style="background: var(--p-primary)" />
                        <span class="text-sm font-medium uppercase tracking-widest" style="color: var(--p-primary)">Welcome</span>
                    </div>

                    <div>
                        <p class="text-lg font-medium" style="color: var(--p-muted)">Hi, I'm</p>
                        <h1 class="text-4xl font-extrabold tracking-tight text-white md:text-5xl lg:text-6xl">
                            {{ hero?.name || 'Md. Risul Islam Munna' }}
                        </h1>
                        <div class="mt-2 flex h-10 items-center gap-2">
                            <span class="text-xl font-semibold md:text-2xl" style="color: var(--p-primary)">{{ currentRole }}</span>
                            <span class="typing-cursor text-xl" style="color: var(--p-accent)" />
                        </div>
                    </div>

                    <p class="max-w-lg text-base leading-relaxed md:text-lg" style="color: var(--p-muted)">
                        {{ hero?.bio || '7 years of crafting exceptional digital experiences — from full-stack web apps to mobile solutions and cloud infrastructure.' }}
                    </p>

                    <div class="flex flex-wrap items-center gap-4">
                        <a
                            :href="hero?.cta_link || '#contact'"
                            class="inline-flex items-center gap-2 rounded-xl px-6 py-3 font-semibold text-white transition-all hover:scale-105 hover:shadow-lg"
                            style="background: linear-gradient(135deg, var(--p-primary), var(--p-accent))"
                            @click.prevent="scrollTo(hero?.cta_link || '#contact')"
                        >
                            {{ hero?.cta_label || 'Hire Me' }}
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </a>
                        <a
                            v-if="hero?.resume_url"
                            :href="hero.resume_url"
                            download
                            class="inline-flex items-center gap-2 rounded-xl border px-6 py-3 font-semibold transition-all hover:scale-105"
                            style="border-color: var(--p-border); color: var(--p-text)"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            Download CV
                        </a>
                    </div>

                    <!-- Social Icons -->
                    <div class="flex flex-wrap items-center gap-4">
                        <template v-for="link in (settings?.social_links ?? [])" :key="link.name">
                            <a v-if="link.url" :href="link.url" target="_blank" rel="noopener noreferrer" class="social-link" :aria-label="link.name">
                                <span class="inline-block h-5 w-5" v-html="link.svg_icon" />
                            </a>
                        </template>
                    </div>
                </div>

                <!-- Profile Photo -->
                <div class="flex justify-center lg:justify-end">
                    <div class="relative">
                        <div class="absolute -inset-4 rounded-full opacity-30 blur-2xl" style="background: linear-gradient(135deg, var(--p-primary), var(--p-accent))" />
                        <div class="relative h-72 w-72 overflow-hidden rounded-full border-4 md:h-96 md:w-96" style="border-color: var(--p-primary)">
                            <img
                                v-if="hero?.profile_photo"
                                :src="hero.profile_photo"
                                :alt="hero?.name"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            />
                            <div v-else class="flex h-full w-full items-center justify-center text-6xl font-bold gradient-text" style="background: var(--p-surface)">M</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="h-6 w-6" style="color: var(--p-muted)" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </section>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { useContentStore } from '@/portfolio/stores/useContentStore';

const { hero, settings } = storeToRefs(useContentStore());

const currentRole = ref('');
const roleIndex = ref(0);
const charIndex = ref(0);
const isDeleting = ref(false);
let timer: ReturnType<typeof setTimeout>;

const roles = computed(() => hero.value?.typing_roles?.length ? hero.value.typing_roles : ['Laravel Developer', 'Vue.js Developer', 'DevOps Engineer', 'Flutter Developer']);

function typeRole() {
    const role = roles.value[roleIndex.value % roles.value.length];

    if (!isDeleting.value) {
        currentRole.value = role.slice(0, charIndex.value + 1);
        charIndex.value++;

        if (charIndex.value === role.length) {
            isDeleting.value = true;
            timer = setTimeout(typeRole, 1800);

            return;
        }
    } else {
        currentRole.value = role.slice(0, charIndex.value - 1);
        charIndex.value--;

        if (charIndex.value === 0) {
            isDeleting.value = false;
            roleIndex.value++;
        }
    }

    timer = setTimeout(typeRole, isDeleting.value ? 60 : 100);
}

function scrollTo(hash: string) {
    const el = document.querySelector(hash);

    if (el) {
el.scrollIntoView({ behavior: 'smooth' });
}
}

onMounted(() => {
 timer = setTimeout(typeRole, 500); 
});
onUnmounted(() => clearTimeout(timer));
</script>

<style scoped>
.social-link {
    color: var(--p-muted);
    transition: color 0.2s, transform 0.2s;
}
.social-link:hover {
    color: var(--p-primary);
    transform: scale(1.15);
}
</style>
