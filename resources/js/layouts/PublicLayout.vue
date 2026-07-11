<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import ThemeToggle from '@/components/ThemeToggle.vue';
import { home, login } from '@/routes';

const page = usePage();
const isHome = computed(() => page.component === 'public/Home');

const sections = [
    { id: 'beranda', label: 'Beranda' },
    { id: 'tentang', label: 'Tentang' },
    { id: 'project', label: 'Project' },
    { id: 'layanan', label: 'Layanan' },
    { id: 'kontak', label: 'Kontak' },
] as const;

const activeSection = ref('beranda');
const mobileNav = ref(false);
const year = new Date().getFullYear();

function scrollToSection(id: string) {
    const el = document.getElementById(id);

    if (el) {
        const y =
            (window.pageYOffset || document.documentElement.scrollTop || 0) +
            el.getBoundingClientRect().top -
            96;
        window.scrollTo({ top: y, behavior: 'smooth' });
    }
}

function goSection(id: string) {
    mobileNav.value = false;

    if (isHome.value) {
        scrollToSection(id);
    } else {
        router.visit(home.url(), {
            onSuccess: () => setTimeout(() => scrollToSection(id), 90),
        });
    }
}

let raf: number | null = null;

function computeActive() {
    if (!isHome.value) {
        return;
    }

    let current = sections[0].id as string;

    for (const { id } of sections) {
        const el = document.getElementById(id);

        if (el && el.getBoundingClientRect().top <= 150) {
            current = id;
        }
    }

    activeSection.value = current;
}

function onScroll() {
    if (raf !== null) {
        return;
    }

    raf = requestAnimationFrame(() => {
        raf = null;
        computeActive();
    });
}

onMounted(() => {
    window.addEventListener('scroll', onScroll, { passive: true });
    computeActive();
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll);

    if (raf !== null) {
        cancelAnimationFrame(raf);
    }
});
</script>

<template>
    <div class="min-h-screen bg-bg text-fg transition-colors duration-[.35s]">
        <header
            class="pointer-events-none fixed top-0 right-0 left-0 z-60 px-[clamp(14px,4vw,28px)] pt-[clamp(12px,2vw,20px)]"
        >
            <div
                class="pointer-events-auto mx-auto flex h-[62px] w-full max-w-[1080px] animate-[navDrop_.85s_cubic-bezier(.2,.75,.2,1)_both] items-center justify-between gap-4 rounded-full border border-line bg-[color-mix(in_oklch,var(--surface)_80%,transparent)] px-[clamp(12px,2vw,18px)] shadow-lg backdrop-blur-[18px] backdrop-saturate-150"
            >
                <button
                    type="button"
                    class="flex cursor-pointer items-center gap-2.5 border-none bg-transparent p-0"
                    @click="goSection('beranda')"
                >
                    <span
                        class="inline-flex h-[34px] w-[34px] items-center justify-center rounded-[10px] bg-linear-135 from-accent to-[color-mix(in_oklch,var(--accent)_58%,#000_24%)] shadow-[0_5px_12px_color-mix(in_oklch,var(--accent)_35%,transparent)]"
                    >
                        <svg
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#fff"
                            stroke-width="2.3"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="m9 8-4 4 4 4M15 8l4 4-4 4" />
                        </svg>
                    </span>
                    <span
                        class="text-[21px]/none font-extrabold tracking-[-.02em] text-fg"
                        >San<span class="text-accent">Dev</span></span
                    >
                </button>
                <nav
                    class="flex items-center gap-[clamp(16px,2vw,30px)] max-[860px]:hidden"
                >
                    <button
                        v-for="section in sections"
                        :key="section.id"
                        type="button"
                        class="cursor-pointer border-x-0 border-t-0 border-b-2 border-solid bg-transparent px-[3px] py-[9px] text-[14.5px]/none whitespace-nowrap transition-colors duration-[.18s] hover:text-accent"
                        :class="
                            activeSection === section.id && isHome
                                ? 'border-accent font-bold text-accent'
                                : 'border-transparent font-semibold text-muted'
                        "
                        @click="goSection(section.id)"
                    >
                        {{ section.label }}
                    </button>
                </nav>
                <div class="flex items-center gap-2.5">
                    <ThemeToggle />
                    <Link
                        :href="login()"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-[11px] border-none bg-accent px-[18px] py-2.5 text-sm/none font-semibold text-accent-fg shadow-[0_6px_16px_color-mix(in_oklch,var(--accent)_32%,transparent)] transition-all duration-200 hover:-translate-y-px hover:bg-accent-hover"
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
                            <path d="M20 21a8 8 0 1 0-16 0" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        Admin
                    </Link>
                    <button
                        type="button"
                        aria-label="Menu"
                        class="hidden h-10 w-10 cursor-pointer items-center justify-center rounded-[10px] border border-line bg-surface-2 text-fg max-[860px]:inline-flex"
                        @click="mobileNav = !mobileNav"
                    >
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9"
                            stroke-linecap="round"
                        >
                            <path d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
            <div
                v-if="mobileNav"
                class="pointer-events-auto mx-auto mt-2.5 flex max-w-[1080px] animate-[welcomeUp_.4s_ease_both] flex-col gap-0.5 rounded-[20px] border border-line bg-[color-mix(in_oklch,var(--surface)_94%,transparent)] p-2.5 shadow-lg backdrop-blur-[18px]"
            >
                <button
                    v-for="section in sections"
                    :key="section.id"
                    type="button"
                    class="cursor-pointer rounded-[9px] border-none bg-transparent px-2 py-3 text-left text-[15.5px]/none font-semibold text-fg"
                    @click="goSection(section.id)"
                >
                    {{ section.label }}
                </button>
            </div>
        </header>

        <main>
            <slot />
        </main>

        <footer class="border-t border-line bg-bg">
            <div
                class="mx-auto flex w-full max-w-[1140px] flex-wrap items-center justify-between gap-3.5 px-[clamp(20px,5vw,44px)] py-[26px]"
            >
                <span class="font-mono text-[13px]/none font-medium text-subtle"
                    >© {{ year }} SanDev · Website Developer</span
                >
                <div class="flex gap-[18px]">
                    <button
                        type="button"
                        class="cursor-pointer border-none bg-transparent text-[13.5px]/none font-medium text-muted transition-colors duration-[.18s] hover:text-accent"
                        @click="goSection('project')"
                    >
                        Project
                    </button>
                    <button
                        type="button"
                        class="cursor-pointer border-none bg-transparent text-[13.5px]/none font-medium text-muted transition-colors duration-[.18s] hover:text-accent"
                        @click="goSection('kontak')"
                    >
                        Kontak
                    </button>
                    <Link
                        :href="login()"
                        class="cursor-pointer border-none bg-transparent text-[13.5px]/none font-medium text-muted transition-colors duration-[.18s] hover:text-accent"
                    >
                        Admin
                    </Link>
                </div>
            </div>
        </footer>
    </div>
</template>
