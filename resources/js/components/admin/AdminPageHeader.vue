<script setup lang="ts">
import type { Component } from 'vue';

type Props = {
    /** Page title shown on the left of the header. */
    title: string;
    /** Optional supporting text under the title. */
    description?: string;
    /** Optional icon rendered in front of the title. */
    icon?: Component;
};

const props = withDefaults(defineProps<Props>(), {
    description: undefined,
    icon: undefined,
});
</script>

<template>
    <div class="admin-page-header">
        <div class="flex min-w-0 items-start gap-3">
            <div
                v-if="props.icon"
                class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary"
            >
                <component :is="props.icon" class="size-5" />
            </div>

            <div class="min-w-0">
                <h1 class="admin-page-title truncate">{{ props.title }}</h1>
                <p v-if="props.description" class="admin-page-description">
                    {{ props.description }}
                </p>
            </div>
        </div>

        <div v-if="$slots.actions" class="flex flex-wrap items-center gap-2">
            <slot name="actions" />
        </div>
    </div>
</template>
