<script setup lang="ts">
import { computed, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Phone, User } from '@lucide/vue';
import { store as storeLead } from '@/routes/leads';

type Props = {
    /** Heading shown above the fields. */
    title?: string;
    /** Sub-heading shown above the fields. */
    subtitle?: string;
    /** Pre-filled coupon code. */
    couponCode?: string;
    /** Button label. */
    submitLabel?: string;
    /** Tracking source stored with the submitted lead. */
    source?: string;
};

const props = withDefaults(defineProps<Props>(), {
    title: 'Nhập tên và số điện thoại để được tư vấn',
    subtitle: 'Chỉ 10 giây để đăng ký. Chuyên gia nông nghiệp sẽ gọi cho bạn.',
    couponCode: 'ELICPO10',
    submitLabel: 'NHẬN TƯ VẤN NGAY',
    source: 'landing',
});

const form = useForm({
    name: '',
    phone: '',
    coupon_code: props.couponCode,
    source: props.source,
});

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
            form.source = props.source;
        },
    });
}
</script>

<template>
    <div
        class="relative overflow-hidden rounded-3xl border border-emerald-900/10 bg-white p-5 shadow-2xl shadow-emerald-900/15 sm:p-6"
    >
        <!-- Decorative glow + header band -->
        <div
            class="pointer-events-none absolute -top-20 -right-16 size-56 rounded-full bg-emerald-300/25 blur-3xl"
        ></div>
        <div
            class="pointer-events-none absolute -bottom-24 -left-16 size-56 rounded-full bg-lime-300/25 blur-3xl"
        ></div>

        <div class="relative">
            <div
                class="absolute inset-x-0 top-0 -z-10 h-1 rounded-t-3xl bg-gradient-to-r from-emerald-500 via-lime-400 to-emerald-500"
            ></div>

            <h3 class="text-lg font-extrabold text-emerald-950 uppercase">
                {{ props.title }}
            </h3>
            <p class="mt-1 text-sm leading-relaxed text-slate-600">
                {{ props.subtitle }}
            </p>

            <div
                v-if="submitted"
                class="mt-5 rounded-2xl border border-emerald-500/40 bg-emerald-50 p-5 text-center"
            >
                <p class="text-base font-bold text-emerald-700">
                    Cảm ơn bạn đã đăng ký!
                </p>
                <p class="mt-2 text-sm text-slate-600">
                    Chuyên gia nông nghiệp sẽ gọi cho bạn trong thời gian sớm nhất.
                    Vui lòng chú ý điện thoại.
                </p>
            </div>

            <form v-else class="mt-5 space-y-3" @submit.prevent="submit">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold" for="lead-name">
                        Họ và tên
                    </label>
                    <div class="group relative">
                        <User
                            class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400 transition group-focus-within:text-emerald-600"
                        />
                        <input
                            id="lead-name"
                            v-model="form.name"
                            name="name"
                            type="text"
                            placeholder="Nguyễn Văn A"
                            autocomplete="name"
                            class="h-12 w-full rounded-xl border border-input bg-white pr-3 pl-9 text-base outline-none transition focus-visible:border-emerald-500 focus-visible:ring-[3px] focus-visible:ring-emerald-500/25"
                        />
                    </div>
                    <p v-if="form.errors.name" class="mt-1 text-xs text-red-600">
                        {{ form.errors.name }}
                    </p>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold" for="lead-phone">
                        Số điện thoại
                    </label>
                    <div class="group relative">
                        <Phone
                            class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400 transition group-focus-within:text-emerald-600"
                        />
                        <input
                            id="lead-phone"
                            v-model="form.phone"
                            name="phone"
                            type="tel"
                            inputmode="tel"
                            placeholder="0973 42 6704"
                            autocomplete="tel"
                            class="h-12 w-full rounded-xl border border-input bg-white pr-3 pl-9 text-base outline-none transition focus-visible:border-emerald-500 focus-visible:ring-[3px] focus-visible:ring-emerald-500/25"
                        />
                    </div>
                    <p v-if="form.errors.phone" class="mt-1 text-xs text-red-600">
                        {{ form.errors.phone }}
                    </p>
                </div>

                <button
                    type="submit"
                    class="elicpo-cta elicpo-cta-ring w-full rounded-full bg-emerald-600 py-4 text-base font-black text-white uppercase shadow-lg shadow-emerald-600/25"
                    :disabled="form.processing || !canSubmit"
                >
                    {{ form.processing ? 'Đang gửi...' : props.submitLabel }}
                </button>

                <p class="text-center text-[11px] text-slate-500">
                    Chúng tôi sẽ không chia sẻ thông tin của bạn cho bên thứ ba.
                </p>
            </form>
        </div>
    </div>
</template>
