import { createPinia } from 'pinia';
import { createApp } from 'vue';
import { loadThemePackage } from '@/themes/registry';

/**
 * Bootstrap the portfolio SPA.
 *
 * 1. Fetch the active theme from the API to get its `component` slug.
 * 2. Load the matching theme package from the registry (dynamic import).
 * 3. Mount Vue with that package's App component and Router.
 *
 * This allows each theme to be a completely different frontend experience
 * (layouts, pages, components) — not just a colour swap.
 */
async function bootstrap() {
    let component = 'default';

    try {
        const res = await fetch('/api/v1/active-theme');

        if (res.ok) {
            const theme = await res.json();

            if (theme?.component) {
                component = theme.component;
            }
        }
    } catch {
        /* fall back to default theme */
    }

    const { App, router } = await loadThemePackage(component);

    const app = createApp(App);
    app.use(createPinia());
    app.use(router);
    app.mount('#portfolio-app');
}

bootstrap();
