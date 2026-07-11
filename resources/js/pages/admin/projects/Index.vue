<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    destroy,
    toggleStatus,
} from '@/actions/App/Http/Controllers/Admin/ProjectController';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { create, edit } from '@/routes/admin/projects';
import type { ProjectRow } from '@/types';

defineProps<{ projects: ProjectRow[] }>();

function toggle(project: ProjectRow) {
    router.patch(toggleStatus.url(project.slug), undefined, {
        preserveScroll: true,
    });
}

function remove(project: ProjectRow) {
    router.delete(destroy.url(project.slug), { preserveScroll: true });
}
</script>

<template>
    <Head title="Project" />
    <AdminLayout crumb="Project">
        <div class="flex flex-col gap-[22px]">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h1
                        class="text-[clamp(26px,3vw,34px)]/[1.1] font-extrabold tracking-[-.02em] text-fg"
                    >
                        Project
                    </h1>
                    <p class="mt-2 text-[15px]/[1.5] text-muted">
                        Kelola daftar project. Klik status untuk publish atau
                        draft.
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
                class="overflow-hidden rounded-[14px] border border-line bg-surface shadow-md"
            >
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[660px] border-collapse">
                        <thead>
                            <tr class="border-b border-line bg-surface-2">
                                <th
                                    class="px-[18px] py-[13px] text-left font-mono text-[11px]/none font-semibold tracking-[.1em] whitespace-nowrap text-subtle uppercase"
                                >
                                    Thumbnail
                                </th>
                                <th
                                    class="px-[18px] py-[13px] text-left font-mono text-[11px]/none font-semibold tracking-[.1em] whitespace-nowrap text-subtle uppercase"
                                >
                                    Nama
                                </th>
                                <th
                                    class="px-[18px] py-[13px] text-left font-mono text-[11px]/none font-semibold tracking-[.1em] whitespace-nowrap text-subtle uppercase"
                                >
                                    Status
                                </th>
                                <th
                                    class="px-[18px] py-[13px] text-left font-mono text-[11px]/none font-semibold tracking-[.1em] whitespace-nowrap text-subtle uppercase"
                                >
                                    Urutan
                                </th>
                                <th
                                    class="px-[18px] py-[13px] text-right font-mono text-[11px]/none font-semibold tracking-[.1em] whitespace-nowrap text-subtle uppercase"
                                >
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="project in projects"
                                :key="project.id"
                                class="border-b border-line transition-colors duration-150 hover:bg-surface-2"
                            >
                                <td class="px-[18px] py-3 align-middle">
                                    <div
                                        class="h-10 w-14 overflow-hidden rounded-lg border border-line placeholder-stripes"
                                    >
                                        <img
                                            v-if="project.thumbnail"
                                            :src="`/storage/${project.thumbnail}`"
                                            :alt="project.title"
                                            class="h-full w-full object-cover"
                                        />
                                    </div>
                                </td>
                                <td class="px-[18px] py-3 align-middle">
                                    <div
                                        class="text-[14.5px]/[1.3] font-semibold text-fg"
                                    >
                                        {{ project.title }}
                                    </div>
                                    <div
                                        class="mt-[3px] font-mono text-[11.5px]/[1.3] font-medium text-subtle"
                                    >
                                        /{{ project.slug }}
                                    </div>
                                </td>
                                <td class="px-[18px] py-3 align-middle">
                                    <button
                                        type="button"
                                        class="inline-flex cursor-pointer items-center gap-[7px] rounded-full border border-line bg-surface-2 px-3 py-1.5 text-[12.5px]/none font-semibold text-fg transition-all duration-[.16s] hover:border-accent"
                                        @click="toggle(project)"
                                    >
                                        <span
                                            class="h-2 w-2 rounded-full"
                                            :class="
                                                project.status
                                                    ? 'bg-success'
                                                    : 'bg-subtle'
                                            "
                                        ></span>
                                        {{
                                            project.status ? 'Publish' : 'Draft'
                                        }}
                                    </button>
                                </td>
                                <td class="px-[18px] py-3 align-middle">
                                    <span
                                        class="font-mono text-[13.5px]/none font-semibold text-muted"
                                        >{{ project.sort_order }}</span
                                    >
                                </td>
                                <td class="px-[18px] py-3 align-middle">
                                    <div class="flex justify-end gap-2">
                                        <Link
                                            :href="edit(project.slug)"
                                            aria-label="Edit"
                                            class="inline-flex h-[34px] w-[34px] cursor-pointer items-center justify-center rounded-[9px] border border-line bg-surface-2 text-muted transition-all duration-[.16s] hover:border-accent hover:text-accent"
                                        >
                                            <svg
                                                width="16"
                                                height="16"
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
                                        <button
                                            type="button"
                                            aria-label="Hapus"
                                            class="inline-flex h-[34px] w-[34px] cursor-pointer items-center justify-center rounded-[9px] border border-line bg-surface-2 text-muted transition-all duration-[.16s] hover:border-danger-line hover:text-danger"
                                            @click="remove(project)"
                                        >
                                            <svg
                                                width="16"
                                                height="16"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.9"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
