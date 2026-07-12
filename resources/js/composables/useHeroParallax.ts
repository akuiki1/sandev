import { onBeforeUnmount, onMounted } from 'vue';
import type { Ref } from 'vue';

/**
 * Mouse-follow and scroll parallax for the hero section. Writes `--mx`,
 * `--my`, and `--hero-scroll` custom properties on the target element;
 * `.hero-layer` / `.hero-fade` in app.css consume them with per-element
 * `--depth` / `--speed` / `--fade-rate` factors.
 */
export function useHeroParallax(target: Ref<HTMLElement | null>): void {
    let el: HTMLElement | null = null;
    let mouseRafId: number | null = null;
    let scrollRafId: number | null = null;
    let targetX = 0;
    let targetY = 0;
    let currentX = 0;
    let currentY = 0;
    let lastScrollProgress = -1;

    const settleLoop = () => {
        mouseRafId = null;
        currentX += (targetX - currentX) * 0.12;
        currentY += (targetY - currentY) * 0.12;

        if (
            Math.abs(targetX - currentX) + Math.abs(targetY - currentY) <
            0.001
        ) {
            currentX = targetX;
            currentY = targetY;
        }

        el?.style.setProperty('--mx', currentX.toFixed(4));
        el?.style.setProperty('--my', currentY.toFixed(4));

        if (currentX !== targetX || currentY !== targetY) {
            mouseRafId = requestAnimationFrame(settleLoop);
        }
    };

    const startSettleLoop = () => {
        mouseRafId ??= requestAnimationFrame(settleLoop);
    };

    const onMouseMove = (event: MouseEvent) => {
        if (!el) {
            return;
        }

        const rect = el.getBoundingClientRect();
        targetX = Math.min(
            1,
            Math.max(-1, ((event.clientX - rect.left) / rect.width) * 2 - 1),
        );
        targetY = Math.min(
            1,
            Math.max(-1, ((event.clientY - rect.top) / rect.height) * 2 - 1),
        );
        startSettleLoop();
    };

    const onMouseLeave = () => {
        targetX = 0;
        targetY = 0;
        startSettleLoop();
    };

    const onScroll = () => {
        if (scrollRafId !== null) {
            return;
        }

        scrollRafId = requestAnimationFrame(() => {
            scrollRafId = null;

            if (!el) {
                return;
            }

            const progress = Math.min(
                1,
                Math.max(0, window.scrollY / (el.offsetHeight * 0.85)),
            );

            if (progress === lastScrollProgress) {
                return;
            }

            lastScrollProgress = progress;
            el.style.setProperty('--hero-scroll', progress.toFixed(4));
        });
    };

    onMounted(() => {
        el = target.value;

        if (!el || typeof window === 'undefined') {
            return;
        }

        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            return;
        }

        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        if (window.matchMedia('(pointer: fine)').matches) {
            el.addEventListener('mousemove', onMouseMove, { passive: true });
            el.addEventListener('mouseleave', onMouseLeave, { passive: true });
        }
    });

    onBeforeUnmount(() => {
        window.removeEventListener('scroll', onScroll);
        el?.removeEventListener('mousemove', onMouseMove);
        el?.removeEventListener('mouseleave', onMouseLeave);

        if (mouseRafId !== null) {
            cancelAnimationFrame(mouseRafId);
        }

        if (scrollRafId !== null) {
            cancelAnimationFrame(scrollRafId);
        }
    });
}
