<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Phone, Sparkles, Star } from '@lucide/vue';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import FloatingConsult from '@/components/FloatingConsult.vue';
import FloatingLeadDock from '@/components/FloatingLeadDock.vue';
import ImageGallery, { type GalleryItem } from '@/components/ImageGallery.vue';
import OrderForm from '@/components/OrderForm.vue';
import PromoBar from '@/components/PromoBar.vue';
import RegistrationNotifier from '@/components/RegistrationNotifier.vue';
import { useScrollReveal } from '@/composables/useScrollReveal';
import type { Feedback } from '@/types/feedback';
import type { HomeContent, HomeContentImageItem } from '@/types/homeContent';

useScrollReveal();

type Props = {
    content: HomeContent;
    feedbacks: Feedback[];
};

const props = defineProps<Props>();

type ImageItem = HomeContentImageItem;

function section(key: string): Record<string, unknown> {
    return (props.content[key] ?? {}) as Record<string, unknown>;
}

function text(key: string, field: string, fallback = ''): string {
    const value = section(key)[field];

    return typeof value === 'string' ? value : fallback;
}

function number(key: string, field: string, fallback = 0): number {
    const value = section(key)[field];

    return typeof value === 'number' ? value : fallback;
}

function list(key: string, field: string): ImageItem[] {
    const value = section(key)[field];

    return Array.isArray(value) ? (value as ImageItem[]) : [];
}

const seo = computed(() => ({
    title: text('seo', 'title', 'Phân Bón ELICPO'),
    description: text('seo', 'description'),
}));

const highlights = computed(() => list('highlights', 'items'));
const problems = computed(() => list('problems', 'items'));
const testimonials = computed(() => list('testimonials', 'items'));
const benefits = computed(() => list('benefits', 'items'));
const combos = computed(() => list('combos', 'items'));
const ctaBenefits = computed(() => list('cta', 'benefits'));
const plantTypes = computed(() => list('plantTypes', 'items'));
const reviews = computed(() => list('reviews', 'items'));
const ingredients = computed(() => list('ingredients', 'items'));

const galleryItems = computed<GalleryItem[]>(() => {
    const items = list('gallery', 'items')
        .filter((item) => typeof item.image === 'string' && item.image !== '')
        .map((item) => ({
            src: String(item.image),
            title: item.title ?? '',
            description: item.description ?? '',
        }));

    if (items.length > 0) {
        return items;
    }

    return [];
});

const plantCards = computed(() =>
    plantTypes.value.map((plant) => ({
        name: plant.value ?? '',
        image: plant.image ?? '/images/elicpo/effect1.png',
    })),
);

const remaining = ref(15 * 60);
let timer: ReturnType<typeof setInterval> | undefined;

const countdown = computed(() => {
    const hours = Math.floor(remaining.value / 3600);
    const minutes = String(Math.floor((remaining.value % 3600) / 60)).padStart(
        2,
        '0',
    );
    const seconds = String(remaining.value % 60).padStart(2, '0');

    return `${String(hours).padStart(2, '0')}:${minutes}:${seconds}`;
});

onMounted(() => {
    timer = setInterval(() => {
        remaining.value = remaining.value > 0 ? remaining.value - 1 : 15 * 60;
    }, 1000);
});

onUnmounted(() => clearInterval(timer));
</script>

