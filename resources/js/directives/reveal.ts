import type { Directive, DirectiveBinding } from 'vue';

type RevealVariant = 'up' | 'left' | 'right' | 'scale';

interface RevealOptions {
    variant?: RevealVariant;
    blur?: boolean;
    delay?: number;
    duration?: number;
}

interface ResolvedRevealOptions {
    variant: RevealVariant;
    blur: boolean;
    delay: number;
    duration: number;
}

const REVEAL_PROPS = [
    '--rv-x',
    '--rv-y',
    '--rv-scale',
    '--rv-blur',
    '--rv-delay',
    '--rv-duration',
] as const;

let observer: IntersectionObserver | null = null;
let observedCount = 0;
const cleanups = new WeakMap<HTMLElement, () => void>();

function resolveOptions(
    binding: DirectiveBinding<number | RevealOptions | undefined>,
): ResolvedRevealOptions {
    const value = binding.value;
    const fromValue: RevealOptions =
        typeof value === 'number' ? { delay: value } : (value ?? {});

    const modifierVariant = (['left', 'right', 'scale'] as const).find(
        (variant) => binding.modifiers[variant],
    );

    return {
        variant: fromValue.variant ?? modifierVariant ?? 'up',
        blur: fromValue.blur ?? binding.modifiers.blur ?? false,
        delay: fromValue.delay ?? 0,
        duration: fromValue.duration ?? 700,
    };
}

function applyCustomProps(el: HTMLElement, opts: ResolvedRevealOptions): void {
    if (opts.variant === 'left') {
        el.style.setProperty('--rv-x', '-32px');
        el.style.setProperty('--rv-y', '0px');
    } else if (opts.variant === 'right') {
        el.style.setProperty('--rv-x', '32px');
        el.style.setProperty('--rv-y', '0px');
    } else if (opts.variant === 'scale') {
        el.style.setProperty('--rv-y', '0px');
        el.style.setProperty('--rv-scale', '.94');
    }

    if (opts.blur) {
        el.style.setProperty('--rv-blur', '8px');
    }

    if (opts.delay > 0) {
        el.style.setProperty('--rv-delay', `${opts.delay / 1000}s`);
    }

    if (opts.duration !== 700) {
        el.style.setProperty('--rv-duration', `${opts.duration / 1000}s`);
    }
}

function finishReveal(el: HTMLElement): void {
    el.classList.remove('reveal', 'reveal-visible');

    for (const prop of REVEAL_PROPS) {
        el.style.removeProperty(prop);
    }

    cleanups.get(el)?.();
    cleanups.delete(el);
}

function revealElement(el: HTMLElement, opts: ResolvedRevealOptions): void {
    requestAnimationFrame(() => {
        el.classList.add('reveal-visible');

        const onTransitionEnd = (event: TransitionEvent) => {
            if (event.target === el) {
                finishReveal(el);
            }
        };

        el.addEventListener('transitionend', onTransitionEnd);

        const fallbackTimer = window.setTimeout(
            () => finishReveal(el),
            opts.duration + opts.delay + 150,
        );

        cleanups.set(el, () => {
            el.removeEventListener('transitionend', onTransitionEnd);
            window.clearTimeout(fallbackTimer);
        });
    });
}

function getObserver(): IntersectionObserver {
    observer ??= new IntersectionObserver(
        (entries) => {
            for (const entry of entries) {
                if (!entry.isIntersecting) {
                    continue;
                }

                const el = entry.target as HTMLElement;
                revealElement(el, pendingOptions.get(el) ?? DEFAULT_OPTIONS);
                unobserve(el);
            }
        },
        { threshold: 0, rootMargin: '0px 0px -12% 0px' },
    );

    return observer;
}

const DEFAULT_OPTIONS: ResolvedRevealOptions = {
    variant: 'up',
    blur: false,
    delay: 0,
    duration: 700,
};

const pendingOptions = new WeakMap<HTMLElement, ResolvedRevealOptions>();

function unobserve(el: HTMLElement): void {
    if (!pendingOptions.has(el)) {
        return;
    }

    pendingOptions.delete(el);
    observer?.unobserve(el);
    observedCount--;

    if (observedCount <= 0) {
        observer?.disconnect();
        observer = null;
        observedCount = 0;
    }
}

/**
 * One-shot scroll reveal backed by a shared IntersectionObserver.
 *
 * Usage: `v-reveal` (fade-up), modifiers `.left` / `.right` / `.scale` /
 * `.blur`, number value = delay in ms, or object value
 * `{ variant, blur, delay, duration }` for dynamic per-index options.
 */
export const vReveal: Directive<
    HTMLElement,
    number | RevealOptions | undefined
> = {
    mounted(el, binding) {
        if (typeof window === 'undefined') {
            return;
        }

        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            return;
        }

        const rect = el.getBoundingClientRect();

        if (rect.top < window.innerHeight * 0.85 && rect.bottom > 0) {
            return;
        }

        const opts = resolveOptions(binding);
        applyCustomProps(el, opts);
        el.classList.add('reveal');
        pendingOptions.set(el, opts);
        getObserver().observe(el);
        observedCount++;
    },
    unmounted(el) {
        unobserve(el);
        cleanups.get(el)?.();
        cleanups.delete(el);
    },
};
