<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { edit as passwordEdit } from '@/actions/App/Http/Controllers/Auth/PasswordController';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { home } from '@/routes';
import { create, edit, index as projectsIndex } from '@/routes/admin/projects';
import type { ProjectRow } from '@/types';

defineProps<{
    stats: {
        total: number;
        published: number;
        draft: number;
        technologies: number;
    };
    recentProjects: ProjectRow[];
}>();
</script>

<template>
    <Head title="Dashboard" />
    <AdminLayout crumb="Dashboard">
        <div class="flex flex-col gap-[26px]">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h1
                        class="text-[clamp(26px,3vw,34px)]/[1.1] font-extrabold tracking-[-.02em] text-fg"
                    >
                        Dashboard
                    </h1>
                    <p class="mt-2 text-[15px]/[1.5] text-muted">
                        Selamat datang kembali, Rizki. Berikut ringkasan
                        portofolio Anda.
                    </p>
                </div>
                <Link
                    :href="create()"
                    class="inline-flex cursor-pointer items-center gap-2 rounded-[10px] border-none bg-accent px-[18px] py-3 text-[14.5px]/none font-semibold text-accent-fg shadow-sm transition-all duration-200 hover:-translate-y-px hover:bg-accent-hover"
                >
                    <svg
                        width="17"
                        height="17"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M5 12h14M12 5v14" />
                    </svg>
                    Tambah Project
                </Link>
            </div>
            <div
                class="grid grid-cols-[repeat(auto-fit,minmax(180px,1fr))] gap-4"
            >
                <div
                    class="rounded-[14px] border border-line bg-surface p-5 shadow-md"
                >
                    <div
                        class="font-mono text-[11px]/none font-medium tracking-[.1em] text-subtle uppercase"
                    >
                        Total Project
                    </div>
                    <div
                        class="mt-3 text-[34px]/none font-extrabold tracking-[-.02em] text-fg"
                    >
                        {{ stats.total }}
                    </div>
                </div>
                <div
                    class="rounded-[14px] border border-line bg-surface p-5 shadow-md"
                >
                    <div
                        class="font-mono text-[11px]/none font-medium tracking-[.1em] text-subtle uppercase"
                    >
                        Publish
                    </div>
                    <div
                        class="mt-3 text-[34px]/none font-extrabold tracking-[-.02em] text-accent"
                    >
                        {{ stats.published }}
                    </div>
                </div>
                <div
                    class="rounded-[14px] border border-line bg-surface p-5 shadow-md"
                >
                    <div
                        class="font-mono text-[11px]/none font-medium tracking-[.1em] text-subtle uppercase"
                    >
                        Draft
                    </div>
                    <div
                        class="mt-3 text-[34px]/none font-extrabold tracking-[-.02em] text-fg"
                    >
                        {{ stats.draft }}
                    </div>
                </div>
                <div
                    class="rounded-[14px] border border-line bg-surface p-5 shadow-md"
                >
                    <div
                        class="font-mono text-[11px]/none font-medium tracking-[.1em] text-subtle uppercase"
                    >
                        Teknologi
                    </div>
                    <div
                        class="mt-3 text-[34px]/none font-extrabold tracking-[-.02em] text-fg"
                    >
                        {{ stats.technologies }}
                    </div>
                </div>
            </div>
            <div
                class="grid grid-cols-1 items-start gap-5 min-[861px]:grid-cols-[minmax(0,1.7fr)_minmax(260px,300px)]"
            >
                <div
                    class="overflow-hidden rounded-[14px] border border-line bg-surface shadow-md"
                >
                    <div
                        class="flex items-center justify-between border-b border-line px-5 py-4"
                    >
                        <span class="text-[15px]/none font-bold text-fg"
                            >Project terbaru</span
                        >
                        <Link
                            :href="projectsIndex()"
                            class="cursor-pointer border-none bg-transparent text-[13px]/none font-semibold text-accent"
                            >Lihat semua</Link
                        >
                    </div>
                    <div>
                        <div
                            v-for="project in recentProjects"
                            :key="project.id"
                            class="flex items-center gap-3.5 border-b border-line px-5 py-[13px]"
                        >
                            <div
                                class="h-8 w-11 flex-none overflow-hidden rounded-[7px] border border-line placeholder-stripes"
                            >
                                <img
                                    v-if="project.thumbnail"
                                    :src="`/storage/${project.thumbnail}`"
                                    :alt="project.title"
                                    class="h-full w-full object-cover"
                                />
                            </div>
                            <div class="min-w-0 flex-1">
                                <div
                                    class="text-[14.5px]/[1.3] font-semibold text-fg"
                                >
                                    {{ project.title }}
                                </div>
                                <div
                                    class="font-mono text-[11.5px]/[1.3] font-medium text-subtle"
                                >
                                    /{{ project.slug }}
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 text-xs/none font-semibold text-muted"
                            >
                                <span
                                    class="h-2 w-2 rounded-full"
                                    :class="
                                        project.status
                                            ? 'bg-success'
                                            : 'bg-subtle'
                                    "
                                ></span>
                                {{ project.status ? 'Publish' : 'Draft' }}
                            </span>
                            <Link
                                :href="edit(project.slug)"
                                aria-label="Edit"
                                class="inline-flex h-8 w-8 flex-none cursor-pointer items-center justify-center rounded-lg border border-line bg-surface-2 text-muted transition-all duration-[.16s] hover:border-accent hover:text-accent"
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
                                    <path
                                        d="M12 20h9M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"
                                    />
                                </svg>
                            </Link>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col gap-2.5 rounded-[14px] border border-line bg-surface p-5 shadow-md"
                >
                    <span class="text-[15px]/none font-bold text-fg"
                        >Aksi cepat</span
                    >
                    <Link
                        :href="create()"
                        class="flex cursor-pointer items-center gap-2.5 rounded-[10px] border border-accent-line bg-accent-soft p-3 text-left text-sm/none font-semibold text-accent transition-all duration-[.16s] hover:-translate-y-px"
                    >
                        <svg
                            width="17"
                            height="17"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M5 12h14M12 5v14" />
                        </svg>
                        Tambah Project baru
                    </Link>
                    <Link
                        :href="projectsIndex()"
                        class="flex cursor-pointer items-center gap-2.5 rounded-[10px] border border-line bg-surface-2 p-3 text-left text-sm/none font-semibold text-fg transition-all duration-[.16s] hover:border-accent"
                    >
                        <svg
                            width="17"
                            height="17"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.85"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path
                                d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"
                            />
                        </svg>
                        Kelola semua project
                    </Link>
                    <Link
                        :href="home()"
                        class="flex cursor-pointer items-center gap-2.5 rounded-[10px] border border-line bg-surface-2 p-3 text-left text-sm/none font-semibold text-fg transition-all duration-[.16s] hover:border-accent"
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
                        Lihat landing page
                    </Link>
                    <Link
                        :href="passwordEdit()"
                        class="flex cursor-pointer items-center gap-2.5 rounded-[10px] border border-line bg-surface-2 p-3 text-left text-sm/none font-semibold text-fg transition-all duration-[.16s] hover:border-accent"
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
                            <rect x="3" y="11" width="18" height="10" rx="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        Ganti password
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
