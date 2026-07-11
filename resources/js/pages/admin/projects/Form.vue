<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import {
    store,
    update,
} from '@/actions/App/Http/Controllers/Admin/ProjectController';
import { useToast } from '@/composables/useToast';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { index as projectsIndex } from '@/routes/admin/projects';
import type { Project } from '@/types';

const props = defineProps<{
    project: Project | null;
    nextOrder: number | null;
}>();

const isEdit = props.project !== null;
const toast = useToast();

const form = useForm({
    title: props.project?.title ?? '',
    slug: props.project?.slug ?? '',
    summary: props.project?.summary ?? '',
    case_study: props.project?.case_study ?? '',
    solution: props.project?.solution ?? '',
    features: props.project?.features?.length
        ? [...props.project.features]
        : [''],
    technologies: props.project ? [...props.project.technologies] : [],
    github_url: props.project?.github_url ?? '',
    demo_url: props.project?.demo_url ?? '',
    status: props.project?.status ?? false,
    sort_order: props.project?.sort_order ?? props.nextOrder ?? 1,
    thumbnail: null as File | null,
});

const slugEdited = ref(isEdit);
const techDraft = ref('');
const thumbnailPreview = ref<string | null>(
    props.project?.thumbnail ? `/storage/${props.project.thumbnail}` : null,
);
const fileInput = ref<HTMLInputElement | null>(null);

function slugify(value: string): string {
    return value
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-+|-+$)/g, '');
}

watch(
    () => form.title,
    (title) => {
        if (!slugEdited.value) {
            form.slug = slugify(title);
        }
    },
);

const suggestions = computed(() =>
    [
        'Laravel',
        'PHP',
        'MySQL',
        'Tailwind CSS',
        'Alpine.js',
        'Livewire',
        'REST API',
        'Inertia.js',
        'Vue.js',
        'Chart.js',
        'Git',
    ].filter((tech) => !form.technologies.includes(tech)),
);

function addTech(value: string) {
    const name = value.trim();

    if (name && !form.technologies.includes(name)) {
        form.technologies.push(name);
    }

    techDraft.value = '';
}

function removeTech(name: string) {
    form.technologies = form.technologies.filter((tech) => tech !== name);
}

function addFeature() {
    form.features.push('');
}

function removeFeature(index: number) {
    if (form.features.length <= 1) {
        form.features = [''];
    } else {
        form.features.splice(index, 1);
    }
}

function selectThumbnail(file: File | undefined) {
    if (!file) {
        return;
    }

    form.thumbnail = file;
    thumbnailPreview.value = URL.createObjectURL(file);
}

function onFileChange(event: Event) {
    selectThumbnail((event.target as HTMLInputElement).files?.[0]);
}

function onDrop(event: DragEvent) {
    selectThumbnail(event.dataTransfer?.files?.[0]);
}

function submit() {
    const options = {
        onError: () => toast.show('Periksa kembali field yang wajib diisi.'),
    };

    if (isEdit && props.project) {
        form.transform((data) => ({ ...data, _method: 'put' })).post(
            update.url(props.project.slug),
            options,
        );
    } else {
        form.post(store.url(), options);
    }
}

const inputBase =
    'w-full rounded-[10px] border bg-bg px-3.5 py-3 text-[15px]/[1.5] text-fg outline-none transition-all duration-[.16s] focus:border-accent focus:shadow-[0_0_0_3px_var(--ring)]';
const textareaBase =
    'min-h-24 w-full resize-y rounded-[10px] border bg-bg px-3.5 py-3 text-[15px]/[1.6] text-fg outline-none transition-all duration-[.16s] focus:border-accent focus:shadow-[0_0_0_3px_var(--ring)]';

function fieldClass(base: string, hasError: boolean): string {
    return `${base} ${
        hasError
            ? 'border-danger-line shadow-[0_0_0_3px_color-mix(in_oklch,var(--danger-border)_18%,transparent)]'
            : 'border-line-strong'
    }`;
}
</script>

