<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { store } from '@/actions/App/Http/Controllers/Auth/LoginController';
import { home } from '@/routes';

const form = useForm({
    email: 'admin@sandev.id',
    password: '',
    remember: false,
});

function submit() {
    form.post(store.url(), {
        onFinish: () => form.reset('password'),
    });
}
</script>

<template>
    <Head title="Masuk" />
    <div
        class="grid min-h-screen grid-cols-1 bg-bg text-fg min-[861px]:grid-cols-[1.05fr_1fr]"
    >
        <div
            class="hidden flex-col justify-between bg-accent p-[clamp(32px,4vw,56px)] text-white min-[861px]:flex"
        >
            <Link
                :href="home()"
                class="inline-flex cursor-pointer items-center gap-1.5 self-start border-none bg-transparent p-0 text-sm/none font-semibold text-white opacity-85"
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
                Kembali ke situs
            </Link>
            <div>
                <div class="text-[26px]/none font-extrabold tracking-[-.02em]">
                    SanDev
                </div>
                <h2
                    class="mt-[22px] max-w-[420px] text-[clamp(28px,3vw,40px)]/[1.12] font-extrabold tracking-[-.02em]"
                >
                    Panel admin untuk mengelola portofolio.
                </h2>
                <p class="mt-4 max-w-[400px] text-base/[1.65] opacity-85">
                    Tambah, ubah, dan atur project yang tampil di landing page —
                    tanpa menyentuh kode.
                </p>
            </div>
            <div class="flex flex-col gap-[13px]">
                <div
                    v-for="feature in [
                        'CRUD project lengkap',
                        'Atur status publish dan urutan',
                        'Publish langsung tampil di landing',
                    ]"
                    :key="feature"
                    class="flex items-center gap-[11px] text-[14.5px]/none font-medium opacity-92"
                >
                    <svg
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                    {{ feature }}
                </div>
            </div>
        </div>
        <div
            class="flex items-center justify-center bg-bg p-[clamp(28px,4vw,48px)]"
        >
            <form class="w-full max-w-[400px]" @submit.prevent="submit">
                <span
                    class="font-mono text-xs/none font-medium tracking-[.16em] text-accent uppercase"
                    >Masuk</span
                >
                <h1
                    class="mt-3.5 text-[28px]/[1.15] font-extrabold tracking-[-.02em] text-fg"
                >
                    Selamat datang kembali
                </h1>
                <p class="mt-2 text-[15px]/[1.5] text-muted">
                    Masuk untuk mengelola project Anda.
                </p>
                <div class="mt-[26px]">
                    <label
                        for="email"
                        class="mb-2 block text-[13.5px]/none font-semibold text-fg"
                        >Email</label
                    >
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        class="w-full rounded-[10px] border border-line-strong bg-surface px-3.5 py-3 text-[15px]/[1.4] text-fg transition-all duration-[.16s] outline-none focus:border-accent focus:shadow-[0_0_0_3px_var(--ring)]"
                    />
                    <div
                        v-if="form.errors.email"
                        class="mt-[7px] text-[12.5px]/[1.4] font-medium text-danger"
                    >
                        {{ form.errors.email }}
                    </div>
                </div>
                <div class="mt-4">
                    <label
                        for="password"
                        class="mb-2 block text-[13.5px]/none font-semibold text-fg"
                        >Password</label
                    >
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full rounded-[10px] border border-line-strong bg-surface px-3.5 py-3 text-[15px]/[1.4] text-fg transition-all duration-[.16s] outline-none focus:border-accent focus:shadow-[0_0_0_3px_var(--ring)]"
                    />
                    <div
                        v-if="form.errors.password"
                        class="mt-[7px] text-[12.5px]/[1.4] font-medium text-danger"
                    >
                        {{ form.errors.password }}
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <label
                        class="flex cursor-pointer items-center gap-2 text-[13.5px]/none font-medium text-muted"
                    >
                        <input
                            v-model="form.remember"
                            type="checkbox"
                            class="h-4 w-4 cursor-pointer accent-accent"
                        />
                        Ingat saya
                    </label>
                    <a
                        href="#"
                        class="text-[13.5px]/none font-semibold text-accent hover:text-accent-hover"
                        >Lupa password?</a
                    >
                </div>
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="mt-6 inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-[11px] border-none bg-accent p-3.5 text-[15px]/none font-bold text-accent-fg shadow-sm transition-all duration-200 hover:-translate-y-px hover:bg-accent-hover disabled:opacity-70"
                >
                    {{ form.processing ? 'Memproses…' : 'Masuk ke Dashboard' }}
                </button>
                <p
                    class="mt-5 text-center font-mono text-[12.5px]/[1.5] font-medium text-subtle"
                >
                    Dilindungi Laravel Breeze
                </p>
            </form>
        </div>
    </div>
</template>
