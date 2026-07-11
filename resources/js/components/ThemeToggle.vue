<script setup lang="ts">
import { useTheme } from '@/composables/useTheme';

withDefaults(defineProps<{ size?: 'md' | 'sm' }>(), { size: 'md' });

const { isDark, toggleTheme } = useTheme();
</script>

<template>
    <button
        type="button"
        aria-label="Ganti tema"
        class="inline-flex cursor-pointer items-center justify-center border border-line bg-surface-2 text-fg transition-all duration-[.18s] hover:border-accent hover:text-accent"
        :class="
            size === 'md' ? 'h-10 w-10 rounded-[10px]' : 'h-9 w-9 rounded-[9px]'
        "
        @click="toggleTheme"
    >
        <svg
            v-if="isDark"
            :class="size === 'md' ? 'size-[19px]' : 'size-[17px]'"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <circle cx="12" cy="12" r="4" />
            <path
                d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"
            />
        </svg>
        <svg
            v-else
            :class="size === 'md' ? 'size-[19px]' : 'size-[17px]'"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" />
        </svg>
    </button>
</template>
