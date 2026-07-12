<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, watch } from 'vue';
import { destroy as logout } from '@/actions/App/Http/Controllers/Auth/LoginController';
import ThemeToggle from '@/components/ThemeToggle.vue';
import Toast from '@/components/Toast.vue';
import { useToast } from '@/composables/useToast';
import { home } from '@/routes';
import { dashboard } from '@/routes/admin';
import { index as projectsIndex } from '@/routes/admin/projects';

defineProps<{ crumb: string }>();

const page = usePage();
const toast = useToast();

const isDashboard = computed(() => page.component === 'admin/Dashboard');
const isProjects = computed(() => page.component.startsWith('admin/projects/'));

watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.message) {
            toast.show(flash.message, flash.undoId ?? null);
        }
    },
    { immediate: true },
);

const navBase =
    'flex cursor-pointer items-center gap-[11px] rounded-[10px] border-none px-[13px] py-2.5 text-left text-[14.5px]/none font-semibold transition-all duration-[.16s]';
</script>

<template>
    <div class="flex min-h-screen flex-col bg-bg text-fg min-[861px]:flex-row">
        <aside
            class="flex w-full flex-none flex-row items-stretch gap-2.5 border-r border-line bg-surface p-4 min-[861px]:w-[250px] min-[861px]:flex-col"
        >
            <Link
                :href="dashboard()"
                class="flex cursor-pointer items-center border-none bg-transparent p-2"
            >
                <img
                    src="/images/nusandi-mark-green.png"
                    alt="Nusandi"
                    class="h-[26px] w-auto dark:hidden"
                />
                <img
                    src="/images/nusandi-mark-white.png"
                    alt="Nusandi"
                    class="hidden h-[26px] w-auto dark:block"
                />
            </Link>
            <nav class="flex flex-1 flex-row gap-1 min-[861px]:flex-col">
                <Link
                    :href="dashboard()"
                    :class="[
                        navBase,
                        isDashboard
                            ? 'bg-accent-soft text-label'
                            : 'bg-transparent text-muted',
                    ]"
                >
                    <svg
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.85"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect x="3" y="3" width="7" height="9" rx="1.2" />
                        <rect x="14" y="3" width="7" height="5" rx="1.2" />
                        <rect x="14" y="12" width="7" height="9" rx="1.2" />
                        <rect x="3" y="16" width="7" height="5" rx="1.2" />
                    </svg>
                    Dashboard
                </Link>
                <Link
                    :href="projectsIndex()"
                    :class="[
                        navBase,
                        isProjects
                            ? 'bg-accent-soft text-label'
                            : 'bg-transparent text-muted',
                    ]"
                >
                    <svg
                        width="18"
                        height="18"
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
                    Project
                </Link>
            </nav>
            <div
                class="hidden flex-col gap-2.5 border-t border-line pt-3.5 min-[861px]:flex"
            >
                <div class="flex items-center gap-2.5 px-1.5 py-1">
                    <span
                        class="inline-flex h-[34px] w-[34px] items-center justify-center rounded-[9px] bg-accent-soft text-sm/none font-bold text-label"
                        >RS</span
                    >
                    <div class="min-w-0">
                        <div class="text-[13.5px]/[1.2] font-semibold text-fg">
                            {{ page.props.auth.user?.name ?? 'Rizki Syandana' }}
                        </div>
                        <div
                            class="overflow-hidden font-mono text-[11.5px]/[1.2] font-medium text-ellipsis whitespace-nowrap text-subtle"
                        >
                            {{ page.props.auth.user?.email }}
                        </div>
                    </div>
                </div>
                <Link
                    :href="logout()"
                    as="button"
                    class="flex cursor-pointer items-center gap-2.5 rounded-[10px] border border-line bg-transparent px-3 py-2.5 text-left text-[13.5px]/none font-semibold text-muted transition-all duration-[.16s] hover:border-accent hover:text-accent"
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
                            d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"
                        />
                    </svg>
                    Keluar
                </Link>
            </div>
        </aside>
        <div class="flex min-w-0 flex-1 flex-col">
            <header
                class="sticky top-0 z-20 flex h-[60px] flex-none items-center justify-between border-b border-line bg-[color-mix(in_oklch,var(--bg)_85%,transparent)] px-[clamp(18px,3vw,34px)] backdrop-blur-[10px]"
            >
                <span class="font-mono text-[13px]/none font-medium text-subtle"
                    >admin / {{ crumb }}</span
                >
                <div class="flex items-center gap-2.5">
                    <ThemeToggle size="sm" />
                    <Link
                        :href="home()"
                        class="inline-flex cursor-pointer items-center gap-[7px] rounded-[9px] border border-line bg-surface-2 px-3.5 py-2 text-[13.5px]/none font-semibold text-fg transition-all duration-[.16s] hover:border-accent hover:text-accent"
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
                                d="M15 3h6v6M10 14 21 3M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"
                            />
                        </svg>
                        Lihat situs
                    </Link>
                </div>
            </header>
            <main class="flex-1 p-[clamp(22px,3.5vw,40px)]">
                <slot />
            </main>
        </div>
        <Toast />
    </div>
</template>
