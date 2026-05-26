<template>
    <section id="contact" class="section-padding" style="background: var(--p-surface)">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <SectionTitle label="Contact" title="Get In Touch" subtitle="Have a project in mind? Let's talk!" />

            <div class="grid gap-12 lg:grid-cols-2">
                <!-- Contact Info Cards -->
                <div class="space-y-4">
                    <div v-if="settings?.contact_email" class="glass-card flex items-center gap-4 p-5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-xl" style="background: var(--p-primary)">📧</div>
                        <div>
                            <div class="text-sm font-medium" style="color: var(--p-muted)">Email</div>
                            <a :href="`mailto:${settings.contact_email}`" class="font-semibold text-white hover:opacity-80">{{ settings.contact_email }}</a>
                        </div>
                    </div>
                    <div v-if="settings?.phone" class="glass-card flex items-center gap-4 p-5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-xl" style="background: var(--p-accent)">📞</div>
                        <div>
                            <div class="text-sm font-medium" style="color: var(--p-muted)">Phone</div>
                            <a :href="`tel:${settings.phone}`" class="font-semibold text-white hover:opacity-80">{{ settings.phone }}</a>
                        </div>
                    </div>
                    <div v-if="settings?.address" class="glass-card flex items-center gap-4 p-5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-xl" style="background: var(--p-primary)">📍</div>
                        <div>
                            <div class="text-sm font-medium" style="color: var(--p-muted)">Location</div>
                            <span class="font-semibold text-white">{{ settings.address }}</span>
                        </div>
                    </div>
                    <!-- Social Links -->
                    <div class="glass-card p-5">
                        <div class="mb-3 text-sm font-medium" style="color: var(--p-muted)">Follow Me</div>
                        <div class="flex gap-3">
                            <a v-for="(url, key) in socialLinks" :key="key" :href="url" target="_blank" class="flex h-10 w-10 items-center justify-center rounded-xl transition-all hover:scale-110" style="background: var(--p-bg); color: var(--p-text)">
                                {{ socialIcons[key] }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <form class="glass-card space-y-4 p-8" @submit.prevent="contactStore.send()">
                    <Transition name="fade">
                        <div v-if="contactStore.success" class="rounded-xl p-4 text-center text-sm font-medium" style="background: rgba(34,197,94,0.15); color: #4ade80; border: 1px solid rgba(34,197,94,0.3)">
                            ✅ Message sent! I'll get back to you soon.
                        </div>
                    </Transition>
                    <Transition name="fade">
                        <div v-if="contactStore.error" class="rounded-xl p-4 text-center text-sm font-medium" style="background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.3)">
                            ❌ {{ contactStore.error }}
                        </div>
                    </Transition>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-medium" style="color: var(--p-muted)">Name *</label>
                            <input v-model="contactStore.form.name" type="text" required class="form-input" placeholder="Your name" />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium" style="color: var(--p-muted)">Email *</label>
                            <input v-model="contactStore.form.email" type="email" required class="form-input" placeholder="your@email.com" />
                        </div>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium" style="color: var(--p-muted)">Subject</label>
                        <input v-model="contactStore.form.subject" type="text" class="form-input" placeholder="Project inquiry, collaboration..." />
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium" style="color: var(--p-muted)">Message *</label>
                        <textarea v-model="contactStore.form.message" required rows="5" class="form-input resize-none" placeholder="Tell me about your project..." />
                    </div>

                    <button
                        type="submit"
                        :disabled="contactStore.sending"
                        class="w-full rounded-xl py-3 font-semibold text-white transition-all hover:scale-[1.02] disabled:opacity-60"
                        style="background: linear-gradient(135deg, var(--p-primary), var(--p-accent))"
                    >
                        {{ contactStore.sending ? 'Sending...' : 'Send Message' }}
                    </button>
                </form>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { storeToRefs } from 'pinia';
import { useContentStore } from '@/portfolio/stores/useContentStore';
import { useContactStore } from '@/portfolio/stores/useContactStore';
import SectionTitle from '@/portfolio/components/ui/SectionTitle.vue';

const { settings } = storeToRefs(useContentStore());
const contactStore = useContactStore();

const socialLinks = computed(() =>
    Object.fromEntries(Object.entries(settings.value?.social ?? {}).filter(([, v]) => v)),
);

const socialIcons: Record<string, string> = {
    github: '🐙', linkedin: '💼', facebook: '📘', twitter: '🐦',
};
</script>

<style scoped>
.form-input {
    width: 100%;
    border-radius: 0.75rem;
    border: 1px solid var(--p-border);
    background: var(--p-bg);
    color: var(--p-text);
    padding: 0.625rem 1rem;
    font-size: 0.875rem;
    outline: none;
    transition: border-color 0.2s;
}
.form-input:focus {
    border-color: var(--p-primary);
}
.form-input::placeholder {
    color: var(--p-muted);
    opacity: 0.7;
}
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