<template>
    <Head :title="seo.title">
        <meta name="description" :content="seo.description" />
    </Head>

    <div class="elicpo-page flex min-h-screen flex-col bg-white text-slate-800">
        <!-- ===== THANH ƯU ĐÃI (cố định trên cùng) ===== -->
        <PromoBar
            :message="text('hero', 'badgeText')"
            :coupon-code="text('finalCta', 'couponCode', 'ELICPO10')"
            :hotline="text('hero', 'navPhone', '0973.42.6704')"
            :hotline-href="`tel:${text('hero', 'navPhone').replace(/\D/g, '')}`"
        />

        <!-- ===== HERO: ẢNH LÀ CHÍNH ===== -->
        <header class="relative overflow-hidden bg-emerald-50/60">
            <div class="elicpo-aurora absolute inset-0 opacity-70"></div>
            <div class="elicpo-grid-pattern absolute inset-0 opacity-50"></div>

            <div
                class="elicpo-blob elicpo-blob-emerald elicpo-blob-a -top-20 -left-16 size-72"
            ></div>
            <div
                class="elicpo-blob elicpo-blob-lime elicpo-blob-b top-0 right-0 size-80"
            ></div>

            <span class="elicpo-sparkle top-16 left-[10%]"></span>
            <span class="elicpo-sparkle top-8 right-[16%] [animation-delay:1.2s]"></span>

            <div class="relative px-3 pt-4 pb-6">
                <!-- Thương hiệu -->
                <div class="flex items-center gap-2">
                    <div
                        class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-600 to-lime-500 text-xs font-black text-white"
                    >
                        {{ text('hero', 'brandLetter', 'E') }}
                    </div>
                    <p class="text-sm font-black text-emerald-950 uppercase">
                        {{ text('hero', 'brandName', 'ELICPO') }}
                    </p>
                </div>

                <!-- Ảnh sản phẩm lớn, nổi bật -->
                <div class="relative mt-3" data-reveal>
                    <div
                        class="pointer-events-none absolute inset-0 flex items-center justify-center"
                    >
                        <div class="elicpo-ring size-56"></div>
                        <div class="elicpo-ring size-56 [animation-delay:1.1s]"></div>
                        <div class="elicpo-ring size-56 [animation-delay:2.2s]"></div>
                    </div>

                    <div
                        class="relative aspect-square overflow-hidden rounded-3xl border-2 border-white/70 bg-white shadow-2xl shadow-emerald-900/20"
                    >
                        <img
                            :src="text('hero', 'productImage')"
                            alt="Phân bón ELICPO"
                            class="elicpo-kenburns size-full object-cover"
                            fetchpriority="high"
                        />
                        <div
                            class="pointer-events-none absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-emerald-950/55 to-transparent"
                        ></div>
                        <div
                            class="absolute right-2 bottom-2 left-2 rounded-xl bg-white/95 p-2 shadow-lg backdrop-blur"
                        >
                            <p class="text-[11px] font-black text-emerald-700 uppercase">
                                {{ text('hero', 'productBadgeTitle') }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="elicpo-float-slow absolute -top-3 -left-2 rounded-xl bg-lime-400 px-2.5 py-1.5 shadow-lg shadow-lime-500/40"
                    >
                        <p class="text-base font-black text-emerald-950">
                            {{ text('hero', 'floatingBadgeValue', '3X') }}
                        </p>
                    </div>
                </div>

                <!-- Tiêu đề + ưu đãi -->
                <div class="mt-4" data-reveal>
                    <p
                        class="inline-flex items-center gap-1.5 rounded-full bg-emerald-600 px-3 py-1 text-[10px] font-black tracking-wide text-white uppercase"
                    >
                        <Sparkles class="size-3" />
                        Nhận ưu đãi
                    </p>

                    <h1
                        class="mt-2 text-[1.75rem] leading-[1.08] font-black tracking-tight text-emerald-950 uppercase"
                    >
                        {{ text('hero', 'titlePrefix', 'PHÂN BÓN') }}
                        <span class="elicpo-gradient-text">
                            {{ text('hero', 'titleAccent', 'ELICPO') }}
                        </span>
                    </h1>

                    <!-- Ưu đãi: số to, ít chữ -->
                    <div class="mt-3 flex items-end gap-2">
                        <p class="text-4xl font-black leading-none text-emerald-700">
                            {{ text('flashSale', 'effectivenessMultiplier', 'X100 LẦN') }}
                        </p>
                        <p class="pb-1 text-[11px] leading-tight font-black text-emerald-900 uppercase">
                            {{ text('flashSale', 'effectivenessDays', 'Cam kết hiệu quả sau 5 - 7 ngày') }}
                        </p>
                    </div>

                    <p
                        class="mt-2 inline-flex items-center gap-1.5 rounded-full bg-amber-400 px-3 py-1 text-[10px] font-black text-amber-950 uppercase"
                    >
                        {{ text('flashSale', 'countdownLabel', 'Đang có chương trình dùng thử') }}
                        <span class="elicpo-pulse tabular-nums">{{ countdown }}</span>
                    </p>
                </div>

                <!-- 3 công dụng: ảnh dọc, chữ overlay -->
                <div class="mt-4 grid grid-cols-3 gap-2">
                    <a
                        v-for="(benefit, index) in benefits"
                        :key="benefit.title"
                        href="#cong-dung"
                        class="group relative overflow-hidden rounded-2xl border-2 border-white bg-white shadow-lg shadow-emerald-900/10"
                        :class="
                            index === 1
                                ? 'elicpo-float'
                                : index === 2
                                  ? 'elicpo-float-delay'
                                  : ''
                        "
                    >
                        <img
                            :src="benefit.image"
                            :alt="benefit.title"
                            class="elicpo-zoom aspect-[3/4] w-full object-cover"
                            loading="lazy"
                        />
                        <span
                            class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-emerald-950/90 to-transparent p-1.5 pt-5 text-center text-[9px] leading-tight font-black text-white uppercase"
                        >
                            {{ benefit.title }}
                        </span>
                    </a>
                </div>

                <!-- CTA -->
                <div class="mt-4 flex items-center gap-2">
                    <a
                        href="#dat-hang"
                        class="elicpo-cta h-13 flex-1 rounded-xl bg-emerald-600 py-4 text-center text-sm font-black text-white uppercase shadow-lg shadow-emerald-600/30"
                    >
                        Đăng ký tư vấn
                    </a>
                    <a
                        :href="`tel:${text('hero', 'navPhone').replace(/\D/g, '')}`"
                        class="flex size-13 shrink-0 items-center justify-center rounded-xl border-2 border-emerald-700 bg-white/80 text-emerald-700 backdrop-blur"
                        :aria-label="`Gọi ${text('hero', 'navPhone')}`"
                    >
                        <Phone class="size-5" />
                    </a>
                </div>
            </div>
        </header>

        <!-- ===== ĐẶC TÍNH (ẢNH LÀ CHÍNH) ===== -->
        <section class="bg-white py-5">
            <div class="grid grid-cols-3 gap-2 px-3">
                <div
                    v-for="item in highlights"
                    :key="item.title"
                    data-reveal
                    class="group relative overflow-hidden rounded-xl border border-emerald-900/10 bg-white shadow-sm"
                >
                    <img
                        :src="item.image"
                        :alt="item.value ?? item.title"
                        class="elicpo-zoom aspect-square w-full object-cover"
                        loading="lazy"
                    />
                    <span
                        class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-emerald-950/90 to-transparent p-1 pt-4 text-center text-[8px] leading-tight font-black text-white uppercase"
                    >
                        {{ item.value ?? item.title }}
                    </span>
                </div>
            </div>
        </section>

        <!-- ===== LOẠI CÂY ===== -->
        <section class="bg-emerald-50/70 py-5">
            <h2
                data-reveal
                class="px-3 text-center text-base font-black tracking-tight text-emerald-950 uppercase"
            >
                Dùng cho mọi loại cây
            </h2>

            <div class="mt-3 grid grid-cols-3 gap-2 px-3">
                <figure
                    v-for="plant in plantCards"
                    :key="plant.name"
                    data-reveal
                    class="group overflow-hidden rounded-xl border border-emerald-900/10 bg-white shadow-sm"
                >
                    <img
                        :src="plant.image"
                        :alt="plant.name"
                        class="elicpo-zoom aspect-square w-full object-cover"
                        loading="lazy"
                    />
                    <figcaption
                        class="px-1 py-1.5 text-center text-[9px] font-black text-emerald-900 uppercase"
                    >
                        {{ plant.name }}
                    </figcaption>
                </figure>
            </div>
        </section>

        <!-- ===== VẤN ĐỀ → KẾT QUẢ ===== -->
        <section id="cong-dung" class="bg-white py-5">
            <h2
                data-reveal
                class="px-3 text-center text-base font-black tracking-tight text-emerald-950 uppercase"
            >
                {{ text('problems', 'heading', 'Bà con đau đầu về điều gì?') }}
            </h2>

            <!-- Cảnh báo -->
            <div
                data-reveal
                class="mx-3 mt-3 overflow-hidden rounded-xl border-2 border-amber-400 bg-amber-50"
            >
                <p
                    class="bg-amber-400 py-1.5 text-center text-[11px] font-black text-amber-950 uppercase"
                >
                    {{ text('problems', 'warningTitle', 'CẢNH BÁO!') }}
                </p>
                <p
                    class="px-3 py-2 text-[11px] leading-relaxed text-amber-900"
                >
                    {{ text('problems', 'warningText') }}
                </p>
            </div>

            <!-- Cặp ảnh trước / sau -->
            <div class="mt-3 space-y-2.5 px-3">
                <article
                    v-for="problem in problems"
                    :key="problem.title"
                    data-reveal
                    class="elicpo-lift overflow-hidden rounded-2xl border border-emerald-900/10 bg-white shadow-sm"
                >
                    <div class="grid grid-cols-2 gap-0.5 bg-emerald-900/5">
                        <figure class="relative overflow-hidden">
                            <img
                                :src="problem.image"
                                :alt="problem.title"
                                class="aspect-square w-full object-cover"
                                loading="lazy"
                            />
                            <figcaption
                                class="absolute inset-x-0 bottom-0 bg-emerald-950/85 px-1 py-1 text-center text-[8px] font-black text-white uppercase"
                            >
                                {{ problem.title }}
                            </figcaption>
                        </figure>

                        <figure class="relative overflow-hidden">
                            <img
                                :src="problem.resultImage"
                                :alt="problem.result"
                                class="aspect-square w-full object-cover"
                                loading="lazy"
                            />
                            <figcaption
                                class="absolute inset-x-0 bottom-0 bg-emerald-600/90 px-1 py-1 text-center text-[8px] font-black text-white uppercase"
                            >
                                {{ problem.result }}
                            </figcaption>
                        </figure>
                    </div>
                </article>
            </div>

            <!-- Triệu chứng -->
            <div
                data-reveal
                class="mt-3 flex flex-wrap justify-center gap-1.5 px-3"
            >
                <span
                    v-for="tag in [
                        'Cây còi cọc',
                        'Cây vàng lá',
                        'Cây thối rễ',
                        'Đất bạc màu',
                        'Mất mùa',
                    ]"
                    :key="tag"
                    class="rounded-full border-2 border-amber-300 bg-amber-50 px-3 py-1.5 text-[10px] font-black text-amber-700 uppercase"
                >
                    {{ tag }}
                </span>
            </div>
        </section>

        <!-- ===== CHỈ 2 LẦN PHUN ===== -->
        <section class="bg-emerald-50/70 py-5">
            <div class="px-3 text-center">
                <p
                    data-reveal
                    class="inline-flex items-center gap-1.5 rounded-full bg-emerald-600 px-3 py-1.5 text-[10px] font-black tracking-wide text-white uppercase"
                >
                    <Sparkles class="size-3" />
                    {{ text('problems', 'solutionTitle', 'Chỉ 2 lần phun') }}
                </p>
            </div>

            <div class="mt-3 grid grid-cols-2 gap-2 px-3">
                <div
                    v-for="item in [
                        {
                            image: '/images/elicpo/effect1.png',
                            title: 'Hết vàng lá, thối rễ',
                        },
                        {
                            image: '/images/elicpo/feature1.png',
                            title: 'Kích rễ nhanh',
                        },
                        {
                            image: '/images/elicpo/effect3.png',
                            title: 'Đậu quả tới 93%',
                        },
                        {
                            image: '/images/elicpo/tech.png',
                            title: 'Tăng 30% năng suất',
                        },
                    ]"
                    :key="item.title"
                    data-reveal
                    class="elicpo-lift group overflow-hidden rounded-xl border border-emerald-900/10 bg-white shadow-sm"
                >
                    <img
                        :src="item.image"
                        :alt="item.title"
                        class="elicpo-zoom aspect-square w-full object-cover"
                        loading="lazy"
                    />
                    <p
                        class="px-2 py-1.5 text-center text-[9px] leading-tight font-black text-emerald-900 uppercase"
                    >
                        {{ item.title }}
                    </p>
                </div>
            </div>

            <p
                data-reveal
                class="mt-3 px-3 text-center text-[11px] font-black tracking-wide text-emerald-700 uppercase"
            >
                {{ text('flashSale', 'totalUsers') }}
            </p>
        </section>

        <!-- ===== ẢNH THỰC TẾ ===== -->
        <section class="bg-white py-5">
            <ImageGallery
                :items="galleryItems"
                :heading="text('gallery', 'heading', 'Hình ảnh thực tế')"
                :description="''"
            />
        </section>

        <!-- ===== COMBO ===== -->
        <section class="bg-emerald-50/70 py-5">
            <h2
                data-reveal
                class="px-3 text-center text-base font-black tracking-tight text-emerald-950 uppercase"
            >
                {{ text('combos', 'heading', 'Combo ưu đãi') }}
            </h2>

            <div class="mt-3 grid grid-cols-2 gap-2 px-3">
                <article
                    v-for="(combo, index) in combos"
                    :key="combo.name"
                    data-reveal
                    class="elicpo-lift group overflow-hidden rounded-xl border border-emerald-900/10 bg-white shadow-sm"
                >
                    <div class="relative overflow-hidden">
                        <img
                            :src="
                                index % 2 === 0
                                    ? '/images/elicpo/product.png'
                                    : '/images/elicpo/banner.png'
                            "
                            :alt="combo.name"
                            class="elicpo-zoom aspect-[4/3] w-full object-cover"
                            loading="lazy"
                        />
                        <span
                            v-if="combo.badge"
                            class="elicpo-shimmer absolute top-1.5 left-1.5 rounded-full bg-lime-400 px-1.5 py-0.5 text-[8px] font-black text-emerald-950 uppercase"
                        >
                            {{ combo.badge }}
                        </span>
                    </div>
                    <div class="p-2">
                        <h3 class="text-[10px] font-black text-emerald-900 uppercase">
                            {{ combo.name }}
                        </h3>
                        <p class="mt-0.5 text-[9px] leading-relaxed text-slate-600">
                            {{ combo.gift }}
                        </p>
                    </div>
                </article>
            </div>
        </section>

        <!-- ===== CẢM NHẬN ===== -->
        <section class="bg-white py-5">
            <div class="flex items-center justify-center gap-1 px-3 text-amber-500">
                <Star v-for="star in 5" :key="star" class="size-4 fill-current" />
            </div>
            <p class="mt-1 px-3 text-center text-base font-black text-emerald-950 uppercase">
                {{ number('reviews', 'averageRating', 5) }} ·
                {{ text('reviews', 'totalReviews') }}
            </p>

            <div class="mt-3 space-y-2.5 px-3">
                <figure
                    v-for="testimonial in testimonials"
                    :key="testimonial.author"
                    data-reveal
                    class="elicpo-lift group overflow-hidden rounded-2xl border border-emerald-900/10 bg-white shadow-sm"
                >
                    <img
                        :src="testimonial.image"
                        :alt="testimonial.author"
                        class="elicpo-zoom aspect-[4/3] w-full object-cover"
                        loading="lazy"
                    />
                    <figcaption class="p-2.5">
                        <p
                            class="line-clamp-3 text-[11px] leading-relaxed text-slate-700 italic"
                        >
                            "{{ testimonial.quote }}"
                        </p>
                        <p
                            class="mt-1.5 border-t border-slate-100 pt-1.5 text-[10px] font-black text-emerald-900 uppercase"
                        >
                            {{ testimonial.author }}
                        </p>
                    </figcaption>
                </figure>
            </div>
        </section>

        <!-- ===== CÔNG DỤNG NỔI BẬT ===== -->
        <section class="bg-emerald-50/70 py-5">
            <div class="grid grid-cols-2 gap-2 px-3">
                <article
                    v-for="benefit in [
                        {
                            image: '/images/elicpo/feature1.png',
                            title: 'Siêu kích rễ',
                        },
                        {
                            image: '/images/elicpo/effect2.png',
                            title: 'Kích thích bung đọt',
                        },
                        {
                            image: '/images/elicpo/effect3.png',
                            title: 'Nuôi hoa trái tốt',
                        },
                        {
                            image: '/images/elicpo/tech.png',
                            title: 'Tiết kiệm chi phí',
                        },
                    ]"
                    :key="benefit.title"
                    data-reveal
                    class="elicpo-lift group overflow-hidden rounded-xl border border-emerald-900/10 bg-white shadow-sm"
                >
                    <img
                        :src="benefit.image"
                        :alt="benefit.title"
                        class="elicpo-zoom aspect-[4/3] w-full object-cover"
                        loading="lazy"
                    />
                    <p class="px-2 py-1.5 text-center text-[10px] font-black text-emerald-900 uppercase">
                        {{ benefit.title }}
                    </p>
                </article>
            </div>
        </section>

        <!-- ===== THÀNH PHẦN ===== -->
        <section class="bg-white py-5">
            <h2
                data-reveal
                class="px-3 text-center text-base font-black tracking-tight text-emerald-950 uppercase"
            >
                Thành phần & công nghệ
            </h2>

            <div class="mt-3 grid grid-cols-2 gap-2 px-3">
                <article
                    v-for="ingredient in ingredients"
                    :key="ingredient.title"
                    data-reveal
                    class="elicpo-lift group overflow-hidden rounded-xl border border-emerald-900/10 bg-white text-center shadow-sm"
                >
                    <img
                        :src="ingredient.image"
                        :alt="ingredient.title"
                        class="elicpo-zoom aspect-square w-full object-cover"
                        loading="lazy"
                    />
                    <div class="p-2">
                        <h3 class="text-[10px] font-black text-emerald-900 uppercase">
                            {{ ingredient.title }}
                        </h3>
                        <p
                            class="mt-0.5 line-clamp-2 text-[9px] leading-relaxed text-slate-600"
                        >
                            {{ ingredient.description }}
                        </p>
                    </div>
                </article>
            </div>

            <p
                data-reveal
                class="mt-3 px-3 text-center text-xs font-black tracking-[0.15em] text-emerald-700 uppercase"
            >
                {{ text('ingredients', 'footerText', 'Hiệu quả gấp 10 lần') }}
            </p>
        </section>

        <!-- ===== CHỨNG NHẬN ===== -->
        <section class="bg-emerald-50/70 py-5">
            <div class="grid grid-cols-2 gap-2 px-3">
                <figure
                    data-reveal
                    class="elicpo-lift overflow-hidden rounded-xl border border-emerald-900/10 bg-white shadow-sm"
                >
                    <img
                        src="/images/elicpo/japan.webp"
                        alt="Nguồn gốc Nhật Bản"
                        class="elicpo-zoom aspect-square w-full object-cover"
                        loading="lazy"
                    />
                    <figcaption class="p-2 text-center text-[9px] font-black text-emerald-900 uppercase">
                        Người Nhật đánh giá cao
                    </figcaption>
                </figure>

                <figure
                    data-reveal
                    class="elicpo-lift overflow-hidden rounded-xl border border-emerald-900/10 bg-white shadow-sm"
                >
                    <img
                        src="/images/elicpo/certs.png"
                        alt="Chứng nhận chất lượng"
                        class="elicpo-zoom aspect-square w-full object-cover"
                        loading="lazy"
                    />
                    <figcaption class="p-2 text-center text-[9px] font-black text-emerald-900 uppercase">
                        Chứng nhận chất lượng
                    </figcaption>
                </figure>
            </div>
        </section>

        <!-- ===== ĐĂNG KÝ TƯ VẤN (đầy đủ) ===== -->
        <section
            id="dat-hang"
            class="relative overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-lime-50 py-6"
        >
            <div
                class="elicpo-blob elicpo-blob-emerald elicpo-blob-a -top-16 -left-16 size-72 opacity-40"
            ></div>
            <div
                class="elicpo-blob elicpo-blob-lime elicpo-blob-c -right-12 bottom-0 size-72 opacity-40"
            ></div>
            <div class="elicpo-grid-pattern absolute inset-0 opacity-40"></div>

            <div class="relative px-3">
                <h2
                    data-reveal
                    class="text-center text-lg leading-snug font-black text-emerald-950 uppercase"
                >
                    {{ text('cta', 'heading', 'Đăng ký để được tư vấn miễn phí') }}
                </h2>

                <!-- Quyền lợi: icon + 1 dòng -->
                <ul class="mt-3 grid grid-cols-2 gap-2">
                    <li
                        v-for="benefit in ctaBenefits"
                        :key="benefit.value"
                        class="elicpo-lift flex items-center gap-1.5 rounded-xl border border-emerald-900/10 bg-white p-2 shadow-sm"
                    >
                        <span
                            class="flex size-5 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-700"
                        >
                            <Star class="size-3" />
                        </span>
                        <span class="text-[10px] leading-tight font-bold text-emerald-900">
                            {{ benefit.value }}
                        </span>
                    </li>
                </ul>

                <!-- Social proof -->
                <div
                    data-reveal
                    class="mt-3 flex items-center gap-2 rounded-xl border border-emerald-900/10 bg-white p-2"
                >
                    <div class="flex -space-x-2">
                        <img
                            v-for="person in [
                                '/images/elicpo/user/user1.png',
                                '/images/elicpo/user/user2.png',
                                '/images/elicpo/user/user3.jpg',
                            ]"
                            :key="person"
                            :src="person"
                            alt="Khách hàng ELICPO"
                            class="size-7 rounded-full border-2 border-white object-cover"
                            loading="lazy"
                        />
                        <span
                            class="flex size-7 items-center justify-center rounded-full border-2 border-white bg-emerald-600 text-[9px] font-black text-white"
                        >
                            +{{ number('finalCta', 'peopleCount', 99) }}
                        </span>
                    </div>
                    <div>
                        <div class="flex items-center gap-0.5 text-amber-500">
                            <Star
                                v-for="star in 5"
                                :key="star"
                                class="size-3 fill-current"
                            />
                        </div>
                        <p class="text-[10px] font-bold text-slate-600">
                            Đang có
                            <strong class="text-emerald-700">{{
                                number('finalCta', 'peopleCount', 99)
                            }}</strong>
                            người đăng ký nhận ưu đãi
                        </p>
                    </div>
                </div>

                <!-- Form đầy đủ -->
                <div data-reveal class="mt-3">
                    <OrderForm
                        :title="text('cta', 'formTitle')"
                        :subtitle="text('cta', 'formSubtitle')"
                        :coupon-code="text('cta', 'couponCode', 'ELICPO10')"
                    />
                </div>
            </div>
        </section>

        <!-- ===== ĐÁNH GIÁ ===== -->
        <section class="bg-white py-5">
            <div class="space-y-2 px-3">
                <article
                    v-for="review in reviews"
                    :key="review.name"
                    data-reveal
                    class="rounded-xl border border-emerald-900/10 bg-white p-2.5 shadow-sm"
                >
                    <div class="flex items-center justify-between gap-2">
                        <p class="text-[11px] font-black text-emerald-900">
                            {{ review.name }}
                        </p>
                        <p class="shrink-0 text-[9px] text-slate-400">
                            {{ review.time }}
                        </p>
                    </div>
                    <p class="mt-1 line-clamp-2 text-[11px] text-slate-600">
                        {{ review.content }}
                    </p>
                </article>
            </div>
        </section>

        <!-- ===== ẢNH KHÁCH HÀNG ===== -->
        <section
            v-if="props.feedbacks.length"
            class="bg-emerald-50/70 py-5"
        >
            <h2
                data-reveal
                class="px-3 text-center text-base font-black tracking-tight text-emerald-950 uppercase"
            >
                Vườn cây của bà con
            </h2>

            <div class="mt-3 grid grid-cols-2 gap-2 px-3">
                <article
                    v-for="feedback in props.feedbacks"
                    :key="feedback.id"
                    data-reveal
                    class="elicpo-lift group overflow-hidden rounded-xl border border-emerald-900/10 bg-white shadow-sm"
                >
                    <img
                        v-if="feedback.image"
                        :src="feedback.image"
                        :alt="feedback.name"
                        class="elicpo-zoom aspect-[4/3] w-full object-cover"
                        loading="lazy"
                    />

                    <div class="p-2">
                        <div class="flex items-center gap-1.5">
                            <p class="truncate text-[10px] font-black text-emerald-900">
                                {{ feedback.name }}
                            </p>
                            <div class="ml-auto flex gap-0.5 text-amber-500">
                                <span
                                    v-for="star in 5"
                                    :key="star"
                                    class="text-[8px]"
                                    :class="
                                        star <= feedback.rating
                                            ? 'opacity-100'
                                            : 'opacity-25'
                                    "
                                >
                                    ★
                                </span>
                            </div>
                        </div>

                        <div
                            v-if="feedback.photos?.length"
                            class="mt-1.5 grid grid-cols-3 gap-1"
                        >
                            <img
                                v-for="(photo, index) in feedback.photos"
                                :key="index"
                                :src="photo"
                                :alt="`Ảnh cây trồng của ${feedback.name}`"
                                class="elicpo-zoom aspect-square w-full rounded-md object-cover"
                                loading="lazy"
                            />
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <!-- ===== FOOTER ===== -->
        <footer
            class="border-t border-emerald-900/10 bg-emerald-50/60 pt-4 pb-28 text-slate-600"
        >
            <div class="px-3">
                <p class="text-sm font-black text-emerald-900 uppercase">
                    {{ text('footer', 'brandName', 'ELICPO') }}
                </p>
                <p class="mt-1 text-[10px] leading-relaxed">
                    {{ text('footer', 'companyName') }}<br />
                    {{ text('footer', 'address') }}<br />
                    HOTLINE:
                    <a
                        :href="text('footer', 'hotlineHref')"
                        class="font-bold text-emerald-700 hover:underline"
                    >
                        {{ text('footer', 'hotline') }}
                    </a>
                </p>

                <p
                    class="mt-3 border-t border-emerald-900/10 pt-3 text-center text-[9px] text-slate-500"
                >
                    {{ text('footer', 'copyright') }}
                </p>
            </div>
        </footer>

        <!-- ===== NỔI TRÊN MÀN HÌNH ===== -->
        <FloatingConsult
            :hotline="text('footer', 'hotline', '0973.42.6704')"
            :hotline-href="text('footer', 'hotlineHref', 'tel:0973426704')"
            :coupon-code="text('finalCta', 'couponCode', 'ELICPO10')"
            :people-count="number('finalCta', 'peopleCount', 99)"
        />

        <FloatingLeadDock
            :hotline="text('footer', 'hotline', '0973.42.6704')"
            :hotline-href="text('footer', 'hotlineHref', 'tel:0973426704')"
            :submit-label="text('stickyCta', 'registerLabel', 'Đăng ký tư vấn')"
        />

        <!-- ===== THÔNG BÁO ĐĂNG KÝ MỖI 10 GIÂY ===== -->
        <RegistrationNotifier />
    </div>
</template>
