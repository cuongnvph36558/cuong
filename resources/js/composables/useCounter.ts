import { onBeforeUnmount, onMounted } from 'vue';

/**
 * Animates every `[data-target]` element into a formatted number when it scrolls into view.
 */
export function useCounter(selector = '[data-target]'): void {
    let observer: IntersectionObserver | null = null;
    let frame = 0;

    function format(value: number): string {
        return new Intl.NumberFormat('vi-VN').format(Math.round(value));
    }

    function animate(element: HTMLElement): void {
        const target = Number(element.dataset.target ?? '0');
        const duration = 2000;
        const start = performance.now();

        function step(now: number): void {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);

            element.textContent = format(target * eased);

            if (progress < 1) {
                frame = requestAnimationFrame(step);
            }
        }

        frame = requestAnimationFrame(step);
    }

    onMounted(() => {
        if (
            typeof window === 'undefined' ||
            !('IntersectionObserver' in window)
        ) {
            return;
        }

        const elements = document.querySelectorAll<HTMLElement>(selector);

        observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    animate(entry.target as HTMLElement);
                    observer?.unobserve(entry.target);
                });
            },
            { threshold: 0.4 },
        );

        elements.forEach((element) => observer?.observe(element));
    });

    onBeforeUnmount(() => {
        cancelAnimationFrame(frame);
        observer?.disconnect();
    });
}
