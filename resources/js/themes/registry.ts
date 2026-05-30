/**
 * Theme Package Registry
 *
 * Maps a theme's `component` slug (stored in the DB) to a lazy import that
 * returns the Vue App component and Vue Router instance for that theme.
 *
 * Adding a new theme package:
 *   1. Create resources/js/themes/<slug>/index.ts  (or install an npm package)
 *   2. Add an entry below using a dynamic import
 *   3. Register the slug in ThemeForm::availableComponents()
 */

import type { Component } from 'vue';
import type { Router } from 'vue-router';

export interface ThemePackage {
    /** Root Vue component for the theme (mounted at #portfolio-app) */
    App: Component;
    /** Pre-configured Vue Router instance for the theme's routes */
    router: Router;
}

type ThemeLoader = () => Promise<ThemePackage>;

const registry: Record<string, ThemeLoader> = {
    default: async () => {
        const [appMod, routerMod] = await Promise.all([
            import('@/portfolio/App.vue'),
            import('@/portfolio/router/index'),
        ]);

        return { App: appMod.default, router: routerMod.router };
    },

    // ── Add future theme packages here ────────────────────────────────────────
    // photographer: async () => {
    //     const mod = await import('@portfolio-themes/photographer');
    //     return { App: mod.App, router: mod.router };
    // },
};

/**
 * Resolve and load a theme package by its component slug.
 * Falls back to 'default' if the slug is unknown.
 */
export async function loadThemePackage(component: string): Promise<ThemePackage> {
    const loader = registry[component] ?? registry.default;

    return loader();
}
