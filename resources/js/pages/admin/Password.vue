<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { update } from '@/actions/App/Http/Controllers/Auth/PasswordController';
import AdminLayout from '@/layouts/AdminLayout.vue';

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const inputBase =
    'w-full rounded-[10px] border bg-bg px-3.5 py-3 text-[15px]/[1.5] text-fg outline-none transition-all duration-[.16s] focus:border-accent focus:shadow-[0_0_0_3px_var(--ring)]';

function fieldClass(hasError: boolean): string {
    return `${inputBase} ${
        hasError
            ? 'border-danger-line shadow-[0_0_0_3px_color-mix(in_oklch,var(--danger-border)_18%,transparent)]'
            : 'border-line-strong'
    }`;
}

function submit() {
    form.put(update.url(), {
        // Password tidak pernah dibiarkan tertinggal di memori form, baik saat
        // berhasil maupun gagal.
        onSuccess: () => form.reset(),
        onError: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Ganti Password" />
    <AdminLayout crumb="ganti password">
        <div class="mx-auto w-full max-w-[560px]">
            <h1
                class="text-[clamp(24px,3vw,32px)]/[1.1] font-extrabold tracking-[-.02em] text-fg"
            >
                Ganti Password
            </h1>
            <p class="mt-1.5 text-[14.5px]/[1.5] text-muted">
                Masukkan password saat ini untuk mengonfirmasi, lalu tentukan
                password baru.
            </p>
            <form
                class="mt-[clamp(20px,3vw,28px)] flex flex-col gap-5 rounded-[14px] border border-line bg-surface p-[clamp(20px,2.5vw,28px)] shadow-md"
                @submit.prevent="submit"
            >
                <div>
                    <label
                        for="current_password"
                        class="mb-2 block text-[13.5px]/none font-semibold text-fg"
                        >Password saat ini
                        <span class="text-accent">*</span></label
                    >
                    <input
                        id="current_password"
                        v-model="form.current_password"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        :class="fieldClass(!!form.errors.current_password)"
                    />
                    <div
                        v-if="form.errors.current_password"
                        class="mt-[7px] text-[12.5px]/[1.4] font-medium text-danger"
                    >
                        {{ form.errors.current_password }}
                    </div>
                </div>
                <div class="h-px bg-line"></div>
                <div>
                    <label
                        for="password"
                        class="mb-2 block text-[13.5px]/none font-semibold text-fg"
                        >Password baru <span class="text-accent">*</span></label
                    >
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        :class="fieldClass(!!form.errors.password)"
                    />
                    <div
                        v-if="form.errors.password"
                        class="mt-[7px] text-[12.5px]/[1.4] font-medium text-danger"
                    >
                        {{ form.errors.password }}
                    </div>
                    <p
                        v-else
                        class="mt-[7px] text-[12.5px]/[1.4] font-medium text-subtle"
                    >
                        Minimal 8 karakter, dan harus berbeda dari password saat
                        ini.
                    </p>
                </div>
                <div>
                    <label
                        for="password_confirmation"
                        class="mb-2 block text-[13.5px]/none font-semibold text-fg"
                        >Konfirmasi password baru
                        <span class="text-accent">*</span></label
                    >
                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        :class="fieldClass(!!form.errors.password)"
                    />
                </div>
                <div class="flex justify-end">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-[10px] border-none bg-accent px-[18px] py-[11px] text-sm/none font-semibold text-accent-fg shadow-sm transition-all duration-200 hover:-translate-y-px hover:bg-accent-hover disabled:opacity-70"
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
                        {{
                            form.processing
                                ? 'Menyimpan…'
                                : 'Simpan Password Baru'
                        }}
                    </button>
                </div>
            </form>
            <p class="mt-4 text-[13px]/[1.55] text-subtle">
                Setelah password diganti, sesi yang aktif di perangkat atau
                browser lain akan otomatis keluar.
            </p>
        </div>
    </AdminLayout>
</template>
