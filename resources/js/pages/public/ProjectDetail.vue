<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { home } from '@/routes';
import type { Project } from '@/types';

defineProps<{ project: Project }>();
</script>

<template>
    <Head :title="project.title" />
    <PublicLayout>
        <section class="pt-[clamp(104px,12vw,124px)] pb-(--sec-pad)">
            <div
                class="mx-auto w-full max-w-[1140px] animate-[welcomeUp_.55s_cubic-bezier(.2,.75,.2,1)_both] px-[clamp(20px,5vw,44px)]"
            >
                <Link
                    :href="home()"
                    class="inline-flex cursor-pointer items-center gap-1.5 border-none bg-transparent p-0 text-sm/none font-semibold text-muted transition-colors duration-[.18s] hover:text-accent"
                >
                    <svg
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                    Kembali ke beranda
                </Link>
                <div class="mt-[22px] flex flex-wrap gap-2">
                    <span
                        v-for="tech in project.technologies"
                        :key="tech"
                        class="inline-flex items-center rounded-lg border border-accent-line bg-accent-soft px-3 py-[5px] text-xs/[1.4] font-semibold text-accent"
                    >
                        {{ tech }}
                    </span>
                </div>
                <h1
                    class="mt-[18px] text-[clamp(32px,5vw,52px)]/[1.05] font-extrabold tracking-[-.03em] text-fg"
                >
                    {{ project.title }}
                </h1>
                <p
                    class="mt-[18px] max-w-[680px] text-[clamp(16px,2vw,19px)]/[1.6] text-muted"
                >
                    {{ project.summary }}
                </p>
                <div class="mt-[26px] flex flex-wrap gap-3">
                    <a
                        v-if="project.demo_url"
                        :href="project.demo_url"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-[11px] border-none bg-accent px-5 py-3 text-[14.5px]/none font-semibold text-accent-fg shadow-sm transition-all duration-200 hover:-translate-y-px hover:bg-accent-hover"
                    >
                        <svg
                            width="17"
                            height="17"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path
                                d="M15 3h6v6M10 14 21 3M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"
                            />
                        </svg>
                        Demo Langsung
                    </a>
                    <a
                        v-if="project.github_url"
                        :href="project.github_url"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-[11px] border border-line-strong bg-surface px-[19px] py-[11px] text-[14.5px]/none font-semibold text-fg transition-all duration-200 hover:border-accent hover:text-accent"
                    >
                        <svg
                            width="17"
                            height="17"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                        >
                            <path
                                d="M12 .5C5.73.5.5 5.73.5 12c0 5.09 3.29 9.4 7.86 10.93.58.11.79-.25.79-.56v-2c-3.2.7-3.88-1.37-3.88-1.37-.53-1.34-1.29-1.7-1.29-1.7-1.05-.72.08-.71.08-.71 1.16.08 1.77 1.2 1.77 1.2 1.03 1.77 2.7 1.26 3.36.96.1-.75.4-1.26.73-1.55-2.56-.29-5.25-1.28-5.25-5.7 0-1.26.45-2.29 1.19-3.1-.12-.29-.52-1.46.11-3.05 0 0 .97-.31 3.18 1.18a11 11 0 0 1 5.79 0c2.2-1.49 3.17-1.18 3.17-1.18.63 1.59.23 2.76.11 3.05.74.81 1.19 1.84 1.19 3.1 0 4.43-2.69 5.41-5.26 5.69.41.36.78 1.05.78 2.12v3.15c0 .31.21.68.8.56A11.51 11.51 0 0 0 23.5 12C23.5 5.73 18.27.5 12 .5Z"
                            />
                        </svg>
                        Source Code
                    </a>
                </div>
                <div
                    class="relative mt-[clamp(30px,4vw,44px)] flex aspect-video items-end overflow-hidden rounded-[18px] border border-line placeholder-stripes p-[18px] shadow-md"
                >
                    <img
                        v-if="project.thumbnail"
                        :src="`/storage/${project.thumbnail}`"
                        :alt="project.title"
                        class="absolute inset-0 h-full w-full object-cover"
                    />
                    <span
                        v-else
                        class="inline-flex items-center gap-[7px] rounded-full border border-line bg-[color-mix(in_oklch,var(--surface)_90%,transparent)] px-[13px] py-[7px] font-mono text-xs/none font-medium text-subtle backdrop-blur-[4px]"
                    >
                        <svg
                            width="15"
                            height="15"
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
                        thumbnail · {{ project.title }}
                    </span>
                </div>
                <div
                    class="mt-[clamp(32px,5vw,52px)] grid grid-cols-1 items-start gap-[clamp(28px,4vw,48px)] min-[861px]:grid-cols-[minmax(0,1.7fr)_minmax(260px,300px)]"
                >
                    <div class="flex min-w-0 flex-col gap-[38px]">
                        <div>
                            <span
                                class="font-mono text-xs/none font-medium tracking-[.14em] text-accent uppercase"
                                >Studi Kasus</span
                            >
                            <p class="mt-3.5 text-[16.5px]/[1.75] text-muted">
                                {{ project.case_study }}
                            </p>
                        </div>
                        <div>
                            <span
                                class="font-mono text-xs/none font-medium tracking-[.14em] text-accent uppercase"
                                >Solusi</span
                            >
                            <p class="mt-3.5 text-[16.5px]/[1.75] text-muted">
                                {{ project.solution }}
                            </p>
                        </div>
                        <div>
                            <span
                                class="font-mono text-xs/none font-medium tracking-[.14em] text-accent uppercase"
                                >Fitur</span
                            >
                            <ul class="mt-3.5 grid list-none gap-[11px] p-0">
                                <li
                                    v-for="feature in project.features"
                                    :key="feature"
                                    class="flex items-start gap-3 text-[15.5px]/[1.5] font-medium text-fg"
                                >
                                    <span
                                        class="mt-px inline-flex h-[22px] w-[22px] flex-none items-center justify-center rounded-md bg-accent-soft text-accent"
                                    >
                                        <svg
                                            width="14"
                                            height="14"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2.4"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="M20 6 9 17l-5-5" />
                                        </svg>
                                    </span>
                                    {{ feature }}
                                </li>
                            </ul>
                        </div>
                        <div>
                            <span
                                class="font-mono text-xs/none font-medium tracking-[.14em] text-accent uppercase"
                                >Screenshot</span
                            >
                            <div
                                class="mt-3.5 grid grid-cols-[repeat(auto-fit,minmax(210px,1fr))] gap-4"
                            >
                                <div
                                    v-for="screenshot in project.screenshots"
                                    :key="screenshot"
                                    class="flex aspect-16/10 items-end rounded-xl border border-line placeholder-stripes p-3"
                                >
                                    <span
                                        class="font-mono text-[11px]/[1.3] font-medium text-subtle"
                                        >{{ screenshot }}</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <aside class="sticky top-[100px] self-start">
                        <div
                            class="flex flex-col gap-[18px] rounded-2xl border border-line bg-surface p-[22px] shadow-md"
                        >
                            <div>
                                <div
                                    class="font-mono text-[11px]/none font-medium tracking-[.12em] text-subtle uppercase"
                                >
                                    Teknologi
                                </div>
                                <div class="mt-3 flex flex-wrap gap-[7px]">
                                    <span
                                        v-for="tech in project.technologies"
                                        :key="tech"
                                        class="inline-flex items-center rounded-[7px] border border-line bg-surface-2 px-2.5 py-1 text-xs/[1.4] font-medium text-fg"
                                    >
                                        {{ tech }}
                                    </span>
                                </div>
                            </div>
                            <div class="h-px bg-line"></div>
                            <div class="flex items-center justify-between">
                                <span
                                    class="font-mono text-[11px]/none font-medium tracking-[.12em] text-subtle uppercase"
                                    >Status</span
                                >
                                <span
                                    class="inline-flex items-center gap-[7px] text-[13.5px]/none font-semibold text-fg"
                                >
                                    <span
                                        class="h-2 w-2 rounded-full bg-success"
                                    ></span>
                                    Publish
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span
                                    class="font-mono text-[11px]/none font-medium tracking-[.12em] text-subtle uppercase"
                                    >Urutan</span
                                >
                                <span
                                    class="font-mono text-[13.5px]/none font-semibold text-fg"
                                    >#{{ project.sort_order }}</span
                                >
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
