import { onBeforeUnmount, onMounted } from 'vue';

/**
 * Adds a "reveal on scroll" animation to every element matching the selector.
 */
export function useScrollReveal(selector = '[data-reveal]'): void {
    let observer: IntersectionObserver | null = null;

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

                    entry.target.classList.add('is-revealed');
                    observer?.unobserve(entry.target);
                });
            },
            { threshold: 0.12, rootMargin: '0px 0px -60px 0px' },
        );

        elements.forEach((element) => observer?.observe(element));
    });

    onBeforeUnmount(() => {
        observer?.disconnect();
    });
}
