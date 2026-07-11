import { reactive } from 'vue';

interface ToastState {
    visible: boolean;
    message: string;
    undoId: number | null;
}

const state = reactive<ToastState>({
    visible: false,
    message: '',
    undoId: null,
});

let timer: ReturnType<typeof setTimeout> | undefined;

export function useToast() {
    function show(message: string, undoId: number | null = null): void {
        state.message = message;
        state.undoId = undoId;
        state.visible = true;

        if (timer) {
            clearTimeout(timer);
        }

        timer = setTimeout(() => hide(), 4200);
    }

    function hide(): void {
        state.visible = false;
        state.undoId = null;

        if (timer) {
            clearTimeout(timer);
            timer = undefined;
        }
    }

    return { state, show, hide };
}