<template>
    <Head :title="isEdit ? 'Edit Project' : 'Tambah Project'" />
    <AdminLayout :crumb="isEdit ? 'Edit Project' : 'Tambah Project'">
        <div class="flex flex-col gap-6">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <Link
                        :href="projectsIndex()"
                        class="inline-flex cursor-pointer items-center gap-1.5 border-none bg-transparent p-0 text-[13px]/none font-semibold text-muted transition-colors duration-[.18s] hover:text-accent"
                    >
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
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        Project
                    </Link>
                    <h1
                        class="mt-2 text-[clamp(24px,3vw,32px)]/[1.1] font-extrabold tracking-[-.02em] text-fg"
                    >
                        {{ isEdit ? 'Edit Project' : 'Tambah Project' }}
                    </h1>
                    <p class="mt-1.5 text-[14.5px]/[1.5] text-muted">
                        {{
                            isEdit
                                ? 'Perbarui informasi project yang sudah ada.'
                                : 'Isi detail project baru untuk ditampilkan di landing page.'
                        }}
                    </p>
                </div>
                <div class="flex gap-2.5">
                    <Link
                        :href="projectsIndex()"
                        class="cursor-pointer rounded-[10px] border border-line-strong bg-surface px-[18px] py-[11px] text-sm/none font-semibold text-fg transition-all duration-[.18s] hover:border-accent hover:text-accent"
                    >
                        Batal
                    </Link>
                    <button
                        type="button"
                        :disabled="form.processing"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-[10px] border-none bg-accent px-[18px] py-[11px] text-sm/none font-semibold text-accent-fg shadow-sm transition-all duration-200 hover:-translate-y-px hover:bg-accent-hover disabled:opacity-70"
                        @click="submit"
                    >
                        <svg
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                        Simpan
                    </button>
                </div>
            </div>
            <div
                class="grid grid-cols-1 items-start gap-[clamp(20px,3vw,28px)] min-[861px]:grid-cols-[minmax(0,1.7fr)_minmax(260px,300px)]"
            >
                <div
                    class="flex min-w-0 flex-col gap-5 rounded-[14px] border border-line bg-surface p-[clamp(20px,2.5vw,28px)] shadow-md"
                >
                    <div>
                        <label
                            for="title"
                            class="mb-2 block text-[13.5px]/none font-semibold text-fg"
                            >Judul <span class="text-accent">*</span></label
                        >
                        <input
                            id="title"
                            v-model="form.title"
                            type="text"
                            placeholder="Nama project"
                            :class="fieldClass(inputBase, !!form.errors.title)"
                        />
                        <div
                            v-if="form.errors.title"
                            class="mt-[7px] text-[12.5px]/[1.4] font-medium text-danger"
                        >
                            {{ form.errors.title }}
                        </div>
                    </div>
                    <div>
                        <label
                            for="slug"
                            class="mb-2 block text-[13.5px]/none font-semibold text-fg"
                            >Slug <span class="text-accent">*</span></label
                        >
                        <div
                            :class="[
                                'flex items-center gap-1.5 rounded-[10px] border bg-bg px-3.5 py-[11px] transition-all duration-[.16s]',
                                form.errors.slug
                                    ? 'border-danger-line shadow-[0_0_0_3px_color-mix(in_oklch,var(--danger-border)_18%,transparent)]'
                                    : 'border-line-strong',
                            ]"
                        >
                            <span
                                class="font-mono text-sm/none font-medium whitespace-nowrap text-subtle"
                                >/project/</span
                            >
                            <input
                                id="slug"
                                v-model="form.slug"
                                type="text"
                                placeholder="nama-project"
                                class="min-w-0 flex-1 border-none bg-transparent p-0 font-mono text-sm/[1.4] font-medium text-fg outline-none"
                                @input="slugEdited = true"
                            />
                        </div>
                        <div
                            v-if="form.errors.slug"
                            class="mt-[7px] text-[12.5px]/[1.4] font-medium text-danger"
                        >
                            {{ form.errors.slug }}
                        </div>
                    </div>
                    <div>
                        <label
                            for="summary"
                            class="mb-2 block text-[13.5px]/none font-semibold text-fg"
                            >Ringkasan <span class="text-accent">*</span></label
                        >
                        <textarea
                            id="summary"
                            v-model="form.summary"
                            placeholder="Deskripsi singkat yang tampil di card project"
                            :class="
                                fieldClass(textareaBase, !!form.errors.summary)
                            "
                        ></textarea>
                        <div
                            v-if="form.errors.summary"
                            class="mt-[7px] text-[12.5px]/[1.4] font-medium text-danger"
                        >
                            {{ form.errors.summary }}
                        </div>
                    </div>
                    <div>
                        <label
                            for="case_study"
                            class="mb-2 block text-[13.5px]/none font-semibold text-fg"
                            >Studi Kasus
                            <span class="text-accent">*</span></label
                        >
                        <textarea
                            id="case_study"
                            v-model="form.case_study"
                            placeholder="Masalah dan konteks yang melatarbelakangi project"
                            :class="
                                fieldClass(
                                    textareaBase,
                                    !!form.errors.case_study,
                                )
                            "
                        ></textarea>
                        <div
                            v-if="form.errors.case_study"
                            class="mt-[7px] text-[12.5px]/[1.4] font-medium text-danger"
                        >
                            {{ form.errors.case_study }}
                        </div>
                    </div>
                    <div>
                        <label
                            for="solution"
                            class="mb-2 block text-[13.5px]/none font-semibold text-fg"
                            >Solusi <span class="text-accent">*</span></label
                        >
                        <textarea
                            id="solution"
                            v-model="form.solution"
                            placeholder="Bagaimana project ini menyelesaikan masalah"
                            :class="
                                fieldClass(textareaBase, !!form.errors.solution)
                            "
                        ></textarea>
                        <div
                            v-if="form.errors.solution"
                            class="mt-[7px] text-[12.5px]/[1.4] font-medium text-danger"
                        >
                            {{ form.errors.solution }}
                        </div>
                    </div>
                    <div>
                        <label
                            class="mb-2 block text-[13.5px]/none font-semibold text-fg"
                            >Fitur <span class="text-accent">*</span></label
                        >
                        <div class="flex flex-col gap-[9px]">
                            <div
                                v-for="(feature, index) in form.features"
                                :key="index"
                                class="flex items-center gap-2"
                            >
                                <input
                                    v-model="form.features[index]"
                                    type="text"
                                    placeholder="Nama fitur"
                                    class="min-w-0 flex-1 rounded-[10px] border border-line-strong bg-bg px-3.5 py-[11px] text-[14.5px]/[1.4] text-fg transition-all duration-[.16s] outline-none focus:border-accent focus:shadow-[0_0_0_3px_var(--ring)]"
                                />
                                <button
                                    type="button"
                                    aria-label="Hapus fitur"
                                    class="inline-flex h-10 w-10 flex-none cursor-pointer items-center justify-center rounded-[10px] border border-line bg-surface-2 text-subtle transition-all duration-[.16s] hover:border-danger-line hover:text-danger"
                                    @click="removeFeature(index)"
                                >
                                    <svg
                                        width="15"
                                        height="15"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.1"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="M18 6 6 18M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button
                            type="button"
                            class="mt-2.5 inline-flex cursor-pointer items-center gap-[7px] rounded-[10px] border border-dashed border-line-strong bg-transparent px-3.5 py-2.5 text-[13.5px]/none font-semibold text-muted transition-all duration-[.16s] hover:border-accent hover:text-accent"
                            @click="addFeature"
                        >
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
                                <path d="M5 12h14M12 5v14" />
                            </svg>
                            Tambah fitur
                        </button>
                        <div
                            v-if="form.errors.features"
                            class="mt-[7px] text-[12.5px]/[1.4] font-medium text-danger"
                        >
                            {{ form.errors.features }}
                        </div>
                    </div>
                    <div>
                        <label
                            for="tech-draft"
                            class="mb-2 block text-[13.5px]/none font-semibold text-fg"
                            >Teknologi <span class="text-accent">*</span></label
                        >
                        <div
                            v-if="form.technologies.length"
                            class="mb-2.5 flex flex-wrap gap-2"
                        >
                            <span
                                v-for="tech in form.technologies"
                                :key="tech"
                                class="inline-flex items-center gap-[7px] rounded-lg border border-accent-line bg-accent-soft py-1.5 pr-2 pl-3 text-[12.5px]/none font-semibold text-accent"
                            >
                                {{ tech }}
                                <button
                                    type="button"
                                    aria-label="Hapus"
                                    class="inline-flex h-[18px] w-[18px] cursor-pointer items-center justify-center rounded-[5px] border-none bg-transparent p-0 text-accent"
                                    @click="removeTech(tech)"
                                >
                                    <svg
                                        width="13"
                                        height="13"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.4"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="M18 6 6 18M6 6l12 12" />
                                    </svg>
                                </button>
                            </span>
                        </div>
                        <div class="flex gap-2">
                            <input
                                id="tech-draft"
                                v-model="techDraft"
                                type="text"
                                placeholder="Ketik teknologi lalu Enter"
                                class="min-w-0 flex-1 rounded-[10px] border border-line-strong bg-bg px-3.5 py-[11px] text-[14.5px]/[1.4] text-fg transition-all duration-[.16s] outline-none focus:border-accent focus:shadow-[0_0_0_3px_var(--ring)]"
                                @keydown.enter.prevent="addTech(techDraft)"
                            />
                            <button
                                type="button"
                                class="flex-none cursor-pointer rounded-[10px] border border-line-strong bg-surface-2 px-4 text-[13.5px]/none font-semibold text-fg transition-all duration-[.16s] hover:border-accent hover:text-accent"
                                @click="addTech(techDraft)"
                            >
                                Tambah
                            </button>
                        </div>
                        <div class="mt-3 flex flex-wrap gap-[7px]">
                            <button
                                v-for="tech in suggestions"
                                :key="tech"
                                type="button"
                                class="inline-flex cursor-pointer items-center gap-[5px] rounded-full border border-line bg-transparent px-[11px] py-1.5 text-xs/none font-medium text-muted transition-all duration-[.16s] hover:border-accent hover:text-accent"
                                @click="addTech(tech)"
                            >
                                <svg
                                    width="12"
                                    height="12"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.4"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M5 12h14M12 5v14" />
                                </svg>
                                {{ tech }}
                            </button>
                        </div>
                        <div
                            v-if="form.errors.technologies"
                            class="mt-[7px] text-[12.5px]/[1.4] font-medium text-danger"
                        >
                            {{ form.errors.technologies }}
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col gap-[18px] min-[861px]:sticky min-[861px]:top-[76px]"
                >
                    <div
                        class="flex flex-col gap-4 rounded-[14px] border border-line bg-surface p-5 shadow-md"
                    >
                        <span class="text-[14.5px]/none font-bold text-fg"
                            >Publikasi</span
                        >
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <div
                                    class="text-[13.5px]/none font-semibold text-fg"
                                >
                                    Status
                                </div>
                                <div
                                    class="mt-[5px] text-xs/[1.4] font-medium text-subtle"
                                >
                                    Draft tidak tampil di landing.
                                </div>
                            </div>
                            <button
                                type="button"
                                aria-label="Toggle status"
                                class="relative h-[26px] w-11 flex-none cursor-pointer rounded-full border-none transition-colors duration-200"
                                :class="
                                    form.status ? 'bg-accent' : 'bg-line-strong'
                                "
                                @click="form.status = !form.status"
                            >
                                <span
                                    class="absolute top-[3px] block h-5 w-5 rounded-full bg-white shadow-[0_1px_2px_rgba(0,0,0,.25)] transition-[left] duration-200"
                                    :class="
                                        form.status
                                            ? 'left-[21px]'
                                            : 'left-[3px]'
                                    "
                                ></span>
                            </button>
                        </div>
                        <div
                            class="flex items-center gap-[7px] text-[13px]/none font-semibold text-muted"
                        >
                            <span
                                class="h-2 w-2 rounded-full"
                                :class="
                                    form.status ? 'bg-success' : 'bg-subtle'
                                "
                            ></span>
                            {{ form.status ? 'Publish' : 'Draft' }}
                        </div>
                        <div class="h-px bg-line"></div>
                        <div>
                            <label
                                for="sort_order"
                                class="mb-2 block text-[13.5px]/none font-semibold text-fg"
                                >Urutan</label
                            >
                            <input
                                id="sort_order"
                                v-model.number="form.sort_order"
                                type="number"
                                min="0"
                                class="w-full rounded-[10px] border border-line-strong bg-bg px-3.5 py-[11px] font-mono text-[14.5px]/[1.4] font-medium text-fg transition-all duration-[.16s] outline-none focus:border-accent focus:shadow-[0_0_0_3px_var(--ring)]"
                            />
                        </div>
                        <button
                            type="button"
                            :disabled="form.processing"
                            class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-[10px] border-none bg-accent p-3 text-[14.5px]/none font-bold text-accent-fg shadow-sm transition-all duration-200 hover:-translate-y-px hover:bg-accent-hover disabled:opacity-70"
                            @click="submit"
                        >
                            Simpan Project
                        </button>
                    </div>
                    <div
                        class="flex flex-col gap-3.5 rounded-[14px] border border-line bg-surface p-5 shadow-md"
                    >
                        <span class="text-[14.5px]/none font-bold text-fg"
                            >Thumbnail</span
                        >
                        <div
                            class="relative flex aspect-16/10 cursor-pointer flex-col items-center justify-center gap-[9px] overflow-hidden rounded-[11px] border-[1.5px] border-dashed border-line-strong placeholder-stripes text-subtle transition-colors duration-[.16s] hover:border-accent"
                            @click="fileInput?.click()"
                            @dragover.prevent
                            @drop.prevent="onDrop"
                        >
                            <img
                                v-if="thumbnailPreview"
                                :src="thumbnailPreview"
                                alt="Thumbnail preview"
                                class="absolute inset-0 h-full w-full object-cover"
                            />
                            <template v-else>
                                <svg
                                    width="22"
                                    height="22"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path
                                        d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"
                                    />
                                </svg>
                                <span class="text-[12.5px]/none font-semibold"
                                    >Seret gambar atau pilih file</span
                                >
                            </template>
                        </div>
                        <input
                            ref="fileInput"
                            type="file"
                            accept="image/*"
                            class="hidden"
                            @change="onFileChange"
                        />
                        <div
                            v-if="form.errors.thumbnail"
                            class="text-[12.5px]/[1.4] font-medium text-danger"
                        >
                            {{ form.errors.thumbnail }}
                        </div>
                        <span
                            class="font-mono text-[11px]/[1.5] font-medium text-subtle"
                            >Tersimpan di storage/app/public/projects</span
                        >
                    </div>
                    <div
                        class="flex flex-col gap-3.5 rounded-[14px] border border-line bg-surface p-5 shadow-md"
                    >
                        <span class="text-[14.5px]/none font-bold text-fg"
                            >Tautan
                            <span class="text-xs font-medium text-subtle"
                                >(opsional)</span
                            ></span
                        >
                        <div>
                            <label
                                for="github_url"
                                class="mb-[7px] block text-[13px]/none font-semibold text-fg"
                                >Github URL</label
                            >
                            <input
                                id="github_url"
                                v-model="form.github_url"
                                type="text"
                                placeholder="https://github.com/..."
                                :class="[
                                    'w-full rounded-[10px] border bg-bg px-[13px] py-2.5 font-mono text-[13.5px]/[1.4] text-fg transition-all duration-[.16s] outline-none focus:border-accent focus:shadow-[0_0_0_3px_var(--ring)]',
                                    form.errors.github_url
                                        ? 'border-danger-line'
                                        : 'border-line-strong',
                                ]"
                            />
                            <div
                                v-if="form.errors.github_url"
                                class="mt-[7px] text-[12.5px]/[1.4] font-medium text-danger"
                            >
                                {{ form.errors.github_url }}
                            </div>
                        </div>
                        <div>
                            <label
                                for="demo_url"
                                class="mb-[7px] block text-[13px]/none font-semibold text-fg"
                                >Demo URL</label
                            >
                            <input
                                id="demo_url"
                                v-model="form.demo_url"
                                type="text"
                                placeholder="https://..."
                                :class="[
                                    'w-full rounded-[10px] border bg-bg px-[13px] py-2.5 font-mono text-[13.5px]/[1.4] text-fg transition-all duration-[.16s] outline-none focus:border-accent focus:shadow-[0_0_0_3px_var(--ring)]',
                                    form.errors.demo_url
                                        ? 'border-danger-line'
                                        : 'border-line-strong',
                                ]"
                            />
                            <div
                                v-if="form.errors.demo_url"
                                class="mt-[7px] text-[12.5px]/[1.4] font-medium text-danger"
                            >
                                {{ form.errors.demo_url }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
