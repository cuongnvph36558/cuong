<script setup lang="ts">
import { computed, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { store as storeLead } from '@/routes/leads';

type Props = {
    /** Heading shown above the fields. */
    title?: string;
    /** Sub-heading shown above the fields. */
    subtitle?: string;
    /** Pre-filled coupon code. */
    couponCode?: string;
    /** Collects the plant type select. */
    withPlantType?: boolean;
    /** Collects the symptom checkboxes. */
    withSymptoms?: boolean;
    /** Button label. */
    submitLabel?: string;
    /** Layout variant. */
    variant?: 'light' | 'dark';
    /** Plant type options offered in the select. */
    plantTypes?: string[];
    /** Symptom options offered as checkboxes. */
    symptoms?: string[];
};

const props = withDefaults(defineProps<Props>(), {
    title: 'Anh/Chị hãy điền thông tin để được chuyên gia tư vấn',
    subtitle: 'Kỹ sư nông nghiệp sẽ liên hệ trực tiếp tư vấn miễn phí.',
    couponCode: 'HT212',
    withPlantType: true,
    withSymptoms: true,
    submitLabel: 'ĐĂNG KÝ NGAY',
    variant: 'light',
    plantTypes: () => [
        'Cây ăn quả',
        'Cây cảnh',
        'Cây Bonsai',
        'Cây thân gỗ',
        'Cây rau, củ',
        'Cây hoa',
    ],
    symptoms: () => [
        'VÀNG LÁ',
        'THỐI RỂ',
        'CÂY CÒI CỌC',
        'CÂY SÂU BỆNH',
        'KHÔNG RA HOA',
        'CÂY HÉO ÚA',
    ],
});

const form = useForm({
    name: '',
    phone: '',
    address: '',
    coupon_code: props.couponCode,
    plant_type: '',
    symptoms: [] as string[],
    note: '',
});

const submitted = ref(false);

const isDark = computed(() => props.variant === 'dark');

function toggleSymptom(symptom: string): void {
    const index = form.symptoms.indexOf(symptom);

    if (index === -1) {
        form.symptoms.push(symptom);
        return;
    }

    form.symptoms.splice(index, 1);
}

function submit(): void {
    form.post(storeLead.url(), {
        preserveScroll: true,
        onSuccess: () => {
            submitted.value = true;
            form.reset();
            form.coupon_code = props.couponCode;
        },
    });
}
</script>

<template>
    <div
        class="rounded-3xl border p-6 shadow-2xl sm:p-8"
        :class="
            isDark
                ? 'border-white/15 bg-white/10 backdrop-blur-xl'
                : 'border-green-900/10 bg-white'
        "
    >
        <h3
            class="text-xl font-extrabold uppercase sm:text-2xl"
            :class="isDark ? 'text-white' : 'text-green-950'"
        >
            {{ props.title }}
        </h3>
        <p
            class="mt-2 text-sm"
            :class="isDark ? 'text-white/80' : 'text-slate-600'"
        >
            {{ props.subtitle }}
        </p>

        <div
            v-if="submitted"
            class="mt-6 rounded-2xl border border-emerald-500/40 bg-emerald-500/15 p-6 text-center"
        >
            <p class="text-lg font-bold text-emerald-700">
                Cảm ơn bác đã để lại thông tin!
            </p>
            <p class="mt-2 text-sm text-slate-600">
                Kỹ sư nông nghiệp sẽ liên hệ trực tiếp để tư vấn và báo giá cho
                mình ạ!
            </p>
        </div>

        <form v-else class="mt-6 space-y-4" @submit.prevent="submit">
            <div>
                <label class="mb-1 block text-sm font-semibold" for="lead-name">
                    Họ và tên
                </label>
                <Input
                    id="lead-name"
                    v-model="form.name"
                    name="name"
                    placeholder="Họ và tên"
                    autocomplete="name"
                />
                <p v-if="form.errors.name" class="mt-1 text-xs text-red-600">
                    {{ form.errors.name }}
                </p>
            </div>

            <div>
                <label
                    class="mb-1 block text-sm font-semibold"
                    for="lead-phone"
                >
                    Số điện thoại
                </label>
                <Input
                    id="lead-phone"
                    v-model="form.phone"
                    name="phone"
                    type="tel"
                    inputmode="tel"
                    placeholder="Số điện thoại"
                    autocomplete="tel"
                />
                <p v-if="form.errors.phone" class="mt-1 text-xs text-red-600">
                    {{ form.errors.phone }}
                </p>
            </div>

            <div>
                <label
                    class="mb-1 block text-sm font-semibold"
                    for="lead-address"
                >
                    Địa chỉ
                </label>
                <Input
                    id="lead-address"
                    v-model="form.address"
                    name="address"
                    placeholder="Địa chỉ"
                    autocomplete="street-address"
                />
            </div>

            <div v-if="props.withPlantType">
                <label
                    class="mb-1 block text-sm font-semibold"
                    for="lead-plant"
                >
                    Loại cây trồng
                </label>
                <select
                    id="lead-plant"
                    v-model="form.plant_type"
                    name="plant_type"
                    class="h-9 w-full rounded-md border bg-transparent px-3 text-sm outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    :class="
                        isDark
                            ? 'border-white/25 text-white'
                            : 'border-input text-slate-900'
                    "
                >
                    <option value="">Chọn loại cây</option>
                    <option
                        v-for="plant in props.plantTypes"
                        :key="plant"
                        :value="plant"
                    >
                        {{ plant }}
                    </option>
                </select>
            </div>

            <div v-if="props.withSymptoms">
                <span class="mb-2 block text-sm font-semibold">
                    Tình trạng cây hay gặp
                </span>
                <div class="flex flex-wrap gap-2">
                    <button
                        v-for="symptom in props.symptoms"
                        :key="symptom"
                        type="button"
                        class="rounded-full border px-3 py-1.5 text-xs font-bold uppercase transition-all"
                        :class="
                            form.symptoms.includes(symptom)
                                ? 'border-emerald-600 bg-emerald-600 text-white shadow-lg shadow-emerald-600/30'
                                : isDark
                                  ? 'border-white/25 text-white hover:border-white/60'
                                  : 'border-slate-300 text-slate-700 hover:border-emerald-600'
                        "
                        @click="toggleSymptom(symptom)"
                    >
                        {{ symptom }}
                    </button>
                </div>
                <p
                    v-if="form.errors.symptoms"
                    class="mt-1 text-xs text-red-600"
                >
                    {{ form.errors.symptoms }}
                </p>
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold" for="lead-note">
                    Ghi chú
                </label>
                <Textarea
                    id="lead-note"
                    v-model="form.note"
                    name="note"
                    rows="3"
                    placeholder="Mô tả thêm về vườn cây của bạn..."
                />
            </div>

            <div>
                <label
                    class="mb-1 block text-sm font-semibold"
                    for="lead-coupon"
                >
                    Mã giảm giá
                </label>
                <Input
                    id="lead-coupon"
                    v-model="form.coupon_code"
                    name="coupon_code"
                    placeholder="Mã giảm giá"
                />
            </div>

            <Button
                type="submit"
                size="lg"
                class="w-full bg-emerald-600 font-extrabold tracking-wide text-white uppercase shadow-lg shadow-emerald-600/30 hover:bg-emerald-700"
                :disabled="form.processing"
            >
                {{ form.processing ? 'Đang gửi...' : props.submitLabel }}
            </Button>

            <p
                class="text-center text-xs"
                :class="isDark ? 'text-white/60' : 'text-slate-500'"
            >
                Chúng tôi sẽ không chia sẻ thông tin của bạn cho bên thứ ba.
            </p>
        </form>
    </div>
</template>
