import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('@/portfolio/pages/HomePage.vue'),
    },
    {
        path: '/projects/:slug',
        name: 'project',
        component: () => import('@/portfolio/pages/ProjectDetailPage.vue'),
    },
    {
        path: '/blog',
        name: 'blog',
        component: () => import('@/portfolio/pages/BlogPage.vue'),
    },
    {
        path: '/blog/:slug',
        name: 'blog-post',
        component: () => import('@/portfolio/pages/BlogPostPage.vue'),
    },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, _from, savedPosition) {
        if (savedPosition) return savedPosition;
        if (to.hash) return { el: to.hash, behavior: 'smooth' };
        return { top: 0, behavior: 'smooth' };
    },
});
