<template>
    <section id="blog" class="section-padding">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <SectionTitle label="Blog" title="Latest Articles" subtitle="Thoughts on development, DevOps, and entrepreneurship." />

            <div v-if="!latestPosts.length" class="text-center" style="color: var(--p-muted)">No posts yet.</div>

            <div v-else class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <RouterLink
                    v-for="post in latestPosts"
                    :key="post.id"
                    :to="`/blog/${post.slug}`"
                    class="glass-card group block overflow-hidden transition-all hover:-translate-y-2 hover:shadow-xl"
                >
                    <div class="relative h-48 overflow-hidden">
                        <img v-if="post.cover_image" :src="post.cover_image" :alt="post.title" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy" />
                        <div v-else class="flex h-full w-full items-center justify-center text-4xl" style="background: var(--p-bg)">📝</div>
                    </div>
                    <div class="p-5">
                        <div class="mb-2 flex flex-wrap gap-1">
                            <span v-for="tag in (post.tags || []).slice(0, 2)" :key="tag" class="rounded-md px-2 py-0.5 text-xs" style="background: var(--p-bg); color: var(--p-accent); border: 1px solid var(--p-border)">{{ tag }}</span>
                        </div>
                        <h3 class="mb-2 font-bold text-white leading-snug group-hover:text-blue-400 transition-colors">{{ post.title }}</h3>
                        <p class="text-xs" style="color: var(--p-muted)">{{ formatDate(post.published_at) }}</p>
                    </div>
                </RouterLink>
            </div>

            <div v-if="blog.length > 3" class="mt-10 text-center">
                <RouterLink to="/blog" class="inline-flex items-center gap-2 rounded-xl border px-6 py-3 font-semibold transition-all hover:scale-105" style="border-color: var(--p-border); color: var(--p-text)">
                    View All Posts
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </RouterLink>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { computed } from 'vue';
import SectionTitle from '@/portfolio/components/ui/SectionTitle.vue';
import { useContentStore } from '@/portfolio/stores/useContentStore';

const { blog } = storeToRefs(useContentStore());
const latestPosts = computed(() => blog.value.slice(0, 3));

function formatDate(d: string) {
    if (!d) {
return '';
}

    return new Date(d).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}
</script>
