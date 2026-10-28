<script setup lang="ts">
import { ref } from 'vue';
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
        class="rounded-3xl border border-emerald-900/10 bg-white p-5 shadow-xl shadow-emerald-900/10 sm:p-8"
    >
        <h3
            class="text-lg font-extrabold text-emerald-950 uppercase sm:text-2xl"
        >
            {{ props.title }}
        </h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">
            {{ props.subtitle }}
        </p>

        <div
            v-if="submitted"
            class="mt-6 rounded-2xl border border-emerald-500/40 bg-emerald-50 p-6 text-center"
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
                <label class="mb-1.5 block text-sm font-semibold" for="lead-name">
                    Họ và tên
                </label>
                <Input
                    id="lead-name"
                    v-model="form.name"
                    name="name"
                    placeholder="Họ và tên"
                    autocomplete="name"
                    class="h-11 bg-white"
                />
                <p v-if="form.errors.name" class="mt-1 text-xs text-red-600">
                    {{ form.errors.name }}
                </p>
            </div>

            <div>
                <label
                    class="mb-1.5 block text-sm font-semibold"
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
                    class="h-11 bg-white"
                />
                <p v-if="form.errors.phone" class="mt-1 text-xs text-red-600">
                    {{ form.errors.phone }}
                </p>
            </div>

            <div>
                <label
                    class="mb-1.5 block text-sm font-semibold"
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
                    class="h-11 bg-white"
                />
            </div>

            <div v-if="props.withPlantType">
                <label
                    class="mb-1.5 block text-sm font-semibold"
                    for="lead-plant"
                >
                    Loại cây trồng
                </label>
                <select
                    id="lead-plant"
                    v-model="form.plant_type"
                    name="plant_type"
                    class="h-11 w-full rounded-md border border-input bg-white px-3 text-sm text-slate-900 outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
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
                        class="rounded-full border px-3 py-2 text-xs font-bold uppercase transition-all"
                        :class="
                            form.symptoms.includes(symptom)
                                ? 'border-emerald-600 bg-emerald-600 text-white shadow-lg shadow-emerald-600/25'
                                : 'border-slate-300 text-slate-700 hover:border-emerald-600 hover:bg-emerald-50'
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
                <label class="mb-1.5 block text-sm font-semibold" for="lead-note">
                    Ghi chú
                </label>
                <Textarea
                    id="lead-note"
                    v-model="form.note"
                    name="note"
                    rows="3"
                    placeholder="Mô tả thêm về vườn cây của bạn..."
                    class="bg-white"
                />
            </div>

            <div>
                <label
                    class="mb-1.5 block text-sm font-semibold"
                    for="lead-coupon"
                >
                    Mã giảm giá
                </label>
                <Input
                    id="lead-coupon"
                    v-model="form.coupon_code"
                    name="coupon_code"
                    placeholder="Mã giảm giá"
                    class="h-11 bg-white"
                />
            </div>

            <Button
                type="submit"
                size="lg"
                class="h-12 w-full bg-emerald-600 font-extrabold tracking-wide text-white uppercase shadow-lg shadow-emerald-600/25 hover:bg-emerald-700"
                :disabled="form.processing"
            >
                {{ form.processing ? 'Đang gửi...' : props.submitLabel }}
            </Button>

            <p class="text-center text-xs text-slate-500">
                Chúng tôi sẽ không chia sẻ thông tin của bạn cho bên thứ ba.
            </p>
        </form>
    </div>
</template>
