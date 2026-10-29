<script setup lang="ts">
import { computed, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Check, Phone, User } from '@lucide/vue';
import { store as storeLead } from '@/routes/leads';

type Props = {
    /** Label of the submit button. */
    submitLabel?: string;
    /** Tracking source stored with the submitted lead. */
    source?: string;
    /** Hotline number shown on the call button. */
    hotline?: string;
    /** Hotline href. */
    hotlineHref?: string;
};

const props = withDefaults(defineProps<Props>(), {
    submitLabel: 'Đăng ký tư vấn',
    source: 'floating-dock',
    hotline: '0973.42.6704',
    hotlineHref: 'tel:0973426704',
});

const form = useForm({
    name: '',
    phone: '',
    coupon_code: '',
    source: props.source,
});

const submitted = ref(false);
const expanded = ref(false);

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
            form.coupon_code = '';
            form.source = props.source;
        },
    });
}
</script>

<template>
    <!-- Floating dock: always on screen while scrolling -->
    <div
        class="fixed inset-x-0 bottom-0 z-50 border-t-2 border-emerald-600 bg-white/97 shadow-[0_-8px_28px_-10px_rgba(6,95,70,0.45)] backdrop-blur"
    >
        <!-- Success state -->
        <div
            v-if="submitted"
            class="flex items-center justify-center gap-2 px-3 py-4 text-sm font-black text-emerald-700"
        >
            <span class="flex size-6 items-center justify-center rounded-full bg-emerald-600 text-white">
                <Check class="size-4" />
            </span>
            Đã đăng ký! Chúng tôi sẽ gọi bạn.
        </div>

        <!-- Compact row: call + register -->
        <div v-else>
            <!-- Expanded form -->
            <form
                v-if="expanded"
                class="space-y-2 border-b border-emerald-900/10 bg-emerald-50/60 px-3 pt-3 pb-2"
                @submit.prevent="submit"
            >
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
                        class="h-12 w-full rounded-xl border border-emerald-900/15 bg-white pr-3 pl-9 text-base outline-none focus-visible:border-emerald-500 focus-visible:ring-[3px] focus-visible:ring-emerald-500/25"
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
                        class="h-12 w-full rounded-xl border border-emerald-900/15 bg-white pr-3 pl-9 text-base outline-none focus-visible:border-emerald-500 focus-visible:ring-[3px] focus-visible:ring-emerald-500/25"
                    />
                </div>

                <button
                    type="submit"
                    class="elicpo-cta h-12 w-full rounded-xl bg-emerald-600 text-sm font-black text-white uppercase shadow-md shadow-emerald-600/30"
                    :disabled="form.processing || !canSubmit"
                >
                    {{ form.processing ? 'Đang gửi...' : props.submitLabel }}
                </button>

                <p class="text-center text-[10px] text-slate-500">
                    Miễn phí · Kỹ sư gọi trong 15 phút
                </p>
            </form>

            <!-- Action bar -->
            <div
                class="flex items-center gap-2 px-3 pt-2 pb-[calc(env(safe-area-inset-bottom)+0.5rem)]"
            >
                <a
                    :href="props.hotlineHref"
                    class="flex size-12 shrink-0 items-center justify-center rounded-xl border-2 border-emerald-700 text-emerald-700 transition active:bg-emerald-700 active:text-white"
                    :aria-label="`Gọi ${props.hotline}`"
                >
                    <Phone class="size-5" />
                </a>

                <button
                    type="button"
                    class="elicpo-cta elicpo-cta-ring h-12 flex-1 rounded-xl bg-emerald-600 text-sm font-black text-white uppercase shadow-md shadow-emerald-600/30"
                    @click="expanded = !expanded"
                >
                    {{ expanded ? 'Ẩn form' : props.submitLabel }}
                </button>
            </div>
        </div>
    </div>
</template>
