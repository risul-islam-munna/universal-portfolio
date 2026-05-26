<template>
    <div class="min-h-screen pt-24">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <p class="mb-2 text-sm font-semibold uppercase tracking-widest" style="color: var(--p-primary)">Blog</p>
                <h1 class="text-4xl font-extrabold text-white">All Articles</h1>
            </div>

            <div v-if="loading" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div v-for="i in 6" :key="i" class="skeleton h-64" />
            </div>

            <div v-else-if="posts.length" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <RouterLink
                    v-for="post in posts"
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
                            <span v-for="tag in (post.tags || []).slice(0, 3)" :key="tag" class="rounded-md px-2 py-0.5 text-xs" style="background: var(--p-bg); color: var(--p-accent); border: 1px solid var(--p-border)">{{ tag }}</span>
                        </div>
                        <h2 class="mb-2 font-bold leading-snug text-white group-hover:text-blue-400 transition-colors">{{ post.title }}</h2>
                        <p class="text-xs" style="color: var(--p-muted)">{{ formatDate(post.published_at) }}</p>
                    </div>
                </RouterLink>
            </div>

            <div v-else class="py-20 text-center" style="color: var(--p-muted)">No blog posts published yet.</div>

            <div class="mt-12 text-center">
                <RouterLink to="/" class="inline-flex items-center gap-2 text-sm transition-colors hover:opacity-80" style="color: var(--p-primary)">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back Home
                </RouterLink>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useApi } from '@/portfolio/composables/useApi';

const { get } = useApi();
const posts = ref<any[]>([]);
const loading = ref(true);

onMounted(async () => {
    try {
        const data = await get<{ data: any[] }>('/blog');
        posts.value = data.data ?? [];
    } finally {
        loading.value = false;
    }
});

function formatDate(d: string) {
    if (!d) return '';
    return new Date(d).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}
</script>
