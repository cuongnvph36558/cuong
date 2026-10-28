<script setup lang="ts">
import { computed } from 'vue';
import { useTilt } from '@/composables/useTilt';
import { cn } from '@/lib/utils';

type Props = {
    /** Maximum rotation in degrees. */
    max?: number;
    /** Scale applied while hovering. */
    scale?: number;
    /** Perspective distance in pixels. */
    perspective?: number;
    /** Adds a moving specular highlight. */
    glare?: boolean;
    /** Extra classes for the wrapper element. */
    class?: string;
};

const props = withDefaults(defineProps<Props>(), {
    max: 12,
    scale: 1.04,
    perspective: 1000,
    glare: true,
    class: undefined,
});

const { rotateX, rotateY, scale, glareX, glareY, isHovering, bind } = useTilt({
    max: props.max,
    maxY: props.max,
    scale: props.scale,
    perspective: props.perspective,
});

const transform = computed(
    () =>
        `rotateX(${rotateX.value}deg) rotateY(${rotateY.value}deg) scale(${scale.value})`,
);
</script>

<template>
    <div
        :ref="(el) => el && bind(el as HTMLElement)"
        class="tilt-card group relative"
        :class="[
            cn('will-change-transform', props.class),
            isHovering && 'is-hovering',
        ]"
        :style="{
            transform,
            transition: 'transform 300ms cubic-bezier(0.22, 1, 0.36, 1)',
        }"
    >
        <div
            v-if="props.glare"
            class="pointer-events-none absolute inset-0 z-20 rounded-[inherit] opacity-0 transition-opacity duration-300 group-hover:opacity-100"
            :style="{
                background: `radial-gradient(400px circle at ${glareX}% ${glareY}%, rgba(255,255,255,0.35), transparent 60%)`,
            }"
        />
        <slot />
    </div>
</template>
