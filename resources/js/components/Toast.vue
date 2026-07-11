<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { restore } from '@/actions/App/Http/Controllers/Admin/ProjectController';
import { useToast } from '@/composables/useToast';

const { state, hide } = useToast();

function undo() {
    if (state.undoId === null) {
        return;
    }

    router.post(restore.url({ id: state.undoId }), undefined, {
        onSuccess: () => hide(),
    });
}
</script>

<template>
    <div
        v-if="state.visible"
        class="fixed bottom-[26px] left-1/2 z-200 flex max-w-[calc(100vw-32px)] -translate-x-1/2 animate-[toastIn_.25s_ease] items-center gap-4 rounded-xl border border-line-strong bg-surface px-[18px] py-[13px] shadow-lg"
    >
        <span class="text-sm/[1.4] font-medium text-fg">{{
            state.message
        }}</span>
        <button
            v-if="state.undoId !== null"
            type="button"
            class="cursor-pointer border-none bg-transparent text-sm font-bold whitespace-nowrap text-accent"
            @click="undo"
        >
            Urungkan
        </button>
    </div>
</template>
