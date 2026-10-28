import { onBeforeUnmount, ref, type Ref } from 'vue';

export type TiltOptions = {
    /** Maximum rotation in degrees on the X axis. */
    max?: number;
    /** Maximum rotation in degrees on the Y axis. */
    maxY?: number;
    /** Scale applied while hovering. */
    scale?: number;
    /** Perspective distance in pixels. */
    perspective?: number;
    /** Whether the tilt reacts to the pointer. */
    enabled?: Ref<boolean> | boolean;
};

export type TiltState = {
    rotateX: Ref<number>;
    rotateY: Ref<number>;
    scale: Ref<number>;
    glareX: Ref<number>;
    glareY: Ref<number>;
    isHovering: Ref<boolean>;
};

/**
 * Adds a 3D "tilt card" behaviour to an element, reacting to the pointer position.
 */
export function useTilt(options: TiltOptions = {}): TiltState & {
    bind: (el: HTMLElement) => void;
} {
    const {
        max = 12,
        maxY = 12,
        scale = 1.04,
        perspective = 1000,
        enabled = true,
    } = options;

    const rotateX = ref(0);
    const rotateY = ref(0);
    const scaleValue = ref(1);
    const glareX = ref(50);
    const glareY = ref(50);
    const isHovering = ref(false);

    let element: HTMLElement | null = null;
    let frame = 0;

    const isEnabled = () =>
        typeof enabled === 'boolean' ? enabled : enabled.value;

    function onPointerMove(event: PointerEvent): void {
        if (!element || !isEnabled()) {
            return;
        }

        const rect = element.getBoundingClientRect();
        const percentX = (event.clientX - rect.left) / rect.width;
        const percentY = (event.clientY - rect.top) / rect.height;

        cancelAnimationFrame(frame);
        frame = requestAnimationFrame(() => {
            rotateY.value = (percentX - 0.5) * 2 * maxY;
            rotateX.value = -(percentY - 0.5) * 2 * max;
            scaleValue.value = scale;
            glareX.value = percentX * 100;
            glareY.value = percentY * 100;
        });
    }

    function onPointerEnter(): void {
        if (!isEnabled()) {
            return;
        }

        isHovering.value = true;
    }

    function onPointerLeave(): void {
        isHovering.value = false;
        rotateX.value = 0;
        rotateY.value = 0;
        scaleValue.value = 1;
        glareX.value = 50;
        glareY.value = 50;
    }

    function bind(el: HTMLElement): void {
        element = el;
        el.style.perspective = `${perspective}px`;
        el.style.transformStyle = 'preserve-3d';

        el.addEventListener('pointermove', onPointerMove);
        el.addEventListener('pointerenter', onPointerEnter);
        el.addEventListener('pointerleave', onPointerLeave);
    }

    onBeforeUnmount(() => {
        cancelAnimationFrame(frame);

        if (!element) {
            return;
        }

        element.removeEventListener('pointermove', onPointerMove);
        element.removeEventListener('pointerenter', onPointerEnter);
        element.removeEventListener('pointerleave', onPointerLeave);
    });

    return {
        rotateX,
        rotateY,
        scale: scaleValue,
        glareX,
        glareY,
        isHovering,
        bind,
    };
}
