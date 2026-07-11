<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { show } from '@/routes/project';
import type { ProjectCard } from '@/types';

defineProps<{ project: ProjectCard }>();
</script>

<template>
    <Link
        :href="show(project.slug)"
        class="block w-full cursor-pointer overflow-hidden rounded-2xl border border-line bg-surface p-0 text-left shadow-md transition-all duration-[.22s] hover:-translate-y-[5px] hover:border-accent-line hover:shadow-lg"
    >
        <div
            class="relative flex aspect-16/10 items-end border-b border-line placeholder-stripes p-3.5"
        >
            <img
                v-if="project.thumbnail"
                :src="`/storage/${project.thumbnail}`"
                :alt="project.title"
                class="absolute inset-0 h-full w-full object-cover"
            />
            <span
                v-else
                class="inline-flex items-center gap-[7px] rounded-full border border-line bg-[color-mix(in_oklch,var(--surface)_88%,transparent)] px-3 py-1.5 font-mono text-[11.5px]/none font-medium text-subtle backdrop-blur-[4px]"
            >
                <svg
                    width="14"
                    height="14"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.9"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <circle cx="9" cy="9" r="1.8" />
                    <path d="m21 15-3.1-3.1a2 2 0 0 0-2.8 0L6 21" />
                </svg>
                {{ project.title }}
            </span>
        </div>
        <div class="px-5 pt-5 pb-[22px]">
            <h3 class="text-[19px]/[1.25] font-bold text-fg">
                {{ project.title }}
            </h3>
            <p class="mt-2 line-clamp-2 text-[14.5px]/[1.55] text-muted">
                {{ project.summary }}
            </p>
            <div class="mt-3.5 flex flex-wrap gap-[7px]">
                <span
                    v-for="tech in project.technologies"
                    :key="tech"
                    class="inline-flex items-center rounded-[7px] border border-accent-line bg-accent-soft px-2.5 py-1 text-[11.5px]/[1.4] font-semibold text-accent"
                >
                    {{ tech }}
                </span>
            </div>
            <span
                class="mt-[18px] inline-flex items-center gap-[7px] text-sm/none font-semibold text-accent"
            >
                Lihat detail
                <svg
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M5 12h14M13 6l6 6-6 6" />
                </svg>
            </span>
        </div>
    </Link>
</template>
