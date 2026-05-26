import { defineStore } from 'pinia';
import { ref } from 'vue';
import { useApi } from '@/portfolio/composables/useApi';

export const useContactStore = defineStore('contact', () => {
    const { post } = useApi();
    const sending = ref(false);
    const success = ref(false);
    const error = ref<string | null>(null);

    const form = ref({ name: '', email: '', subject: '', message: '' });

    async function send() {
        sending.value = true;
        success.value = false;
        error.value = null;
        try {
            await post('/contact', form.value);
            success.value = true;
            form.value = { name: '', email: '', subject: '', message: '' };
        } catch (e: any) {
            error.value = e?.response?.data?.message ?? 'Something went wrong. Please try again.';
        } finally {
            sending.value = false;
        }
    }

    return { form, sending, success, error, send };
});
