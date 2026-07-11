import { computed, ref } from 'vue';

type Theme = 'light' | 'dark';

const theme = ref<Theme>(
    typeof document !== 'undefined' &&
        document.documentElement.getAttribute('data-theme') === 'dark'
        ? 'dark'
        : 'light',
);

export function useTheme() {
    const isDark = computed(() => theme.value === 'dark');

    function toggleTheme(): void {
        theme.value = theme.value === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', theme.value);

        try {
            localStorage.setItem('sandev_theme', theme.value);
        } catch {
            // localStorage unavailable (private mode) — theme still applies for the session
        }
    }

    return { theme, isDark, toggleTheme };
}
