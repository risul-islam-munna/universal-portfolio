import { defineStore } from 'pinia';
import { ref } from 'vue';
import { useApi } from '@/portfolio/composables/useApi';

export const useContentStore = defineStore('content', () => {
    const { get } = useApi();

    const settings = ref<any>(null);
    const hero = ref<any>(null);
    const about = ref<any>(null);
    const skills = ref<any[]>([]);
    const services = ref<any[]>([]);
    const projects = ref<any[]>([]);
    const experience = ref<any[]>([]);
    const education = ref<any[]>([]);
    const testimonials = ref<any[]>([]);
    const blog = ref<any[]>([]);
    const businessHighlight = ref<any>(null);
    const loading = ref(true);

    async function loadAll() {
        loading.value = true;

        try {
            const [s, h, a, sk, sv, pr, ex, ed, te, bl, bh] = await Promise.all([
                get('/settings'),
                get('/hero'),
                get('/about'),
                get<{ data: any[] }>('/skills'),
                get<{ data: any[] }>('/services'),
                get<{ data: any[] }>('/projects'),
                get<{ data: any[] }>('/experience'),
                get<{ data: any[] }>('/education'),
                get<{ data: any[] }>('/testimonials'),
                get<{ data: any[] }>('/blog'),
                get('/business-highlight'),
            ]);
            settings.value = s;
            hero.value = h;
            about.value = a;
            skills.value = sk.data ?? [];
            services.value = sv.data ?? [];
            projects.value = pr.data ?? [];
            experience.value = ex.data ?? [];
            education.value = ed.data ?? [];
            testimonials.value = te.data ?? [];
            blog.value = bl.data ?? [];
            businessHighlight.value = bh;
        } finally {
            loading.value = false;
        }
    }

    return { settings, hero, about, skills, services, projects, experience, education, testimonials, blog, businessHighlight, loading, loadAll };
});
