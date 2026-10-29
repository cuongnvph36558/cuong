<script setup lang="ts">
import { Gift, Megaphone, Phone } from '@lucide/vue';

type Props = {
    /** Message repeated in the scrolling marquee. */
    message?: string;
    /** Coupon code displayed next to the message. */
    couponCode?: string;
    /** Hotline number. */
    hotline?: string;
    /** Hotline href. */
    hotlineHref?: string;
};

const props = withDefaults(defineProps<Props>(), {
    message: 'Thế Hệ Mới - Kích Rễ Mạnh - Đi Đọt Nhanh - Siêu Đậu Trái',
    couponCode: 'ELICPO10',
    hotline: '0973.42.6704',
    hotlineHref: 'tel:0973426704',
});
</script>

<template>
    <div
        class="sticky top-0 z-40 border-b border-emerald-800/30 bg-gradient-to-r from-emerald-700 via-emerald-600 to-lime-600"
    >
        <!-- Offer ticker -->
        <div class="relative overflow-hidden py-1">
            <div class="elicpo-marquee-track flex w-max items-center">
                <div
                    v-for="copy in 2"
                    :key="copy"
                    class="flex items-center gap-5 pr-5"
                >
                    <span
                        v-for="index in 4"
                        :key="index"
                        class="flex items-center gap-1.5 text-[10px] font-black tracking-wide text-white uppercase"
                    >
                        <Megaphone class="size-3 shrink-0" />
                        {{ props.message }}
                        <Gift class="size-3 shrink-0" />
                        Mã: {{ props.couponCode }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Mã ưu đãi + gọi nhanh -->
        <div class="bg-white px-3 py-1.5">
            <div class="flex items-center gap-2">
                <span
                    class="flex min-w-0 flex-1 items-center gap-1.5 truncate rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-black text-emerald-800 uppercase"
                >
                    <Gift class="size-3 shrink-0" />
                    Mã: {{ props.couponCode }}
                </span>

                <a
                    :href="props.hotlineHref"
                    class="flex shrink-0 items-center gap-1 rounded-full bg-emerald-600 px-2.5 py-1 text-[10px] font-black text-white uppercase"
                    :aria-label="`Gọi ${props.hotline}`"
                >
                    <Phone class="size-3" />
                    {{ props.hotline }}
                </a>
            </div>
        </div>
    </div>
</template>
