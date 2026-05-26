<template>
    <div class="min-h-screen pt-24">
        <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6">
            <div v-if="loading" class="space-y-6">
                <div class="skeleton h-10 w-3/4" />
                <div class="skeleton h-64 w-full" />
                <div v-for="i in 6" :key="i" class="skeleton h-4" :style="{ width: i % 3 === 0 ? '60%' : '100%' }" />
            </div>

            <article v-else-if="post">
                <RouterLink to="/blog" class="mb-6 inline-flex items-center gap-2 text-sm transition-colors hover:opacity-80" style="color: var(--p-primary)">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    All Articles
                </RouterLink>

                <div class="mb-3 flex flex-wrap gap-2">
                    <span v-for="tag in post.tags" :key="tag" class="rounded-md px-2 py-0.5 text-xs" style="background: var(--p-surface); color: var(--p-accent); border: 1px solid var(--p-border)">{{ tag }}</span>
                </div>

                <h1 class="mb-4 text-3xl font-extrabold leading-snug text-white md:text-4xl">{{ post.title }}</h1>
                <p class="mb-8 text-sm" style="color: var(--p-muted)">{{ formatDate(post.published_at) }}</p>

                <div v-if="post.cover_image" class="mb-8 overflow-hidden rounded-2xl">
                    <img :src="post.cover_image" :alt="post.title" class="h-64 w-full object-cover md:h-80" />
                </div>

                <div class="blog-content leading-relaxed" style="color: var(--p-muted)" v-html="renderedContent" />
            </article>

            <div v-else class="py-20 text-center" style="color: var(--p-muted)">Post not found.</div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useApi } from '@/portfolio/composables/useApi';

const route = useRoute();
const { get } = useApi();
const post = ref<any>(null);
const loading = ref(true);

onMounted(async () => {
    try {
        const data = await get<any>(`/blog/${route.params.slug}`);
        post.value = data;
    } catch {
        post.value = null;
    } finally {
        loading.value = false;
    }
});

const renderedContent = computed(() => post.value?.content?.replace(/\n/g, '<br>') ?? '');

function formatDate(d: string) {
    if (!d) return '';
    return new Date(d).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}
</script>

<style scoped>
.blog-content :deep(h1), .blog-content :deep(h2), .blog-content :deep(h3) {
    color: white;
    font-weight: 700;
    margin: 1.5rem 0 0.75rem;
}
.blog-content :deep(code) {
    background: var(--p-surface);
    border-radius: 0.375rem;
    padding: 0.125rem 0.5rem;
    font-family: monospace;
    font-size: 0.875em;
    color: var(--p-accent);
}
.blog-content :deep(pre) {
    background: var(--p-surface);
    border-radius: 0.75rem;
    padding: 1.25rem;
    overflow-x: auto;
    margin: 1rem 0;
}
.blog-content :deep(a) {
    color: var(--p-primary);
    text-decoration: underline;
}
.blog-content :deep(blockquote) {
    border-left: 3px solid var(--p-primary);
    padding-left: 1rem;
    opacity: 0.85;
    margin: 1rem 0;
}
</style>
