<template>
    <section id="testimonials" class="section-padding" style="background: var(--p-surface)">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <SectionTitle label="Testimonials" title="What Clients Say" />

            <div v-if="!testimonials.length" class="text-center" style="color: var(--p-muted)">No testimonials yet.</div>

            <div v-else class="relative overflow-hidden">
                <div class="flex transition-transform duration-500" :style="{ transform: `translateX(-${current * 100}%)` }">
                    <div
                        v-for="t in testimonials"
                        :key="t.id"
                        class="min-w-full px-4"
                    >
                        <div class="glass-card mx-auto max-w-2xl p-8 text-center">
                            <!-- Stars -->
                            <div class="mb-4 flex justify-center gap-1">
                                <svg
                                    v-for="i in 5"
                                    :key="i"
                                    class="h-5 w-5"
                                    :class="i <= t.rating ? 'star-filled' : 'star-empty'"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>

                            <blockquote class="mb-6 text-lg italic leading-relaxed" style="color: var(--p-text)">"{{ t.message }}"</blockquote>

                            <div class="flex items-center justify-center gap-3">
                                <img v-if="t.avatar" :src="t.avatar" :alt="t.client_name" class="h-12 w-12 rounded-full object-cover" />
                                <div v-else class="flex h-12 w-12 items-center justify-center rounded-full font-bold text-white" style="background: var(--p-primary)">
                                    {{ t.client_name.slice(0, 1) }}
                                </div>
                                <div class="text-left">
                                    <div class="font-bold text-white">{{ t.client_name }}</div>
                                    <div class="text-sm" style="color: var(--p-muted)">{{ t.designation }}{{ t.company ? ` @ ${t.company}` : '' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <div class="mt-6 flex items-center justify-center gap-4">
                    <button class="rounded-full border p-2 transition-all hover:opacity-80" style="border-color: var(--p-border); color: var(--p-text)" @click="prev">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <div class="flex gap-1.5">
                        <button v-for="(_, i) in testimonials" :key="i" class="h-2 rounded-full transition-all" :style="current === i ? 'background: var(--p-primary); width: 1.5rem' : 'background: var(--p-border); width: 0.5rem'" @click="current = i" />
                    </div>
                    <button class="rounded-full border p-2 transition-all hover:opacity-80" style="border-color: var(--p-border); color: var(--p-text)" @click="next">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { ref, onMounted, onUnmounted } from 'vue';
import SectionTitle from '@/portfolio/components/ui/SectionTitle.vue';
import { useContentStore } from '@/portfolio/stores/useContentStore';

const { testimonials } = storeToRefs(useContentStore());
const current = ref(0);
let autoplay: ReturnType<typeof setInterval>;

function prev() {
 current.value = current.value === 0 ? testimonials.value.length - 1 : current.value - 1; 
}
function next() {
 current.value = (current.value + 1) % testimonials.value.length; 
}

onMounted(() => {
 autoplay = setInterval(next, 5000); 
});
onUnmounted(() => clearInterval(autoplay));
</script>
