import { defineStore } from 'pinia';
import { ref } from 'vue';
import { useApi } from '@/portfolio/composables/useApi';

export interface ThemeConfig {
    primary?: string;
    secondary?: string;
    accent?: string;
    bg?: string;
    surface?: string;
    text?: string;
    muted?: string;
    border?: string;
    font?: string;
}

export interface Theme {
    id: number;
    name: string;
    slug: string;
    /** Frontend registry key — matches a loader in resources/js/themes/registry.ts */
    component: string;
    is_active: boolean;
    config: ThemeConfig;
}

export const useThemeStore = defineStore('theme', () => {
    const activeTheme = ref<Theme | null>(null);
    const allThemes = ref<Theme[]>([]);
    const { get } = useApi();

    async function loadThemes() {
        try {
            const [active, themes] = await Promise.all([
                get<Theme | null>('/active-theme'),
                get<{ data: Theme[] }>('/themes'),
            ]);
            activeTheme.value = active;
            allThemes.value = themes.data ?? [];

            if (active) {
                applyColorOverrides(active.config);
            }
        } catch {
            /* keep defaults */
        }
    }

    /** Apply only the colour CSS variables (overrides on top of the theme's own styles). */
    function applyColorOverrides(config: ThemeConfig) {
        const root = document.documentElement;

        if (config.primary) {
root.style.setProperty('--p-primary', config.primary);
}

        if (config.secondary) {
root.style.setProperty('--p-secondary', config.secondary);
}

        if (config.accent) {
root.style.setProperty('--p-accent', config.accent);
}

        if (config.bg) {
root.style.setProperty('--p-bg', config.bg);
}

        if (config.surface) {
root.style.setProperty('--p-surface', config.surface);
}

        if (config.text) {
root.style.setProperty('--p-text', config.text);
}

        if (config.muted) {
root.style.setProperty('--p-muted', config.muted);
}

        if (config.border) {
root.style.setProperty('--p-border', config.border);
}
    }

    function switchTheme(theme: Theme) {
        activeTheme.value = theme;
        applyColorOverrides(theme.config);
        localStorage.setItem('portfolio-theme', theme.slug);
    }

    return { activeTheme, allThemes, loadThemes, switchTheme, applyColorOverrides };
});
