<template>
    <nav
        class="fixed top-0 z-50 w-full transition-all duration-300"
        :class="scrolled ? 'border-b shadow-lg' : ''"
        :style="scrolled ? 'background: rgba(15,23,42,0.95); backdrop-filter:blur(12px); border-color: var(--p-border)' : 'background: transparent'"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo -->
                <RouterLink to="/" class="flex items-center gap-2">
                    <img v-if="settings?.logo" :src="settings.logo" alt="Logo" class="h-8 w-auto" />
                    <span v-else class="text-xl font-bold gradient-text">Munna</span>
                </RouterLink>

                <!-- Desktop Nav -->
                <div class="hidden items-center gap-6 md:flex">
                    <a v-for="link in navLinks" :key="link.href" :href="link.href" class="text-sm transition-colors hover:opacity-100" style="color: var(--p-muted)" @click.prevent="scrollTo(link.href)">
                        {{ link.label }}
                    </a>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <!-- Theme switcher -->
                    <div v-if="themeStore.allThemes.length > 1" class="relative" ref="themeMenuRef">
                        <button
                            class="rounded-lg border p-2 text-xs transition-colors"
                            style="border-color: var(--p-border); color: var(--p-muted)"
                            @click="themeMenuOpen = !themeMenuOpen"
                        >
                            🎨
                        </button>
                        <div
                            v-if="themeMenuOpen"
                            class="absolute right-0 mt-2 w-40 rounded-xl border py-1 shadow-xl"
                            style="background: var(--p-surface); border-color: var(--p-border)"
                        >
                            <button
                                v-for="theme in themeStore.allThemes"
                                :key="theme.id"
                                class="w-full px-4 py-2 text-left text-sm hover:opacity-80 transition-opacity"
                                :style="themeStore.activeTheme?.id === theme.id ? 'color: var(--p-primary); font-weight:600' : 'color: var(--p-text)'"
                                @click="themeStore.switchTheme(theme); themeMenuOpen = false"
                            >
                                {{ theme.name }}
                            </button>
                        </div>
                    </div>

                    <!-- Mobile menu toggle -->
                    <button class="md:hidden p-2" style="color: var(--p-text)" @click="mobileOpen = !mobileOpen">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path v-if="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <Transition name="slide-down">
            <div v-if="mobileOpen" class="border-t md:hidden" style="background: rgba(15,23,42,0.98); border-color: var(--p-border)">
                <div class="space-y-1 px-4 py-3">
                    <a
                        v-for="link in navLinks"
                        :key="link.href"
                        :href="link.href"
                        class="block rounded-lg px-3 py-2 text-sm transition-colors"
                        style="color: var(--p-muted)"
                        @click.prevent="scrollTo(link.href); mobileOpen = false"
                    >
                        {{ link.label }}
                    </a>
                </div>
            </div>
        </Transition>
    </nav>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';
import { useContentStore } from '@/portfolio/stores/useContentStore';
import { useThemeStore } from '@/portfolio/stores/useThemeStore';

const router = useRouter();
const themeStore = useThemeStore();
const { settings, skills, services, projects, experience, blog, businessHighlight } = storeToRefs(useContentStore());
const scrolled = ref(false);
const mobileOpen = ref(false);
const themeMenuOpen = ref(false);
const themeMenuRef = ref<HTMLElement | null>(null);

const navLinks = computed(() => {
    const all = [
        { label: 'Home', href: '#hero', show: true },
        { label: 'About', href: '#about', show: true },
        { label: 'Skills', href: '#skills', show: skills.value.length > 0 },
        { label: 'Services', href: '#services', show: services.value.length > 0 },
        { label: 'Portfolio', href: '#portfolio', show: projects.value.length > 0 },
        { label: 'Experience', href: '#experience', show: experience.value.length > 0 },
        { label: 'My Business', href: '#beehook', show: !!businessHighlight.value },
        { label: 'Blog', href: '#blog', show: blog.value.length > 0 },
        { label: 'Contact', href: '#contact', show: true },
    ];

    return all.filter((l) => l.show);
});

function scrollTo(hash: string) {
    const el = document.querySelector(hash);

    if (el) {
        el.scrollIntoView({ behavior: 'smooth' });
    } else {
        router.push({ path: '/', hash });
    }
}

function onScroll() {
    scrolled.value = window.scrollY > 20;
}

function onClickOutside(e: MouseEvent) {
    if (themeMenuRef.value && !themeMenuRef.value.contains(e.target as Node)) {
        themeMenuOpen.value = false;
    }
}

onMounted(() => {
    window.addEventListener('scroll', onScroll);
    document.addEventListener('click', onClickOutside);
});
onUnmounted(() => {
    window.removeEventListener('scroll', onScroll);
    document.removeEventListener('click', onClickOutside);
});
</script>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active {
    transition: all 0.2s ease;
}
.slide-down-enter-from,
.slide-down-leave-to {
    opacity: 0;
    transform: translateY(-8px);
}
</style>
