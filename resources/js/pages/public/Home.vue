<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import ProjectCard from '@/components/ProjectCard.vue';
import { useHeroParallax } from '@/composables/useHeroParallax';
import { vReveal } from '@/directives/reveal';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { ProjectCard as ProjectCardType } from '@/types';

const props = defineProps<{ projects: ProjectCardType[] }>();

const heroRef = ref<HTMLElement | null>(null);
useHeroParallax(heroRef);

const techFilter = ref('all');

const techChips = computed(() => {
    const techs: string[] = [];

    for (const project of props.projects) {
        for (const tech of project.technologies) {
            if (!techs.includes(tech)) {
                techs.push(tech);
            }
        }
    }

    return techs;
});

const visibleProjects = computed(() =>
    techFilter.value === 'all'
        ? props.projects
        : props.projects.filter((project) =>
              project.technologies.includes(techFilter.value),
          ),
);

const skills = [
    'Laravel',
    'PHP',
    'MySQL',
    'Tailwind CSS',
    'Alpine.js',
    'Livewire',
    'REST API',
    'Git',
];

const services = [
    {
        title: 'Pengembangan Web App',
        description:
            'Membangun aplikasi web dari nol dengan Laravel — arsitektur rapi, aman, dan mudah dikembangkan.',
        icon: 'code',
    },
    {
        title: 'Sistem Informasi Custom',
        description:
            'Merancang sistem sesuai alur kerja tim: pendataan, approval, hingga pelaporan yang siap dipakai.',
        icon: 'database',
    },
    {
        title: 'Maintenance & Optimasi',
        description:
            'Merawat, memperbaiki, dan mempercepat aplikasi Laravel yang sudah berjalan agar tetap andal.',
        icon: 'gauge',
    },
] as const;

const workflowSteps = [
    {
        step: '01',
        icon: 'search',
        title: 'Discovery & Analisis Kebutuhan',
        description:
            'Setiap project dimulai dari masalah yang jelas — bukan langsung koding. Saya menggali tujuan bisnis, mewawancarai stakeholder, dan memetakan alur pengguna sampai scope-nya terukur.',
        deliverables: ['Requirement Doc', 'User Flow', 'Scope & Estimasi'],
    },
    {
        step: '02',
        icon: 'blueprint',
        title: 'Perencanaan & Arsitektur',
        description:
            'Skema database (ERD), arsitektur aplikasi, dan milestone dirancang di awal. Keputusan teknis diambil dengan sadar agar sistem tetap mudah dikembangkan bertahun-tahun ke depan.',
        deliverables: ['ERD', 'Arsitektur Sistem', 'Roadmap Milestone'],
    },
    {
        step: '03',
        icon: 'design',
        title: 'Desain UI/UX & Prototype',
        description:
            'Wireframe hingga prototype divalidasi bersama klien sebelum satu baris kode ditulis — merevisi desain jauh lebih murah daripada merevisi kode.',
        deliverables: ['Wireframe', 'Prototype', 'Design System'],
    },
    {
        step: '04',
        icon: 'code',
        title: 'Development Iteratif',
        description:
            'Fitur dibangun bertahap dengan Git workflow, standar clean code, dan code review. Demo progres berkala memastikan klien selalu tahu sampai mana pengerjaan.',
        deliverables: ['Git Workflow', 'Code Review', 'Demo Berkala'],
    },
    {
        step: '05',
        icon: 'shield',
        title: 'Testing & Quality Assurance',
        description:
            'Automated testing, uji manual, audit keamanan, dan optimasi query. Sebuah fitur baru saya anggap selesai hanya jika sudah teruji dan aman.',
        deliverables: ['Automated Test', 'Security Check', 'Optimasi Performa'],
    },
    {
        step: '06',
        icon: 'deploy',
        title: 'Deployment & CI/CD',
        description:
            'Rilis lewat pipeline otomatis: diuji di staging dulu, baru naik ke production — lengkap dengan backup dan rencana rollback, tanpa mengganggu pengguna.',
        deliverables: ['CI/CD Pipeline', 'Staging Env', 'Zero-Downtime'],
    },
    {
        step: '07',
        icon: 'monitor',
        title: 'Monitoring & Maintenance',
        description:
            'Setelah rilis, sistem terus dimonitor: error, uptime, dan performa. Dokumentasi teknis dan training memastikan tim Anda mandiri — sistem yang baik dirawat, bukan ditinggal.',
        deliverables: ['Dokumentasi', 'Training', 'Support Berkelanjutan'],
    },
] as const;
</script>

