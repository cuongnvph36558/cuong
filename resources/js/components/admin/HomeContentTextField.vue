<script setup lang="ts">
import { computed } from 'vue';

type Props = {
    /** Current value of the field. */
    modelValue: string | number;
    /** Element id used by the label. */
    id: string;
    /** Render a textarea instead of an input. */
    multiline?: boolean;
    /** Number of visible rows when multiline. */
    rows?: number;
    /** Input type, e.g. text or number. */
    type?: string;
};

const props = withDefaults(defineProps<Props>(), {
    multiline: false,
    rows: 4,
    type: 'text',
});

const emit = defineEmits<{
    (e: 'update:modelValue', payload: string | number): void;
}>();

const value = computed(() =>
    props.type === 'number' ? Number(props.modelValue ?? 0) : props.modelValue,
);

function onInput(event: Event): void {
    const target = event.target as HTMLInputElement | HTMLTextAreaElement;

    emit(
        'update:modelValue',
        props.type === 'number' ? Number(target.value) : target.value,
    );
}
</script>

<template>
    <textarea
        v-if="props.multiline"
        :id="props.id"
        :value="String(value)"
        :rows="props.rows"
        class="border-input flex field-sizing-content min-h-16 w-full rounded-md border bg-transparent px-3 py-2 text-base shadow-xs outline-none transition-[color,box-shadow] focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
        @input="onInput"
    ></textarea>

    <input
        v-else
        :id="props.id"
        :type="props.type"
        :value="value"
        class="border-input h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs outline-none transition-[color,box-shadow] focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
        @input="onInput"
    />
</template>
