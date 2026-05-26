<template>
    <section v-if="biz" id="beehook" class="section-padding relative overflow-hidden">
        <!-- Background decoration -->
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute left-0 top-0 h-full w-1/2 opacity-5" style="background: linear-gradient(to right, var(--p-accent), transparent)" />
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <SectionTitle label="My Business" title="Bee Hook" :subtitle="biz.tagline || 'E-commerce SaaS for automating online businesses'" />

            <div class="grid items-center gap-12 lg:grid-cols-2">
                <!-- Info -->
                <div class="space-y-6">
                    <div v-if="biz.logo" class="mb-4">
                        <img :src="biz.logo" alt="Bee Hook" class="h-16 w-auto" />
                    </div>

                    <p class="text-base leading-relaxed md:text-lg" style="color: var(--p-muted)">{{ biz.description }}</p>

                    <!-- Features -->
                    <div v-if="biz.features?.length" class="space-y-3">
                        <div v-for="(f, i) in biz.features" :key="i" class="flex items-start gap-3">
                            <div class="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-full text-xs text-white" style="background: var(--p-accent)">✓</div>
                            <div>
                                <span class="font-semibold text-white">{{ f.title }}</span>
                                <span v-if="f.description" class="ml-2 text-sm" style="color: var(--p-muted)">— {{ f.description }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Links -->
                    <div class="flex flex-wrap gap-3">
                        <a
                            v-if="biz.website_url"
                            :href="biz.website_url"
                            target="_blank"
                            class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 font-semibold text-white transition-all hover:scale-105"
                            style="background: linear-gradient(135deg, var(--p-accent), var(--p-primary))"
                        >
                            🌐 Visit Website
                        </a>
                        <a v-if="biz.play_store_link" :href="biz.play_store_link" target="_blank" class="inline-flex items-center gap-2 rounded-xl border px-5 py-2.5 font-semibold transition-all hover:scale-105" style="border-color: var(--p-border); color: var(--p-text)">
                            📱 Play Store
                        </a>
                        <a v-if="biz.app_store_link" :href="biz.app_store_link" target="_blank" class="inline-flex items-center gap-2 rounded-xl border px-5 py-2.5 font-semibold transition-all hover:scale-105" style="border-color: var(--p-border); color: var(--p-text)">
                            🍎 App Store
                        </a>
                    </div>
                </div>

                <!-- Screenshots Carousel -->
                <div v-if="biz.screenshots?.length" class="relative overflow-hidden rounded-2xl">
                    <div class="flex transition-transform duration-500" :style="{ transform: `translateX(-${current * 100}%)` }">
                        <img
                            v-for="(src, i) in biz.screenshots"
                            :key="i"
                            :src="src"
                            :alt="`Screenshot ${i + 1}`"
                            class="min-w-full rounded-2xl object-cover"
                            loading="lazy"
                        />
                    </div>
                    <div class="mt-4 flex justify-center gap-2">
                        <button
                            v-for="(_, i) in biz.screenshots"
                            :key="i"
                            class="h-2 w-2 rounded-full transition-all"
                            :style="current === i ? 'background: var(--p-primary); width: 1.5rem' : 'background: var(--p-border)'"
                            @click="current = i"
                        />
                    </div>
                </div>
                <div v-else class="flex h-64 items-center justify-center rounded-2xl text-6xl" style="background: var(--p-surface)">🐝</div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { storeToRefs } from 'pinia';
import { useContentStore } from '@/portfolio/stores/useContentStore';
import SectionTitle from '@/portfolio/components/ui/SectionTitle.vue';

const { businessHighlight: biz } = storeToRefs(useContentStore());
const current = ref(0);
let autoplay: ReturnType<typeof setInterval>;

onMounted(() => {
    autoplay = setInterval(() => {
        if (biz.value?.screenshots?.length) {
            current.value = (current.value + 1) % biz.value.screenshots.length;
        }
    }, 3500);
});
onUnmounted(() => clearInterval(autoplay));
</script>
