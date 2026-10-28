<script setup lang="ts">
import type { Component } from 'vue';

type Props = {
    /** Label describing the metric. */
    label: string;
    /** Metric value. */
    value: string | number;
    /** Optional supporting hint under the value. */
    hint?: string;
    /** Optional icon rendered in the top right corner. */
    icon?: Component;
    /** Accent tone for the icon badge. */
    tone?: 'primary' | 'success' | 'warning' | 'muted';
};

const props = withDefaults(defineProps<Props>(), {
    hint: undefined,
    icon: undefined,
    tone: 'primary',
});

const tones: Record<string, string> = {
    primary: 'bg-primary/10 text-primary',
    success: 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400',
    warning: 'bg-amber-500/10 text-amber-600 dark:text-amber-400',
    muted: 'bg-muted text-muted-foreground',
};
</script>

<template>
    <div class="admin-panel flex flex-col gap-1 p-5">
        <div class="flex items-start justify-between gap-3">
            <p class="admin-stat-label">{{ props.label }}</p>

            <div
                v-if="props.icon"
                class="flex size-9 shrink-0 items-center justify-center rounded-lg"
                :class="tones[props.tone]"
            >
                <component :is="props.icon" class="size-4.5" />
            </div>
        </div>

        <p class="admin-stat-value">{{ props.value }}</p>

        <p v-if="props.hint" class="text-xs text-muted-foreground">
            {{ props.hint }}
        </p>
    </div>
</template>
