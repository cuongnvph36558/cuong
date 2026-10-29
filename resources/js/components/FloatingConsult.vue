<script setup lang="ts">
import { computed, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Check, MessageCircle, Phone, User, X } from '@lucide/vue';
import { store as storeLead } from '@/routes/leads';

type Props = {
    /** Hotline number shown on the call button. */
    hotline?: string;
    /** Hotline href. */
    hotlineHref?: string;
    /** Coupon code attached to the submission. */
    couponCode?: string;
    /** Number of people already registered. */
    peopleCount?: number;
};

const props = withDefaults(defineProps<Props>(), {
    hotline: '0973.42.6704',
    hotlineHref: 'tel:0973426704',
    couponCode: 'ELICPO10',
    peopleCount: 99,
});

const form = useForm({
    name: '',
    phone: '',
    coupon_code: props.couponCode,
    source: 'floating-consult',
});

const open = ref(false);
const submitted = ref(false);

const canSubmit = computed(
    () => form.name.trim().length > 0 && form.phone.trim().length > 0,
);

function submit(): void {
    if (!canSubmit.value) {
        return;
    }

    form.post(storeLead.url(), {
        preserveScroll: true,
        onSuccess: () => {
            submitted.value = true;
            form.reset();
            form.coupon_code = props.couponCode;
            form.source = 'floating-consult';
        },
    });
}
</script>

<template>
    <!-- Floating bubble, always visible while scrolling -->
    <div class="pointer-events-none fixed right-3 bottom-32 z-40 flex flex-col items-end gap-2">
        <!-- Expanded panel -->
        <div
            v-if="open"
            class="pointer-events-auto w-[min(20rem,calc(100vw-1.5rem))] overflow-hidden rounded-2xl border border-emerald-900/10 bg-white shadow-2xl shadow-emerald-900/25"
        >
            <div class="flex items-center justify-between bg-emerald-600 px-3 py-2">
                <p class="text-xs font-black text-white uppercase">
                    Tư vấn miễn phí
                </p>
                <button
                    type="button"
                    class="text-white/80 transition hover:text-white"
                    aria-label="Đóng"
                    @click="open = false"
                >
                    <X class="size-4" />
                </button>
            </div>

            <div v-if="submitted" class="p-4 text-center">
                <span
                    class="mx-auto flex size-9 items-center justify-center rounded-full bg-emerald-600 text-white"
                >
                    <Check class="size-5" />
                </span>
                <p class="mt-2 text-sm font-bold text-emerald-800">
                    Đã đăng ký! Chúng tôi sẽ gọi bạn.
                </p>
            </div>

            <form v-else class="space-y-2 p-3" @submit.prevent="submit">
                <div class="relative">
                    <User
                        class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"
                    />
                    <input
                        v-model="form.name"
                        name="name"
                        type="text"
                        placeholder="Họ và tên"
                        autocomplete="name"
                        aria-label="Họ và tên"
                        class="h-11 w-full rounded-xl border border-emerald-900/15 bg-white pr-3 pl-9 text-[15px] outline-none focus-visible:border-emerald-500 focus-visible:ring-[3px] focus-visible:ring-emerald-500/25"
                    />
                </div>

                <div class="relative">
                    <Phone
                        class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400"
                    />
                    <input
                        v-model="form.phone"
                        name="phone"
                        type="tel"
                        inputmode="tel"
                        placeholder="Số điện thoại"
                        autocomplete="tel"
                        aria-label="Số điện thoại"
                        class="h-11 w-full rounded-xl border border-emerald-900/15 bg-white pr-3 pl-9 text-[15px] outline-none focus-visible:border-emerald-500 focus-visible:ring-[3px] focus-visible:ring-emerald-500/25"
                    />
                </div>

                <button
                    type="submit"
                    class="elicpo-cta h-12 w-full rounded-xl bg-emerald-600 text-sm font-black text-white uppercase shadow-md shadow-emerald-600/30"
                    :disabled="form.processing || !canSubmit"
                >
                    {{ form.processing ? 'Đang gửi...' : 'Đăng ký tư vấn' }}
                </button>

                <p class="text-center text-[10px] text-slate-500">
                    {{ props.peopleCount }} người đã đăng ký · Miễn phí
                </p>
            </form>
        </div>

        <!-- Buttons -->
        <div class="pointer-events-auto flex flex-col gap-2">
            <a
                :href="props.hotlineHref"
                class="flex size-12 items-center justify-center rounded-full bg-emerald-600 text-white shadow-lg shadow-emerald-700/40 transition active:scale-95"
                :aria-label="`Gọi ${props.hotline}`"
            >
                <Phone class="size-5" />
            </a>

            <button
                type="button"
                class="flex size-12 items-center justify-center rounded-full bg-lime-400 text-emerald-950 shadow-lg shadow-lime-500/40 transition active:scale-95"
                aria-label="Đăng ký tư vấn"
                @click="open = !open"
            >
                <MessageCircle class="size-5" />
            </button>
        </div>
    </div>
</template>
