<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { Gift, Phone, Sparkles } from '@lucide/vue';

type Props = {
    /** Coupon code shown inside the floating panel. */
    couponCode?: string;
    /** Label of the floating registration button. */
    registerLabel?: string;
    /** Anchor the button scrolls to. */
    registerHref?: string;
    /** Hotline number used for the call button. */
    hotline?: string;
    /** Hotline href. */
    hotlineHref?: string;
    /** Number of people already registered. */
    peopleCount?: number;
};

const props = withDefaults(defineProps<Props>(), {
    couponCode: 'HT212',
    registerLabel: 'Đăng ký nhận ưu đãi',
    registerHref: '#dang-ky',
    hotline: '0973.42.6704',
    hotlineHref: 'tel:0973426704',
    peopleCount: 99,
});

const remaining = ref(15 * 60);
let timer: ReturnType<typeof setInterval> | undefined;

const minutes = computed(() =>
    String(Math.floor(remaining.value / 60)).padStart(2, '0'),
);
const seconds = computed(() => String(remaining.value % 60).padStart(2, '0'));

onMounted(() => {
    timer = setInterval(() => {
        remaining.value = remaining.value > 0 ? remaining.value - 1 : 15 * 60;
    }, 1000);
});

onUnmounted(() => clearInterval(timer));
</script>

<template>
    <!-- Desktop: floating rail on the right -->
    <aside
        class="pointer-events-none fixed right-4 bottom-24 z-50 hidden w-64 flex-col gap-2 lg:flex"
    >
        <div
            class="pointer-events-auto overflow-hidden rounded-3xl border border-emerald-700/20 bg-white/95 p-4 shadow-2xl shadow-emerald-900/20 backdrop-blur"
        >
            <p
                class="flex items-center justify-center gap-1.5 text-[11px] font-black tracking-wide text-emerald-700 uppercase"
            >
                <Gift class="size-3.5" />
                Mã ưu đãi
            </p>
            <p
                class="rootbio-pulse mt-1 text-center text-2xl font-black tracking-[0.2em] text-emerald-800"
            >
                {{ props.couponCode }}
            </p>

            <p
                class="mt-2 flex items-center justify-center gap-1.5 text-[11px] font-bold text-amber-600 uppercase"
            >
                <Sparkles class="size-3.5" />
                Còn
                <span class="tabular-nums">{{ minutes }}:{{ seconds }}</span>
            </p>

            <p class="mt-2 text-center text-[11px] font-semibold text-slate-500">
                <strong class="text-emerald-700">{{ props.peopleCount }}</strong>
                người đã đăng ký
            </p>

            <a
                :href="props.registerHref"
                class="rootbio-cta rootbio-cta-ring rootbio-cta-shake mt-3 block rounded-full bg-emerald-600 py-4 text-center text-base font-black text-white uppercase shadow-lg shadow-emerald-600/30"
            >
                {{ props.registerLabel }}
            </a>

            <a
                :href="props.hotlineHref"
                class="mt-2 flex items-center justify-center gap-1.5 rounded-full border-2 border-emerald-700 py-2.5 text-center text-xs font-black text-emerald-800 uppercase transition hover:bg-emerald-700 hover:text-white"
            >
                <Phone class="size-3.5" />
                {{ props.hotline }}
            </a>
        </div>
    </aside>

    <!-- Mobile: sticky bottom bar -->
    <div
        class="fixed inset-x-0 bottom-0 z-50 border-t border-emerald-900/15 bg-white/95 px-3 pt-2 pb-[calc(env(safe-area-inset-bottom)+0.5rem)] backdrop-blur lg:hidden"
    >
        <div class="flex items-center gap-2">
            <div class="shrink-0 text-center leading-none">
                <p class="text-[9px] font-black tracking-wide text-emerald-700 uppercase">
                    Mã
                </p>
                <p class="text-sm font-black text-emerald-800">
                    {{ props.couponCode }}
                </p>
            </div>

            <a
                :href="props.hotlineHref"
                class="flex size-11 shrink-0 items-center justify-center rounded-full border-2 border-emerald-700 text-emerald-700"
                :aria-label="`Gọi ${props.hotline}`"
            >
                <Phone class="size-4" />
            </a>

            <a
                :href="props.registerHref"
                class="rootbio-cta rootbio-cta-ring rootbio-cta-shake flex-1 rounded-full bg-emerald-600 py-4 text-center text-sm font-black text-white uppercase shadow-md shadow-emerald-600/30"
            >
                {{ props.registerLabel }}
            </a>
        </div>
    </div>
</template>
