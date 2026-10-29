<script setup lang="ts">
import {
    DialogClose,
    DialogContent,
    DialogOverlay,
    DialogPortal,
    DialogRoot,
    DialogTitle,
} from 'reka-ui';
import { Gift, Phone, Sparkles, X } from '@lucide/vue';
import { computed, onMounted, ref } from 'vue';
import LeadForm from '@/components/LeadForm.vue';

export type RegisterModalImage = {
    src: string;
    title: string;
};

type Props = {
    /** Heading of the modal. */
    title?: string;
    /** Sub-heading of the modal. */
    subtitle?: string;
    /** Coupon code shown in the offer banner. */
    couponCode?: string;
    /** Number of people already registered. */
    peopleCount?: number;
    /** Hotline number. */
    hotline?: string;
    /** Hotline href. */
    hotlineHref?: string;
    /** Images shown in the scrolling strip below the form. */
    images?: RegisterModalImage[];
    /** Plant type options offered in the select. */
    plantTypes?: string[];
    /** Symptom options offered as checkboxes. */
    symptoms?: string[];
};

const props = withDefaults(defineProps<Props>(), {
    title: 'Nhận ưu đãi - Tặng 100 chai dùng thử',
    subtitle: 'Điền thông tin để kỹ sư nông nghiệp tư vấn miễn phí.',
    couponCode: 'HT212',
    peopleCount: 99,
    hotline: '0973.42.6704',
    hotlineHref: 'tel:0973426704',
    images: () => [],
    plantTypes: () => [],
    symptoms: () => [],
});

const open = ref(false);

/** Images repeated twice so the marquee can loop seamlessly. */
const stripImages = computed(() => [
    ...props.images,
    ...props.images,
]);

onMounted(() => {
    open.value = true;
});
</script>

<template>
    <DialogRoot v-model:open="open">
        <DialogPortal>
            <DialogOverlay
                class="fixed inset-0 z-[60] bg-emerald-950/70 backdrop-blur-sm"
            />

            <DialogContent
                class="fixed top-1/2 left-1/2 z-[70] flex max-h-[calc(100dvh-1.5rem)] w-[calc(100%-1.5rem)] max-w-2xl -translate-x-1/2 -translate-y-1/2 flex-col overflow-hidden rounded-3xl border border-emerald-900/10 bg-white p-0 shadow-2xl shadow-emerald-950/40 focus:outline-none"
                @pointer-down-outside.prevent
            >
                <DialogTitle class="sr-only">
                    {{ props.title }}
                </DialogTitle>

                <!-- Offer header -->
                <div
                    class="relative bg-gradient-to-r from-emerald-700 via-emerald-600 to-lime-600 px-4 py-4 sm:px-6"
                >
                    <DialogClose
                        class="absolute top-3 right-3 flex size-8 items-center justify-center rounded-full bg-white/20 text-white transition hover:bg-white/35"
                        aria-label="Đóng"
                    >
                        <X class="size-4" />
                    </DialogClose>

                    <p
                        class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-2.5 py-1 text-[10px] font-black tracking-wide text-white uppercase"
                    >
                        <Sparkles class="size-3" />
                        Ưu đãi dành riêng cho bạn
                    </p>

                    <h2
                        class="mt-2 pr-8 text-lg leading-tight font-black text-white uppercase sm:text-2xl"
                    >
                        {{ props.title }}
                    </h2>
                    <p class="mt-1 text-xs text-emerald-50">
                        {{ props.subtitle }}
                    </p>

                    <div
                        class="mt-3 flex flex-wrap items-center gap-2 text-white"
                    >
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-lime-400 px-3 py-1.5 text-[11px] font-black tracking-wide text-emerald-950 uppercase"
                        >
                            <Gift class="size-3.5" />
                            Mã: {{ props.couponCode }}
                        </span>

                        <span
                            class="rounded-full bg-white/15 px-3 py-1.5 text-[11px] font-bold"
                        >
                            <strong>{{ props.peopleCount }}</strong> người đã đăng ký
                        </span>

                        <a
                            :href="props.hotlineHref"
                            class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1.5 text-[11px] font-bold transition hover:bg-white/30"
                        >
                            <Phone class="size-3.5" />
                            {{ props.hotline }}
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <div class="min-h-0 flex-1 overflow-y-auto px-4 py-4 sm:px-6">
                    <LeadForm
                        compact
                        source="popup"
                        title="Anh/Chị hãy điền thông tin để được chuyên gia tư vấn"
                        subtitle="Kỹ sư nông nghiệp sẽ liên hệ trực tiếp tư vấn miễn phí."
                        :coupon-code="props.couponCode"
                        :plant-types="props.plantTypes"
                        :symptoms="props.symptoms"
                    />
                </div>

                <!-- Scrolling image strip -->
                <div
                    v-if="props.images.length"
                    class="border-t border-emerald-900/10 bg-emerald-50/60 py-3"
                >
                    <p
                        class="mb-2 px-4 text-center text-[10px] font-black tracking-[0.2em] text-emerald-700 uppercase sm:px-6"
                    >
                        Hình ảnh sản phẩm & vườn cây thực tế
                    </p>

                    <div class="relative overflow-hidden">
                        <div
                            class="rootbio-marquee-track flex w-max items-center gap-3 px-4 sm:px-6"
                        >
                            <figure
                                v-for="(image, index) in stripImages"
                                :key="`${image.src}-${index}`"
                                class="w-24 shrink-0 overflow-hidden rounded-xl border border-emerald-900/10 bg-white shadow-sm sm:w-32"
                            >
                                <img
                                    :src="image.src"
                                    :alt="image.title"
                                    class="aspect-square w-full object-cover"
                                    loading="lazy"
                                />
                                <figcaption
                                    class="truncate px-1.5 py-1 text-center text-[9px] font-bold text-emerald-900 uppercase"
                                >
                                    {{ image.title }}
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
            </DialogContent>
        </DialogPortal>
    </DialogRoot>
</template>
