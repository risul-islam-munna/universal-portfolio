<template>
    <div class="min-h-screen" style="background: var(--p-bg); color: var(--p-text)">
        <NavbarSection />
        <Transition name="page" mode="out-in">
            <RouterView :key="route.fullPath" />
        </Transition>
        <FooterSection />
    </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useContentStore } from '@/portfolio/stores/useContentStore';
import { useThemeStore } from '@/portfolio/stores/useThemeStore';
import NavbarSection from '@/portfolio/components/sections/NavbarSection.vue';
import FooterSection from '@/portfolio/components/sections/FooterSection.vue';

const route = useRoute();
const contentStore = useContentStore();
const themeStore = useThemeStore();

onMounted(async () => {
    await Promise.all([contentStore.loadAll(), themeStore.loadThemes()]);
});
</script>