<template>
    <Head title="Beranda" />
    <PublicLayout>
        <!-- HERO -->
        <section
            id="beranda"
            ref="heroRef"
            class="relative scroll-mt-[100px] overflow-hidden bg-[radial-gradient(1100px_560px_at_82%_-10%,color-mix(in_oklch,var(--accent)_13%,transparent),transparent_58%)] pt-[clamp(104px,12vw,132px)] pb-[clamp(30px,4vw,48px)]"
        >
            <svg
                aria-hidden="true"
                class="pointer-events-none absolute top-0 left-0 z-0 h-full w-full stroke-accent"
                preserveAspectRatio="none"
                viewBox="0 0 1440 780"
                fill="none"
            >
                <path
                    d="M-40 560 C 320 500 720 650 1500 430"
                    stroke-opacity="0.06"
                    stroke-width="1.4"
                    pathLength="1"
                    style="
                        stroke-dasharray: 1;
                        stroke-dashoffset: 1;
                        animation: drawLine 2.4s ease 0.2s forwards;
                    "
                />
                <path
                    d="M-40 600 C 360 545 760 690 1500 470"
                    stroke-opacity="0.05"
                    stroke-width="1.4"
                    pathLength="1"
                    style="
                        stroke-dasharray: 1;
                        stroke-dashoffset: 1;
                        animation: drawLine 2.4s ease 0.4s forwards;
                    "
                />
                <path
                    d="M-40 640 C 320 600 800 710 1500 520"
                    stroke-opacity="0.04"
                    stroke-width="1.4"
                    pathLength="1"
                    style="
                        stroke-dasharray: 1;
                        stroke-dashoffset: 1;
                        animation: drawLine 2.4s ease 0.6s forwards;
                    "
                />
            </svg>
            <div
                class="relative z-1 mx-auto w-full max-w-[1140px] px-[clamp(20px,5vw,44px)]"
            >
                <div
                    class="grid grid-cols-[repeat(auto-fit,minmax(300px,1fr))] items-center gap-[clamp(32px,5vw,72px)]"
                >
                    <div
                        class="hero-fade flex flex-col items-start text-left [--fade-rate:1.2] [--speed:60]"
                    >
                        <span
                            class="inline-flex animate-[welcomeUp_.7s_cubic-bezier(.2,.75,.2,1)_.05s_both] items-center gap-[9px] rounded-full border border-accent-line bg-[color-mix(in_oklch,var(--accent)_8%,var(--surface))] px-[15px] py-2"
                        >
                            <span
                                class="h-2 w-2 animate-[spinSlow_1s_linear] rounded-full bg-accent"
                            ></span>
                            <span
                                class="font-mono text-xs/none font-semibold tracking-[.16em] text-label uppercase"
                                >Founder Nusandi · Software House</span
                            >
                        </span>
                        <h1
                            class="mt-6 animate-[welcomeBlurUp_.75s_cubic-bezier(.2,.75,.2,1)_.14s_both] text-[clamp(40px,5.6vw,74px)]/[1.07] font-extrabold tracking-[-.03em] text-fg"
                        >
                            Halo, saya<br /><span class="text-headline"
                                >Rizki Syandana</span
                            ><span class="text-dot">.</span>
                        </h1>
                        <p
                            class="mt-5 animate-[welcomeBlurUp_.75s_cubic-bezier(.2,.75,.2,1)_.22s_both] text-[clamp(19px,2.4vw,24px)]/[1.3] font-bold text-fg"
                        >
                            Founder Nusandi — software house yang membangun
                            perangkat lunak untuk bisnis Indonesia.
                        </p>
                        <p
                            class="mt-4 max-w-[500px] animate-[welcomeBlurUp_.75s_cubic-bezier(.2,.75,.2,1)_.3s_both] text-[clamp(15px,2vw,16.5px)]/[1.7] text-muted"
                        >
                            Nusandi lahir dari satu keyakinan: perangkat lunak
                            bukan sekadar produk, tapi jembatan — antara cara
                            manual dan digital, antara usaha kecil dan
                            pelanggannya di pulau seberang. Dari Hulu Sungai
                            Tengah, saya membangun sistem Laravel yang rapi,
                            ringan, dan benar-benar dipakai.
                        </p>
                        <div
                            class="mt-[34px] flex animate-[welcomeUp_.75s_cubic-bezier(.2,.75,.2,1)_.38s_both] flex-wrap justify-start gap-3.5"
                        >
                            <a
                                href="#project"
                                class="inline-flex cursor-pointer items-center gap-3 rounded-[13px] border-none bg-accent py-2.5 pr-3 pl-6 text-[15.5px]/none font-semibold text-accent-fg shadow-[0_10px_24px_color-mix(in_oklch,var(--accent)_34%,transparent)] transition-all duration-200 hover:-translate-y-0.5 hover:bg-accent-hover hover:shadow-[0_14px_30px_color-mix(in_oklch,var(--accent)_42%,transparent)]"
                            >
                                Lihat Project
                                <span
                                    class="inline-flex h-[30px] w-[30px] items-center justify-center rounded-full bg-[color-mix(in_oklch,#fff_24%,transparent)]"
                                >
                                    <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.3"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="M5 12h14M13 6l6 6-6 6" />
                                    </svg>
                                </span>
                            </a>
                            <a
                                href="#kontak"
                                class="inline-flex cursor-pointer items-center gap-[9px] rounded-[13px] border border-line-strong bg-surface px-[22px] py-3 text-[15px]/none font-semibold text-fg shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-accent hover:text-accent"
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
                                    <path d="M20 21a8 8 0 1 0-16 0" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                Hubungi Saya
                            </a>
                        </div>
                        <div
                            class="mt-7 flex animate-[welcomeUp_.75s_cubic-bezier(.2,.75,.2,1)_.46s_both] items-center gap-[9px]"
                        >
                            <span
                                class="h-[9px] w-[9px] rounded-full bg-success shadow-[0_0_0_4px_color-mix(in_oklch,var(--success)_22%,transparent)]"
                            ></span>
                            <span class="text-sm/none font-medium text-muted"
                                >Tersedia untuk proyek freelance</span
                            >
                        </div>
                    </div>
                    <div
                        class="hero-fade flex flex-col [--fade-rate:1] [--speed:24]"
                    >
                        <div
                            class="relative mx-auto w-full max-w-[420px] animate-[heroCardIn_.9s_cubic-bezier(.2,.75,.2,1)_.2s_both]"
                        >
                            <div
                                class="hero-layer absolute -top-4 -right-5 z-0 [--depth:-26] [--speed:70]"
                            >
                                <div
                                    class="h-60 w-[180px] animate-[floatBlob_9s_ease-in-out_infinite] rounded-[46%_54%_50%_50%/42%_40%_60%_58%] bg-linear-200 from-[color-mix(in_oklch,var(--accent)_90%,#000_6%)] to-[color-mix(in_oklch,var(--accent)_45%,var(--surface))]"
                                ></div>
                            </div>
                            <div
                                class="hero-layer absolute bottom-1.5 -left-6 z-0 [--depth:-18] [--speed:52]"
                            >
                                <div
                                    class="h-[118px] w-[118px] animate-[floatBlobAlt_7.5s_ease-in-out_infinite] rounded-full bg-linear-150 from-[color-mix(in_oklch,var(--accent)_28%,var(--surface))] to-[color-mix(in_oklch,var(--accent)_82%,transparent)]"
                                ></div>
                            </div>
                            <div
                                class="hero-layer absolute top-[46%] -right-3.5 z-0 [--depth:-30] [--speed:80]"
                            >
                                <div
                                    class="h-[140px] w-[60px] animate-[floatDots_6s_ease-in-out_infinite] bg-[radial-gradient(color-mix(in_oklch,var(--accent)_55%,transparent)_2px,transparent_2.3px)] bg-size-[15px_15px]"
                                ></div>
                            </div>
                            <div class="hero-layer relative z-1 [--depth:10]">
                                <div
                                    class="relative aspect-37/50 animate-[panelFloat_8s_ease-in-out_infinite] overflow-hidden rounded-[28px] border border-accent-line bg-linear-165 from-[color-mix(in_oklch,var(--accent)_12%,var(--surface))] to-surface shadow-lg"
                                >
                                    <img
                                        src="/images/sandev-portrait.png"
                                        alt="Rizki Syandana, Founder Nusandi"
                                        class="absolute inset-0 h-full w-full object-cover object-top"
                                    />
                                    <div
                                        class="absolute inset-x-0 bottom-0 z-2 flex items-center gap-2.5 bg-linear-to-t from-[color-mix(in_oklch,var(--brand)_94%,transparent)] to-transparent px-4 pt-12 pb-4"
                                    >
                                        <span
                                            class="h-2.5 w-2.5 flex-none rounded-full bg-dot"
                                        ></span>
                                        <div class="min-w-0">
                                            <div
                                                class="text-[14.5px]/[1.2] font-bold text-white"
                                            >
                                                Rizki Syandana
                                            </div>
                                            <div
                                                class="mt-[3px] font-mono text-[10.5px]/[1.2] font-medium tracking-[.14em] text-white/70 uppercase"
                                            >
                                                Founder Nusandi
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="hero-layer absolute top-[18%] -left-3.5 z-3 [--depth:22] [--speed:-14]"
                            >
                                <div
                                    class="animate-[heroChipInLeft_.7s_cubic-bezier(.2,.75,.2,1)_.55s_both,floatCard_5.5s_ease-in-out_1.25s_infinite] rounded-2xl border border-line bg-[color-mix(in_oklch,var(--surface)_90%,transparent)] px-[17px] py-[13px] shadow-lg backdrop-blur-[10px]"
                                >
                                    <div
                                        class="text-[30px]/none font-extrabold tracking-[-.02em] text-accent"
                                    >
                                        3+
                                    </div>
                                    <div
                                        class="mt-1 text-[12.5px]/[1.3] font-medium text-muted"
                                    >
                                        Tahun<br />Pengalaman
                                    </div>
                                </div>
                            </div>
                            <div
                                class="hero-layer absolute -right-4 bottom-3.5 z-3 [--depth:28] [--speed:-14]"
                            >
                                <div
                                    class="flex max-w-[246px] animate-[heroChipInRight_.7s_cubic-bezier(.2,.75,.2,1)_.68s_both,floatCardSlow_6.5s_ease-in-out_1.38s_infinite] items-center gap-3 rounded-2xl border border-line bg-[color-mix(in_oklch,var(--surface)_90%,transparent)] px-4 py-[13px] shadow-lg backdrop-blur-[10px]"
                                >
                                    <span
                                        class="inline-flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-linear-135 from-accent to-[color-mix(in_oklch,var(--accent)_58%,#000_24%)]"
                                    >
                                        <svg
                                            width="22"
                                            height="22"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#fff"
                                            stroke-width="2.2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path
                                                d="m9 8-4 4 4 4M15 8l4 4-4 4"
                                            />
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <div
                                            class="text-sm/[1.2] font-bold text-fg"
                                        >
                                            Laravel Enthusiast
                                        </div>
                                        <div
                                            class="mt-[3px] text-[11px]/[1.5] font-medium text-muted"
                                        >
                                            Clean Code • Performance<br />Scalable
                                            • Maintainable
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="mt-[clamp(38px,5vw,64px)] flex animate-[welcomeUp_.8s_cubic-bezier(.2,.75,.2,1)_.55s_both] flex-wrap items-center justify-center gap-[clamp(14px,2vw,26px)] rounded-[20px] border border-line bg-surface px-[clamp(18px,2.4vw,28px)] py-[clamp(15px,1.8vw,19px)] shadow-md"
                >
                    <div class="flex flex-none items-center gap-[13px]">
                        <span
                            class="inline-flex h-10 w-10 flex-none items-center justify-center rounded-[11px] bg-linear-135 from-accent to-[color-mix(in_oklch,var(--accent)_58%,#000_24%)]"
                        >
                            <svg
                                width="19"
                                height="19"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#fff"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    d="M12 3l7 3v5.5c0 4.2-3 6.8-7 8-4-1.2-7-3.8-7-8V6z"
                                />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                        </span>
                        <span class="text-[13.5px]/[1.35] font-semibold text-fg"
                            >Dipercaya oleh teknologi<br />modern &amp;
                            terpercaya</span
                        >
                    </div>
                    <div class="h-[38px] w-px bg-line"></div>
                    <div
                        class="flex flex-wrap items-center justify-center gap-[clamp(16px,2.6vw,34px)]"
                    >
                        <div class="flex items-center gap-[9px]">
                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="#F53003"
                            >
                                <path
                                    d="M3.2 7 8 4.2 12.8 7 8 9.8zM2.6 8.1l4.8 2.8v5.6l-4.8-2.8zm10.8 0v5.6l-4.8 2.8v-5.6zM14 14.9l4.8-2.8L23.4 15 18.6 17.8zm-.6 1.1 4.8 2.8v5l-4.8-2.8z"
                                />
                            </svg>
                            <span class="text-sm/none font-semibold text-fg"
                                >Laravel</span
                            >
                        </div>
                        <div class="flex items-center gap-[9px]">
                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="#06B6D4"
                            >
                                <path
                                    d="M12 6c-2.67 0-4.33 1.33-5 4 1-1.33 2.17-1.83 3.5-1.5.76.19 1.3.74 1.9 1.35C13.4 10.84 14.55 12 17 12c2.67 0 4.33-1.33 5-4-1 1.33-2.17 1.83-3.5 1.5-.76-.19-1.3-.74-1.9-1.35C15.6 7.16 14.45 6 12 6zM7 12c-2.67 0-4.33 1.33-5 4 1-1.33 2.17-1.83 3.5-1.5.76.19 1.3.74 1.9 1.35C8.4 16.84 9.55 18 12 18c2.67 0 4.33-1.33 5-4-1 1.33-2.17 1.83-3.5 1.5-.76-.19-1.3-.74-1.9-1.35C10.6 13.16 9.45 12 7 12z"
                                />
                            </svg>
                            <span class="text-sm/none font-semibold text-fg"
                                >Tailwind CSS</span
                            >
                        </div>
                        <div class="flex items-center gap-[9px]">
                            <svg width="22" height="22" viewBox="0 0 24 24">
                                <path
                                    d="M13 5.5 19.5 12 15.5 16 6 6.5z"
                                    fill="#77C1D2"
                                />
                                <path
                                    d="M8 10 12 14l-2.4 2.4L5.6 12.4z"
                                    fill="#2C3E50"
                                />
                            </svg>
                            <span class="text-sm/none font-semibold text-fg"
                                >Alpine.js</span
                            >
                        </div>
                        <div class="flex items-center gap-[9px]">
                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="#00758F"
                            >
                                <path
                                    d="M2 13.4c2 .6 3.6.5 5-.5-.2 1.1 0 2 .7 2.9-1.8.1-3.2-.2-4.4-1.2-.6-.4-1-.8-1.3-1.2zm4.8-2.1C8.4 10 9.5 8.5 11.3 7.6c2.1-1.1 4.3-.9 6.4.2-1 .1-1.8.5-2.4 1.2 1 .2 1.7.8 2.4 1.8-2.3.3-4-.2-5.9-1-1.5-.7-3.2-.9-5-.5z"
                                />
                                <circle cx="19.6" cy="8.5" r=".9" />
                            </svg>
                            <span class="text-sm/none font-semibold text-fg"
                                >MySQL</span
                            >
                        </div>
                        <div class="flex items-center gap-[9px]">
                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#F05133"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <line x1="6" y1="5" x2="6" y2="19" />
                                <circle
                                    cx="6"
                                    cy="4"
                                    r="1.8"
                                    fill="#F05133"
                                    stroke="none"
                                />
                                <circle
                                    cx="6"
                                    cy="20"
                                    r="1.8"
                                    fill="#F05133"
                                    stroke="none"
                                />
                                <circle
                                    cx="17"
                                    cy="7"
                                    r="1.8"
                                    fill="#F05133"
                                    stroke="none"
                                />
                                <path d="M17 9a9 9 0 0 1-9 9" />
                            </svg>
                            <span class="text-sm/none font-semibold text-fg"
                                >Git</span
                            >
                        </div>
                        <div class="flex items-center gap-[9px]">
                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="#2496ED"
                            >
                                <rect
                                    x="4.4"
                                    y="9"
                                    width="2.5"
                                    height="2.5"
                                    rx=".3"
                                />
                                <rect
                                    x="7.5"
                                    y="9"
                                    width="2.5"
                                    height="2.5"
                                    rx=".3"
                                />
                                <rect
                                    x="10.6"
                                    y="9"
                                    width="2.5"
                                    height="2.5"
                                    rx=".3"
                                />
                                <rect
                                    x="7.5"
                                    y="5.9"
                                    width="2.5"
                                    height="2.5"
                                    rx=".3"
                                />
                                <rect
                                    x="10.6"
                                    y="5.9"
                                    width="2.5"
                                    height="2.5"
                                    rx=".3"
                                />
                                <path
                                    d="M2 12.3h16.4c.2 1.6-.5 3.2-1.9 4.3-1.3 1-3 1.4-4.8 1.4-3.6 0-6.6-1.3-8.3-3.7-.6-.9-1.1-1.4-1.4-2z"
                                />
                                <path
                                    d="M18.8 11.2c.5-1 .3-2.2-.3-2.8-.6.6-.8 1.6-.4 2.5z"
                                />
                            </svg>
                            <span class="text-sm/none font-semibold text-fg"
                                >Docker</span
                            >
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TENTANG -->
        <section
            id="tentang"
            class="scroll-mt-[100px] border-y border-line bg-surface-2 py-(--sec-pad)"
        >
            <div
                class="mx-auto w-full max-w-[1140px] px-[clamp(20px,5vw,44px)]"
            >
                <div
                    class="grid grid-cols-[repeat(auto-fit,minmax(280px,1fr))] items-center gap-[clamp(32px,5vw,64px)]"
                >
                    <div v-reveal.left>
                        <div
                            class="flex aspect-4/5 max-w-[420px] items-center justify-center rounded-[18px] border border-line placeholder-stripes shadow-md"
                        >
                            <span
                                class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3.5 py-2 font-mono text-[12.5px]/none font-medium text-subtle"
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
                                    <rect
                                        x="3"
                                        y="3"
                                        width="18"
                                        height="18"
                                        rx="2"
                                    />
                                    <circle cx="9" cy="9" r="1.8" />
                                    <path
                                        d="m21 15-3.1-3.1a2 2 0 0 0-2.8 0L6 21"
                                    />
                                </svg>
                                foto profil
                            </span>
                        </div>
                    </div>
                    <div>
                        <span
                            v-reveal
                            class="font-mono text-xs/none font-medium tracking-[.16em] text-label uppercase"
                            >Tentang Saya</span
                        >
                        <h2
                            v-reveal.blur="80"
                            class="mt-4 text-[clamp(28px,4vw,40px)]/[1.12] font-extrabold tracking-[-.02em] text-fg"
                        >
                            Developer yang peduli pada detail dan
                            maintainability.
                        </h2>
                        <p
                            v-reveal="160"
                            class="mt-[18px] text-[16.5px]/[1.7] text-muted"
                        >
                            Selama lebih dari 3 tahun saya membangun sistem
                            informasi untuk kebutuhan internal instansi dan
                            UMKM. Mulai dari analisis kebutuhan, perancangan
                            basis data, hingga deployment dan pemeliharaan.
                        </p>
                        <p
                            v-reveal="220"
                            class="mt-3.5 text-[16.5px]/[1.7] text-muted"
                        >
                            Prinsip saya sederhana: kode yang rapi, alur yang
                            jelas, dan aplikasi yang benar-benar dipakai orang.
                        </p>
                        <div
                            v-reveal="280"
                            class="mt-[26px] font-mono text-[11px]/none font-medium tracking-[.12em] text-subtle uppercase"
                        >
                            Skill Utama
                        </div>
                        <div class="mt-3.5 flex flex-wrap gap-2.5">
                            <span
                                v-for="(skill, i) in skills"
                                :key="skill"
                                v-reveal="{
                                    delay: 320 + i * 40,
                                    duration: 500,
                                }"
                                class="inline-flex items-center rounded-[10px] border border-line bg-surface px-[15px] py-[9px] text-sm/none font-medium text-fg"
                            >
                                {{ skill }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- PROJECT -->
        <section id="project" class="scroll-mt-[100px] py-(--sec-pad)">
            <div
                class="mx-auto w-full max-w-[1140px] px-[clamp(20px,5vw,44px)]"
            >
                <div class="flex flex-wrap items-end justify-between gap-5">
                    <div class="max-w-[620px]">
                        <span
                            v-reveal
                            class="font-mono text-xs/none font-medium tracking-[.16em] text-label uppercase"
                            >Project</span
                        >
                        <h2
                            v-reveal.blur="80"
                            class="mt-4 text-[clamp(28px,4vw,40px)]/[1.12] font-extrabold tracking-[-.02em] text-fg"
                        >
                            Karya yang pernah saya bangun.
                        </h2>
                        <p
                            v-reveal="160"
                            class="mt-3.5 text-[16.5px]/[1.65] text-muted"
                        >
                            Enam sistem informasi yang saya rancang dan
                            kembangkan. Saring berdasarkan teknologi untuk
                            melihat yang relevan.
                        </p>
                    </div>
                    <span
                        v-reveal="240"
                        class="font-mono text-[13px]/none font-medium whitespace-nowrap text-subtle"
                        >{{ visibleProjects.length }} /
                        {{ projects.length }} project</span
                    >
                </div>
                <div v-reveal="200" class="mt-7 flex flex-wrap gap-2.5">
                    <button
                        v-for="chip in ['all', ...techChips]"
                        :key="chip"
                        type="button"
                        class="inline-flex cursor-pointer items-center gap-[7px] rounded-full px-4 py-[9px] text-[13.5px]/none font-semibold whitespace-nowrap transition-all duration-[.18s]"
                        :class="
                            techFilter === chip
                                ? 'border border-accent bg-accent text-accent-fg shadow-sm'
                                : 'border border-line bg-surface-2 text-muted'
                        "
                        @click="techFilter = chip"
                    >
                        {{ chip === 'all' ? 'Semua' : chip }}
                    </button>
                </div>
                <div
                    class="mt-7 grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-[22px]"
                >
                    <ProjectCard
                        v-for="(project, i) in visibleProjects"
                        :key="project.id"
                        v-reveal="{ delay: (i % 3) * 90 }"
                        :project="project"
                    />
                </div>
                <div
                    v-if="visibleProjects.length === 0"
                    class="px-5 py-15 text-center text-[15px]/[1.5] font-medium text-subtle"
                >
                    Belum ada project dengan teknologi ini.
                </div>
            </div>
        </section>

        <!-- LAYANAN -->
        <section id="layanan" class="scroll-mt-[100px] py-(--sec-pad)">
            <div
                class="mx-auto w-full max-w-[1140px] px-[clamp(20px,5vw,44px)]"
            >
                <div class="max-w-[620px]">
                    <span
                        v-reveal
                        class="font-mono text-xs/none font-medium tracking-[.16em] text-label uppercase"
                        >Layanan</span
                    >
                    <h2
                        v-reveal.blur="80"
                        class="mt-4 text-[clamp(28px,4vw,40px)]/[1.12] font-extrabold tracking-[-.02em] text-fg"
                    >
                        Apa yang bisa saya bantu.
                    </h2>
                    <p
                        v-reveal="160"
                        class="mt-3.5 text-[16.5px]/[1.65] text-muted"
                    >
                        Dari ide sampai aplikasi berjalan — saya bantu di setiap
                        tahap pengembangan sistem berbasis Laravel.
                    </p>
                </div>
                <div
                    class="mt-8 grid grid-cols-[repeat(auto-fit,minmax(260px,1fr))] gap-[22px]"
                >
                    <div
                        v-for="(service, i) in services"
                        :key="service.title"
                        v-reveal="{
                            variant:
                                i === 0 ? 'left' : i === 2 ? 'right' : 'up',
                            delay: i * 110,
                        }"
                        class="rounded-2xl border border-line bg-surface p-[26px] shadow-md transition-all duration-[.22s] hover:-translate-y-1 hover:border-accent-line hover:shadow-lg"
                    >
                        <span
                            class="inline-flex h-12 w-12 items-center justify-center rounded-[13px] border border-accent-line bg-accent-soft text-accent"
                        >
                            <svg
                                v-if="service.icon === 'code'"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="m9 8-4 4 4 4M15 8l4 4-4 4" />
                            </svg>
                            <svg
                                v-else-if="service.icon === 'database'"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <ellipse cx="12" cy="5" rx="8" ry="3" />
                                <path
                                    d="M4 5v6c0 1.66 3.58 3 8 3s8-1.34 8-3V5M4 11v6c0 1.66 3.58 3 8 3s8-1.34 8-3v-6"
                                />
                            </svg>
                            <svg
                                v-else
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M3.5 14a9 9 0 1 1 17 0" />
                                <path d="M12 13l4.5-3" />
                                <circle
                                    cx="12"
                                    cy="13"
                                    r="1.4"
                                    fill="currentColor"
                                    stroke="none"
                                />
                            </svg>
                        </span>
                        <h3
                            class="mt-[18px] text-[18.5px]/[1.3] font-bold text-fg"
                        >
                            {{ service.title }}
                        </h3>
                        <p class="mt-[9px] text-[14.5px]/[1.6] text-muted">
                            {{ service.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- PROSES -->
        <section
            id="proses"
            class="scroll-mt-[100px] border-t border-line bg-surface-2 py-(--sec-pad)"
        >
            <div
                class="mx-auto w-full max-w-[1140px] px-[clamp(20px,5vw,44px)]"
            >
                <div class="max-w-[620px]">
                    <span
                        v-reveal
                        class="font-mono text-xs/none font-medium tracking-[.16em] text-label uppercase"
                        >Proses Kerja</span
                    >
                    <h2
                        v-reveal.blur="80"
                        class="mt-4 text-[clamp(28px,4vw,40px)]/[1.12] font-extrabold tracking-[-.02em] text-fg"
                    >
                        Dari ide sampai rilis — terstruktur dan terukur.
                    </h2>
                    <p
                        v-reveal="160"
                        class="mt-3.5 text-[16.5px]/[1.65] text-muted"
                    >
                        Alur kerja yang sama saya terapkan di setiap project,
                        dari sistem kecil sampai aplikasi kompleks. Transparan
                        di tiap tahap — Anda selalu tahu apa yang sedang
                        dikerjakan dan kenapa.
                    </p>
                </div>
                <div class="relative mt-[clamp(36px,5vw,56px)]">
                    <div
                        aria-hidden="true"
                        class="absolute top-0 bottom-0 left-[21px] w-px -translate-x-1/2 bg-linear-to-b from-transparent via-accent-line to-transparent md:left-1/2"
                    ></div>
                    <div class="flex flex-col gap-[clamp(26px,4vw,40px)]">
                        <div
                            v-for="(item, i) in workflowSteps"
                            :key="item.step"
                            class="relative md:grid md:grid-cols-2 md:gap-x-16"
                        >
                            <div
                                class="absolute top-6 left-[21px] z-1 -translate-x-1/2 md:left-1/2"
                            >
                                <span
                                    v-reveal.scale
                                    class="flex h-11 w-11 items-center justify-center rounded-full border border-accent-line bg-surface font-mono text-[13px]/none font-bold text-label shadow-md"
                                >
                                    {{ item.step }}
                                </span>
                            </div>
                            <div
                                class="ml-14 md:ml-0"
                                :class="
                                    i % 2 === 0
                                        ? 'md:col-start-1'
                                        : 'md:col-start-2'
                                "
                            >
                                <div
                                    v-reveal="{
                                        variant: i % 2 === 0 ? 'left' : 'right',
                                        delay: 80,
                                    }"
                                    class="rounded-2xl border border-line bg-surface p-[26px] shadow-md transition-all duration-[.22s] hover:-translate-y-1 hover:border-accent-line hover:shadow-lg"
                                >
                                    <div class="flex items-center gap-3.5">
                                        <span
                                            class="inline-flex h-12 w-12 flex-none items-center justify-center rounded-[13px] border border-accent-line bg-accent-soft text-accent"
                                        >
                                            <svg
                                                v-if="item.icon === 'search'"
                                                width="23"
                                                height="23"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <circle cx="11" cy="11" r="7" />
                                                <path d="m21 21-4.3-4.3" />
                                            </svg>
                                            <svg
                                                v-else-if="
                                                    item.icon === 'blueprint'
                                                "
                                                width="23"
                                                height="23"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path d="m12 2 9 5-9 5-9-5z" />
                                                <path d="m3 12 9 5 9-5" />
                                                <path d="m3 17 9 5 9-5" />
                                            </svg>
                                            <svg
                                                v-else-if="
                                                    item.icon === 'design'
                                                "
                                                width="23"
                                                height="23"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <rect
                                                    x="3"
                                                    y="3"
                                                    width="18"
                                                    height="18"
                                                    rx="2"
                                                />
                                                <path d="M3 9h18M9 21V9" />
                                            </svg>
                                            <svg
                                                v-else-if="item.icon === 'code'"
                                                width="23"
                                                height="23"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    d="m9 8-4 4 4 4M15 8l4 4-4 4"
                                                />
                                            </svg>
                                            <svg
                                                v-else-if="
                                                    item.icon === 'shield'
                                                "
                                                width="23"
                                                height="23"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    d="M12 3l7 3v5.5c0 4.2-3 6.8-7 8-4-1.2-7-3.8-7-8V6z"
                                                />
                                                <path d="m9 12 2 2 4-4" />
                                            </svg>
                                            <svg
                                                v-else-if="
                                                    item.icon === 'deploy'
                                                "
                                                width="23"
                                                height="23"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    d="M4 14.9A7 7 0 1 1 15.7 8h1.8a4.5 4.5 0 0 1 2.5 8.2"
                                                />
                                                <path d="M12 12v9" />
                                                <path d="m16 16-4-4-4 4" />
                                            </svg>
                                            <svg
                                                v-else
                                                width="23"
                                                height="23"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    d="M22 12h-4l-3 9L9 3l-3 9H2"
                                                />
                                            </svg>
                                        </span>
                                        <div class="min-w-0">
                                            <div
                                                class="font-mono text-[11px]/none font-semibold tracking-[.14em] text-label uppercase"
                                            >
                                                Step {{ item.step }}
                                            </div>
                                            <h3
                                                class="mt-1.5 text-[18px]/[1.3] font-bold text-fg"
                                            >
                                                {{ item.title }}
                                            </h3>
                                        </div>
                                    </div>
                                    <p
                                        class="mt-3.5 text-[14.5px]/[1.65] text-muted"
                                    >
                                        {{ item.description }}
                                    </p>
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <span
                                            v-for="deliverable in item.deliverables"
                                            :key="deliverable"
                                            class="inline-flex items-center gap-1.5 rounded-full border border-line bg-surface-2 px-3 py-[7px] font-mono text-[11.5px]/none font-medium text-muted"
                                        >
                                            <svg
                                                width="11"
                                                height="11"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.6"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="text-accent"
                                            >
                                                <path d="m5 12 5 5L20 7" />
                                            </svg>
                                            {{ deliverable }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- KONTAK -->
        <section
            id="kontak"
            class="scroll-mt-[100px] border-t border-line bg-surface-2 py-(--sec-pad)"
        >
            <div
                class="mx-auto w-full max-w-[1140px] px-[clamp(20px,5vw,44px)] text-center"
            >
                <span
                    v-reveal
                    class="font-mono text-xs/none font-medium tracking-[.16em] text-label uppercase"
                    >Kontak</span
                >
                <h2
                    v-reveal.blur="80"
                    class="mt-4 text-[clamp(28px,4vw,42px)]/[1.1] font-extrabold tracking-[-.02em] text-fg"
                >
                    Mari berkolaborasi.
                </h2>
                <p
                    v-reveal="160"
                    class="mx-auto mt-4 max-w-[560px] text-[16.5px]/[1.65] text-muted"
                >
                    Punya ide sistem atau butuh developer untuk project Laravel
                    Anda? Hubungi saya lewat kanal berikut.
                </p>
                <div class="mt-[34px] flex flex-wrap justify-center gap-3.5">
                    <a
                        v-reveal.scale="240"
                        href="https://wa.me/6281254418925"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex cursor-pointer items-center gap-[9px] rounded-[11px] border-none bg-accent px-[22px] py-[13px] text-[15px]/none font-semibold text-accent-fg shadow-sm transition-all duration-200 hover:-translate-y-px hover:bg-accent-hover hover:shadow-md"
                    >
                        <svg
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
                        </svg>
                        WhatsApp
                    </a>
                    <a
                        v-reveal.scale="320"
                        href="mailto:ikisandana@gmail.com"
                        class="inline-flex cursor-pointer items-center gap-[9px] rounded-[11px] border border-line-strong bg-surface px-[21px] py-3 text-[15px]/none font-semibold text-fg transition-all duration-200 hover:border-accent hover:text-accent"
                    >
                        <svg
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="m22 7-9.16 5.7a2 2 0 0 1-1.68 0L2 7" />
                        </svg>
                        Email
                    </a>
                    <a
                        v-reveal.scale="400"
                        href="https://github.com/akuiki1"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex cursor-pointer items-center gap-[9px] rounded-[11px] border border-line-strong bg-surface px-[21px] py-3 text-[15px]/none font-semibold text-fg transition-all duration-200 hover:border-accent hover:text-accent"
                    >
                        <svg
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                        >
                            <path
                                d="M12 .5C5.73.5.5 5.73.5 12c0 5.09 3.29 9.4 7.86 10.93.58.11.79-.25.79-.56v-2c-3.2.7-3.88-1.37-3.88-1.37-.53-1.34-1.29-1.7-1.29-1.7-1.05-.72.08-.71.08-.71 1.16.08 1.77 1.2 1.77 1.2 1.03 1.77 2.7 1.26 3.36.96.1-.75.4-1.26.73-1.55-2.56-.29-5.25-1.28-5.25-5.7 0-1.26.45-2.29 1.19-3.1-.12-.29-.52-1.46.11-3.05 0 0 .97-.31 3.18 1.18a11 11 0 0 1 5.79 0c2.2-1.49 3.17-1.18 3.17-1.18.63 1.59.23 2.76.11 3.05.74.81 1.19 1.84 1.19 3.1 0 4.43-2.69 5.41-5.26 5.69.41.36.78 1.05.78 2.12v3.15c0 .31.21.68.8.56A11.51 11.51 0 0 0 23.5 12C23.5 5.73 18.27.5 12 .5Z"
                            />
                        </svg>
                        GitHub
                    </a>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
