<script setup lang="ts">
import { Gift, Megaphone, Phone, X } from '@lucide/vue';
import { ref } from 'vue';

type Props = {
    /** Message repeated in the scrolling marquee. */
    message?: string;
    /** Coupon code displayed next to the message. */
    couponCode?: string;
    /** Label of the call-to-action button. */
    ctaLabel?: string;
    /** Anchor the button scrolls to. */
    ctaHref?: string;
    /** Hotline number. */
    hotline?: string;
    /** Hotline href. */
    hotlineHref?: string;
};

const props = withDefaults(defineProps<Props>(), {
    message: 'Nhận ưu đãi - Tặng 100 chai dùng thử',
    couponCode: 'HT212',
    ctaLabel: 'Đăng ký ngay',
    ctaHref: '#dang-ky',
    hotline: '0973.42.6704',
    hotlineHref: 'tel:0973426704',
});

const dismissed = ref(false);
</script>

<template>
    <div
        v-if="!dismissed"
        class="sticky top-0 z-50 overflow-hidden bg-gradient-to-r from-emerald-700 via-emerald-600 to-lime-600"
    >
        <div class="mx-auto flex max-w-7xl items-center gap-3 px-3 py-2 sm:px-6">
            <div class="relative min-w-0 flex-1 overflow-hidden">
                <div class="rootbio-marquee-track flex w-max items-center">
                    <div
                        v-for="copy in 2"
                        :key="copy"
                        class="flex items-center gap-8 pr-8"
                    >
                        <span
                            v-for="index in 4"
                            :key="index"
                            class="flex items-center gap-2 text-[11px] font-black tracking-wide text-white uppercase sm:text-xs"
                        >
                            <Megaphone class="size-3.5 shrink-0" />
                            {{ props.message }}
                            <Gift class="size-3.5 shrink-0" />
                            Mã: {{ props.couponCode }}
                        </span>
                    </div>
                </div>
            </div>

            <a
                :href="props.hotlineHref"
                class="hidden size-9 shrink-0 items-center justify-center rounded-full bg-white/15 text-white transition hover:bg-white/30 sm:flex"
                :aria-label="`Gọi ${props.hotline}`"
            >
                <Phone class="size-4" />
            </a>

            <a
                :href="props.ctaHref"
                class="rootbio-cta rootbio-cta-ring rootbio-cta-shake rootbio-cta-lime rootbio-cta-xl shrink-0 rounded-full bg-lime-400 font-black tracking-wide text-emerald-950 uppercase shadow-md shadow-emerald-900/20"
            >
                {{ props.ctaLabel }}
            </a>

            <button
                type="button"
                class="hidden size-7 shrink-0 items-center justify-center rounded-full text-white/80 transition hover:text-white md:flex"
                aria-label="Đóng thanh ưu đãi"
                @click="dismissed = true"
            >
                <X class="size-4" />
            </button>
        </div>
    </div>
</template>
