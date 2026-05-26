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
    is_active: boolean;
    config: ThemeConfig;
}

export const useThemeStore = defineStore('theme', () => {
    const activeTheme = ref<Theme | null>(null);
    const allThemes = ref<Theme[]>([]);
    const isDark = ref(true);
    const { get } = useApi();

    async function loadThemes() {
        try {
            const [active, themes] = await Promise.all([get<Theme | null>('/active-theme'), get<{ data: Theme[] }>('/themes')]);
            activeTheme.value = active;
            allThemes.value = themes.data ?? [];
            if (active) applyTheme(active.config);
        } catch {
            /* use defaults */
        }
    }

    function applyTheme(config: ThemeConfig) {
        const root = document.documentElement;
        if (config.primary) root.style.setProperty('--p-primary', config.primary);
        if (config.secondary) root.style.setProperty('--p-secondary', config.secondary);
        if (config.accent) root.style.setProperty('--p-accent', config.accent);
        if (config.bg) root.style.setProperty('--p-bg', config.bg);
        if (config.surface) root.style.setProperty('--p-surface', config.surface);
        if (config.text) root.style.setProperty('--p-text', config.text);
        if (config.muted) root.style.setProperty('--p-muted', config.muted);
        if (config.border) root.style.setProperty('--p-border', config.border);
    }

    function switchTheme(theme: Theme) {
        activeTheme.value = theme;
        applyTheme(theme.config);
        localStorage.setItem('portfolio-theme', theme.slug);
    }

    function toggleDark() {
        isDark.value = !isDark.value;
        document.documentElement.classList.toggle('dark', isDark.value);
    }

    return { activeTheme, allThemes, isDark, loadThemes, switchTheme, toggleDark };
});
