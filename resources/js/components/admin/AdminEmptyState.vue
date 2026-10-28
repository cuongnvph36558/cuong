<script setup lang="ts">
import type { Component } from 'vue';

type Props = {
    /** Message shown when there is nothing to display. */
    title: string;
    /** Optional supporting text. */
    description?: string;
    /** Optional icon. */
    icon?: Component;
};

const props = withDefaults(defineProps<Props>(), {
    description: undefined,
    icon: undefined,
});
</script>

<template>
    <div
        class="flex flex-col items-center justify-center gap-3 rounded-xl border border-dashed border-border/80 bg-muted/30 px-6 py-14 text-center"
    >
        <div
            v-if="props.icon"
            class="flex size-12 items-center justify-center rounded-full bg-muted text-muted-foreground"
        >
            <component :is="props.icon" class="size-6" />
        </div>

        <div class="space-y-1">
            <p class="text-sm font-semibold text-foreground">
                {{ props.title }}
            </p>
            <p v-if="props.description" class="text-sm text-muted-foreground">
                {{ props.description }}
            </p>
        </div>

        <slot />
    </div>
</template>
