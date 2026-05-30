<template>
    <footer class="border-t py-10" style="background: var(--p-secondary); border-color: var(--p-border)">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 sm:grid-cols-3">
                <!-- Brand -->
                <div>
                    <div class="mb-3 text-xl font-extrabold gradient-text">{{ settings?.site_title ?? 'Portfolio' }}</div>
                    <p class="text-sm leading-relaxed" style="color: var(--p-muted)">{{ settings?.tagline }}</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="mb-3 font-semibold text-white">Quick Links</h4>
                    <ul class="space-y-1.5">
                        <li v-for="link in navLinks" :key="link.href">
                            <a :href="link.href" class="text-sm transition-colors hover:opacity-100" style="color: var(--p-muted)" @click.prevent="scrollTo(link.href)">{{ link.label }}</a>
                        </li>
                    </ul>
                </div>

                <!-- Social + contact -->
                <div>
                    <h4 class="mb-3 font-semibold text-white">Connect</h4>
                    <div class="flex flex-wrap gap-3">
                        <template v-for="link in (settings?.social_links ?? [])" :key="link.name">
                            <a
                                v-if="link.url"
                                :href="link.url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="social-link"
                                :aria-label="link.name"
                            >
                                <span class="inline-block h-5 w-5" v-html="link.svg_icon" />
                            </a>
                        </template>
                    </div>
                    <div v-if="settings?.contact_email" class="mt-3">
                        <a :href="`mailto:${settings.contact_email}`" class="text-sm hover:opacity-80" style="color: var(--p-muted)">{{ settings.contact_email }}</a>
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t pt-6 text-center text-sm" style="border-color: var(--p-border); color: var(--p-muted)">
                © {{ new Date().getFullYear() }} {{ settings?.site_title ?? 'Portfolio' }}. All rights reserved.
            </div>
        </div>
    </footer>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { computed } from 'vue';
import { useContentStore } from '@/portfolio/stores/useContentStore';

const { settings, skills, services, projects, experience, blog, businessHighlight } = storeToRefs(useContentStore());

const navLinks = computed(() => {
    const all = [
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
}
}
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
