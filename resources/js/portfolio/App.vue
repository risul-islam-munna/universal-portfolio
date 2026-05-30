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
import { onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { storeToRefs } from 'pinia';
import { useContentStore } from '@/portfolio/stores/useContentStore';
import { useThemeStore } from '@/portfolio/stores/useThemeStore';
import NavbarSection from '@/portfolio/components/sections/NavbarSection.vue';
import FooterSection from '@/portfolio/components/sections/FooterSection.vue';

const route = useRoute();
const contentStore = useContentStore();
const themeStore = useThemeStore();
const { settings } = storeToRefs(contentStore);

watch(
    settings,
    (s) => {
        if (!s) return;

        if (s.favicon) {
            let link = document.querySelector<HTMLLinkElement>('link[rel="icon"]');
            if (!link) {
                link = document.createElement('link');
                link.rel = 'icon';
                document.head.appendChild(link);
            }
            link.href = s.favicon;
        }

        if (s.site_title) {
            document.title = s.site_title;
        }

        if (s.google_analytics_id && !document.getElementById('ga-script')) {
            // <!-- Google tag (gtag.js) -->
            const gtagScript = document.createElement('script');
            gtagScript.id = 'ga-script';
            gtagScript.async = true;
            gtagScript.src = `https://www.googletagmanager.com/gtag/js?id=${s.google_analytics_id}`;
            document.head.appendChild(gtagScript);

            const inlineScript = document.createElement('script');
            inlineScript.textContent = [
                'window.dataLayer = window.dataLayer || [];',
                'function gtag(){dataLayer.push(arguments);}',
                "gtag('js', new Date());",
                `gtag('config', '${s.google_analytics_id}');`,
            ].join('\n');
            document.head.appendChild(inlineScript);
        }
    },
    { immediate: true },
);

onMounted(async () => {
    await Promise.all([contentStore.loadAll(), themeStore.loadThemes()]);
});
</script>
