<script setup lang="ts">
import {
    DialogClose,
    DialogContent,
    DialogOverlay,
    DialogPortal,
    DialogRoot,
    DialogTitle,
} from 'reka-ui';
import { ChevronLeft, ChevronRight, Expand, X } from '@lucide/vue';
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';

export type GalleryItem = {
    src: string;
    title: string;
    description: string;
};

type Props = {
    /** Images rendered in the grid. */
    items: GalleryItem[];
    /** Section heading. */
    heading?: string;
    /** Section description. */
    description?: string;
};

const props = withDefaults(defineProps<Props>(), {
    heading: 'Thư viện ảnh',
    description: 'Xem và phóng to hình ảnh sản phẩm, vườn cây của bà con.',
});

const lightboxOpen = ref(false);
const activeIndex = ref(0);

const activeItem = computed(() => props.items[activeIndex.value] ?? null);

function openLightbox(index: number): void {
    activeIndex.value = index;
    lightboxOpen.value = true;
}

function closeLightbox(): void {
    lightboxOpen.value = false;
}

function previous(): void {
    if (props.items.length === 0) {
        return;
    }

    activeIndex.value =
        (activeIndex.value - 1 + props.items.length) % props.items.length;
}

function next(): void {
    if (props.items.length === 0) {
        return;
    }

    activeIndex.value = (activeIndex.value + 1) % props.items.length;
}

function onKeydown(event: KeyboardEvent): void {
    if (event.key === 'ArrowLeft') {
        event.preventDefault();
        previous();
        return;
    }

    if (event.key === 'ArrowRight') {
        event.preventDefault();
        next();
        return;
    }

    if (event.key === 'Escape') {
        lightboxOpen.value = false;
    }
}

watch(lightboxOpen, (isOpen) => {
    if (isOpen) {
        window.addEventListener('keydown', onKeydown);

        return;
    }

    window.removeEventListener('keydown', onKeydown);
});

onMounted(() => {
    if (lightboxOpen.value) {
        window.addEventListener('keydown', onKeydown);
    }
});

onUnmounted(() => {
    window.removeEventListener('keydown', onKeydown);
});
</script>

<template>
    <div>
        <div class="text-center">
            <h2
                data-reveal
                class="text-xl font-black tracking-tight text-emerald-950 uppercase sm:text-3xl"
            >
                {{ props.heading }}
            </h2>
            <p
                v-if="props.description"
                data-reveal
                class="mx-auto mt-2 max-w-2xl text-xs text-slate-600 sm:text-sm"
            >
                {{ props.description }}
            </p>
        </div>

        <div
            class="mt-6 grid grid-cols-2 gap-2.5 sm:grid-cols-3 sm:gap-3 lg:grid-cols-4"
        >
            <button
                v-for="(item, index) in props.items"
                :key="`${item.src}-${index}`"
                type="button"
                data-reveal
                class="group relative aspect-square overflow-hidden rounded-2xl border border-emerald-900/10 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                :aria-label="`Xem ảnh ${item.title}`"
                @click="openLightbox(index)"
            >
                <img
                    :src="item.src"
                    :alt="item.title"
                    class="size-full object-cover transition duration-500 group-hover:scale-105"
                    loading="lazy"
                />

                <span
                    class="pointer-events-none absolute inset-0 bg-gradient-to-t from-emerald-950/85 via-emerald-950/20 to-transparent opacity-90 transition group-hover:opacity-100"
                ></span>

                <span
                    class="pointer-events-none absolute inset-x-0 bottom-0 flex items-end justify-between gap-2 p-2.5 text-left"
                >
                    <span
                        class="line-clamp-2 text-[10px] leading-tight font-black text-white uppercase sm:text-xs"
                    >
                        {{ item.title }}
                    </span>
                    <span
                        class="flex size-6 shrink-0 items-center justify-center rounded-full bg-white/25 text-white opacity-0 transition group-hover:opacity-100"
                    >
                        <Expand class="size-3" />
                    </span>
                </span>
            </button>
        </div>

        <!-- Lightbox -->
        <DialogRoot v-model:open="lightboxOpen">
            <DialogPortal>
                <DialogOverlay
                    class="fixed inset-0 z-[80] bg-emerald-950/90 backdrop-blur-sm"
                />

                <DialogContent
                    class="fixed top-1/2 left-1/2 z-[90] flex w-[calc(100%-1.5rem)] max-w-4xl -translate-x-1/2 -translate-y-1/2 flex-col items-center gap-3 focus:outline-none"
                    @pointer-down-outside.prevent
                >
                    <DialogTitle class="sr-only">
                        {{ activeItem?.title ?? 'Xem ảnh' }}
                    </DialogTitle>

                    <div class="relative w-full">
                        <img
                            v-if="activeItem"
                            :src="activeItem.src"
                            :alt="activeItem.title"
                            class="mx-auto max-h-[70vh] w-auto rounded-2xl object-contain shadow-2xl"
                        />

                        <button
                            type="button"
                            class="absolute top-1/2 left-0 flex size-10 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-emerald-900 shadow-lg transition hover:bg-white"
                            aria-label="Ảnh trước"
                            @click="previous"
                        >
                            <ChevronLeft class="size-5" />
                        </button>

                        <button
                            type="button"
                            class="absolute top-1/2 right-0 flex size-10 translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-emerald-900 shadow-lg transition hover:bg-white"
                            aria-label="Ảnh tiếp theo"
                            @click="next"
                        >
                            <ChevronRight class="size-5" />
                        </button>
                    </div>

                    <div
                        class="w-full rounded-2xl bg-white/10 p-3 text-center backdrop-blur"
                    >
                        <p class="text-sm font-black text-white uppercase">
                            {{ activeItem?.title }}
                        </p>
                        <p
                            v-if="activeItem?.description"
                            class="mt-1 text-xs text-emerald-50"
                        >
                            {{ activeItem.description }}
                        </p>
                        <p class="mt-1 text-[11px] font-bold text-lime-200">
                            {{ activeIndex + 1 }} / {{ props.items.length }}
                        </p>
                    </div>

                    <DialogClose
                        class="absolute top-0 right-0 flex size-9 items-center justify-center rounded-full bg-white/90 text-emerald-900 shadow-lg transition hover:bg-white"
                        aria-label="Đóng"
                    >
                        <X class="size-4" />
                    </DialogClose>
                </DialogContent>
            </DialogPortal>
        </DialogRoot>
    </div>
</template>
