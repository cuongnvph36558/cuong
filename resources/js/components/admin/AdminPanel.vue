<script setup lang="ts">
type Props = {
    /** Panel heading. */
    title?: string;
    /** Optional supporting text under the heading. */
    description?: string;
    /** Removes the body padding, useful for tables. */
    flush?: boolean;
};

const props = withDefaults(defineProps<Props>(), {
    title: undefined,
    description: undefined,
    flush: false,
});
</script>

<template>
    <section class="admin-panel">
        <header v-if="props.title || $slots.header" class="admin-panel-header">
            <slot name="header">
                <div>
                    <h2 class="admin-panel-title">{{ props.title }}</h2>
                    <p v-if="props.description" class="admin-panel-description">
                        {{ props.description }}
                    </p>
                </div>
            </slot>
        </header>

        <div :class="props.flush ? '' : 'p-5'">
            <slot />
        </div>
    </section>
</template>
