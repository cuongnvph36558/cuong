<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import {
    ArrowRight,
    Award,
    Check,
    Leaf,
    Phone,
    Quote,
    Sparkles,
    Star,
    TrendingUp,
} from '@lucide/vue';
import { computed } from 'vue';
import FloatingCta from '@/components/FloatingCta.vue';
import ImageGallery, { type GalleryItem } from '@/components/ImageGallery.vue';
import LeadForm from '@/components/LeadForm.vue';
import PromoBar from '@/components/PromoBar.vue';
import RegisterModal from '@/components/RegisterModal.vue';
import TiltCard from '@/components/TiltCard.vue';
import { useCounter } from '@/composables/useCounter';
import { useScrollReveal } from '@/composables/useScrollReveal';
import type { Feedback } from '@/types/feedback';
import type {
    HomeContent,
    HomeContentImageItem,
} from '@/types/homeContent';

useScrollReveal();
useCounter();

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
    title: text('seo', 'title', 'Phân bón ROOTBIO'),
    description: text('seo', 'description'),
}));

const features = computed(() => list('hero', 'features'));
const plantTypes = computed(() => list('plantTypes', 'items'));
const problems = computed(() => list('problems', 'items'));
const warningTags = computed(() => list('problems', 'warningTags'));
const solutions = computed(() => list('solutions', 'items'));
const testimonials = computed(() => list('testimonials', 'items'));
const highlights = computed(() => list('highlights', 'items'));
const ingredients = computed(() => list('ingredients', 'items'));
const benefits = computed(() => list('cta', 'benefits'));
const commitments = computed(() => list('cta', 'commitments'));
const reviews = computed(() => list('reviews', 'items'));
const problemTags = computed(() => list('problemSelector', 'items'));
const infoLinks = computed(() => list('footer', 'infoLinks'));
const formPlantTypes = computed(() =>
    list('cta', 'plantTypes').map((item) => item.value ?? ''),
);
const formSymptoms = computed(() =>
    list('problemSelector', 'items').map((item) => item.value ?? ''),
);

/** Gallery of real product / farm photos used by the image-first sections. */
const gallery = computed(() => [
    { src: '/images/rootbio/feature1.png', label: 'Cây bung đọt' },
    { src: '/images/rootbio/grow.gif', label: 'Rễ phát triển' },
    { src: '/images/rootbio/tech.png', label: 'Công nghệ Nano' },
    { src: '/images/rootbio/label.png', label: 'Nhãn sản phẩm' },
    { src: '/images/rootbio/cta1.jpg', label: 'Vườn cây' },
    { src: '/images/rootbio/testimonial1.jpg', label: 'Nhà vườn' },
    { src: '/images/rootbio/quote1.gif', label: 'Báo chí' },
    { src: '/images/rootbio/user/user1.png', label: 'Khách hàng' },
]);

/** Gallery section managed in admin, with graceful fallback to the marquee items. */
const gallerySectionHeading = computed(() =>
    text('gallery', 'heading', 'Thư viện hình ảnh sản phẩm'),
);
const gallerySectionDescription = computed(() =>
    text(
        'gallery',
        'description',
        'Bấm vào ảnh để xem phóng to hình ảnh sản phẩm và vườn cây thực tế của bà con.',
    ),
);
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

    return gallery.value.map((item) => ({
        src: item.src,
        title: item.label,
        description: '',
    }));
});

const plantImages = computed(() => {
    const sources = [
        '/images/rootbio/effect1.png',
        '/images/rootbio/effect2.png',
        '/images/rootbio/effect3.png',
        '/images/rootbio/effect4.png',
        '/images/rootbio/tech1.png',
        '/images/rootbio/tech2.png',
    ];

    return plantTypes.value.map((plant, index) => ({
        label: plant.value ?? '',
        image: sources[index % sources.length] ?? sources[0],
    }));
});

</script>

<template>
    <Head :title="seo.title">
        <meta name="description" :content="seo.description" />
    </Head>

    <div class="rootbio-page flex min-h-screen flex-col bg-white text-slate-800">
        <!-- ===== PROMO BAR (đăng ký & ưu đãi, hiển thị liên tục) ===== -->
        <PromoBar
            :message="text('hero', 'badgeText')"
            :coupon-code="text('finalCta', 'couponCode', 'HT212')"
            :cta-label="text('hero', 'primaryCtaLabel', 'Nhận ưu đãi')"
            :cta-href="text('hero', 'primaryCtaHref', '#dang-ky')"
            :hotline="text('hero', 'navPhone', '0973.42.6704')"
            :hotline-href="`tel:${text('hero', 'navPhone').replace(/\D/g, '')}`"
        />

        <!-- ===== NAV ===== -->
        <nav
            class="relative z-40 border-b border-emerald-900/10 bg-white"
        >
            <div
                class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-3 py-2.5 sm:px-6"
            >
                <div class="flex min-w-0 items-center gap-2">
                    <div
                        class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-600 to-lime-500 text-sm font-black text-white"
                    >
                        {{ text('hero', 'brandLetter', 'R') }}
                    </div>
                    <div class="min-w-0 leading-tight">
                        <p
                            class="truncate text-sm font-black text-emerald-900 uppercase"
                        >
                            {{ text('hero', 'brandName', 'ROOTBIO') }}
                        </p>
                        <p class="truncate text-[10px] font-medium text-emerald-700/80">
                            {{ text('hero', 'brandTagline', 'Phân bón sinh học') }}
                        </p>
                    </div>
                </div>

                <div class="flex shrink-0 items-center gap-2">
                    <a
                        :href="`tel:${text('hero', 'navPhone').replace(/\D/g, '')}`"
                        class="hidden items-center gap-1.5 rounded-full border border-emerald-700/30 px-3 py-2 text-xs font-bold text-emerald-800 transition hover:bg-emerald-50 sm:inline-flex"
                    >
                        <Phone class="size-3.5" />
                        {{ text('hero', 'navPhone') }}
                    </a>
                    <a
                        :href="text('hero', 'primaryCtaHref', '#dang-ky')"
                        class="rootbio-cta rootbio-cta-ring shrink-0 rounded-full bg-emerald-600 px-4 py-2 text-xs font-black text-white uppercase shadow-md shadow-emerald-600/25"
                    >
                        {{ text('hero', 'navCtaLabel', 'Đăng ký ngay') }}
                    </a>
                </div>
            </div>
        </nav>

        <!-- ===== HERO ===== -->
        <header class="relative overflow-hidden bg-emerald-50/60">
            <div class="rootbio-aurora absolute inset-0 opacity-70"></div>

            <div
                class="relative mx-auto grid max-w-7xl items-center gap-5 px-3 py-5 sm:px-6 sm:py-8 lg:grid-cols-2 lg:gap-10"
            >
                <div>
                    <p
                        data-reveal
                        class="inline-flex items-center gap-1.5 rounded-full bg-white px-3 py-1.5 text-[11px] font-black tracking-wide text-emerald-700 uppercase ring-1 ring-emerald-600/20"
                    >
                        <Sparkles class="size-3.5" />
                        {{ text('hero', 'badgeText') }}
                    </p>

                    <h1
                        data-reveal
                        class="mt-3 text-[1.75rem] leading-[1.1] font-black tracking-tight text-emerald-950 uppercase sm:text-4xl lg:text-5xl"
                    >
                        {{ text('hero', 'titlePrefix', 'Phân bón') }}
                        <span class="text-emerald-600">
                            {{ text('hero', 'titleAccent', 'ROOTBIO') }}
                        </span>
                    </h1>

                    <p
                        data-reveal
                        class="mt-2 text-sm font-bold text-emerald-800 sm:text-base"
                    >
                        {{ text('hero', 'titleSubtitle') }}
                    </p>

                    <div data-reveal class="mt-4 flex flex-wrap gap-2">
                        <a
                            :href="text('hero', 'primaryCtaHref', '#dang-ky')"
                            class="rootbio-cta rootbio-cta-ring rootbio-cta-shake inline-flex items-center gap-2 rounded-full bg-emerald-600 px-7 py-4 text-base font-black text-white uppercase shadow-lg shadow-emerald-600/25 sm:text-lg"
                        >
                            {{ text('hero', 'primaryCtaLabel', 'Nhận ưu đãi') }}
                            <ArrowRight class="rootbio-cta-icon size-5" />
                        </a>
                        <a
                            :href="text('hero', 'secondaryCtaHref', '#hieu-qua')"
                            class="inline-flex items-center gap-2 rounded-full border-2 border-emerald-700/40 px-6 py-3 text-sm font-bold text-emerald-800 uppercase transition hover:bg-emerald-50"
                        >
                            {{ text('hero', 'secondaryCtaLabel', 'Xem hiệu quả') }}
                        </a>
                    </div>

                    <div
                        data-reveal
                        class="mt-4 flex flex-wrap gap-1.5"
                    >
                        <span
                            v-for="feature in features"
                            :key="feature.value"
                            class="rounded-full border border-emerald-900/10 bg-white px-2.5 py-1 text-[10px] font-bold text-emerald-900 uppercase shadow-sm"
                        >
                            {{ feature.value }}
                        </span>
                    </div>
                </div>

                <!-- Hero image (image-first) -->
                <div class="relative" data-reveal>
                    <TiltCard :max="8" :scale="1.03">
                        <div
                            class="relative aspect-square overflow-hidden rounded-3xl border border-emerald-900/10 bg-white shadow-xl shadow-emerald-900/10"
                        >
                            <img
                                :src="text('hero', 'productImage')"
                                alt="Phân bón ROOTBIO"
                                class="size-full object-cover"
                                fetchpriority="high"
                            />
                            <div
                                class="pointer-events-none absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-emerald-950/45 to-transparent"
                            ></div>
                            <div
                                class="absolute right-3 bottom-3 left-3 rounded-2xl bg-white/95 p-3 shadow-lg backdrop-blur"
                            >
                                <p class="text-xs font-black text-emerald-700 uppercase">
                                    {{ text('hero', 'productBadgeTitle') }}
                                </p>
                                <p class="mt-0.5 text-[11px] text-slate-600">
                                    {{ text('hero', 'productBadgeText') }}
                                </p>
                            </div>
                        </div>
                    </TiltCard>

                    <div
                        class="absolute -top-3 -left-2 flex animate-bounce items-center gap-2 rounded-2xl bg-lime-400 px-3 py-2 shadow-lg shadow-lime-500/30"
                    >
                        <p class="text-lg font-black text-emerald-950">
                            {{ text('hero', 'floatingBadgeValue', '100') }}
                        </p>
                        <p
                            class="text-[10px] leading-tight font-bold text-emerald-900 uppercase"
                        >
                            {{ text('hero', 'floatingBadgeLabel', 'Chai dùng thử') }}
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <!-- ===== IMAGE GALLERY STRIP ===== -->
        <section class="relative bg-white py-5">
            <div class="relative overflow-hidden">
                <div class="rootbio-marquee-track flex w-max items-center">
                    <div
                        v-for="copy in 2"
                        :key="copy"
                        class="flex items-center gap-3 pr-3"
                    >
                        <figure
                            v-for="item in gallery"
                            :key="`${copy}-${item.src}`"
                            class="w-40 shrink-0 overflow-hidden rounded-2xl border border-emerald-900/10 bg-white shadow-sm sm:w-52"
                        >
                            <img
                                :src="item.src"
                                :alt="item.label"
                                class="aspect-square w-full object-cover"
                                loading="lazy"
                            />
                            <figcaption
                                class="px-2 py-1.5 text-center text-[10px] font-bold text-emerald-900 uppercase"
                            >
                                {{ item.label }}
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== IMAGE GALLERY (Thư viện ảnh) ===== -->
        <section class="relative bg-white py-8 sm:py-10">
            <div class="mx-auto max-w-7xl px-3 sm:px-6">
                <ImageGallery
                    :items="galleryItems"
                    :heading="gallerySectionHeading"
                    :description="gallerySectionDescription"
                />
            </div>
        </section>

        <!-- ===== PROBLEMS (image grid) ===== -->
        <section class="relative bg-white py-8 sm:py-10">
            <div class="mx-auto max-w-7xl px-3 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-xl font-black tracking-tight text-emerald-950 uppercase sm:text-3xl"
                >
                    {{ text('problems', 'heading') }}
                </h2>

                <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    <article
                        v-for="problem in problems"
                        :key="problem.title"
                        data-reveal
                        class="group relative overflow-hidden rounded-2xl border border-emerald-900/10 bg-white shadow-sm"
                    >
                        <img
                            :src="problem.image"
                            :alt="problem.title"
                            class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105"
                            loading="lazy"
                        />
                        <div
                            class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-emerald-950/90 via-emerald-950/60 to-transparent p-3 pt-8"
                        >
                            <h3
                                class="text-xs leading-snug font-black text-white uppercase sm:text-sm"
                            >
                                {{ problem.title }}
                            </h3>
                        </div>
                    </article>
                </div>

                <div
                    data-reveal
                    class="mt-4 flex flex-wrap items-center justify-center gap-2 rounded-2xl border border-amber-300 bg-amber-50 p-3"
                >
                    <span
                        class="text-xs font-black text-amber-700 uppercase"
                    >
                        {{ text('problems', 'warningTitle', 'Cảnh báo!') }}
                    </span>
                    <span
                        v-for="tag in warningTags"
                        :key="tag.value"
                        class="rounded-full border border-amber-300 bg-white px-2.5 py-0.5 text-[10px] font-black text-amber-700 uppercase"
                    >
                        {{ tag.value }}
                    </span>
                </div>
            </div>
        </section>

        <!-- ===== SOLUTIONS (image cards) ===== -->
        <section
            id="hieu-qua"
            class="relative bg-emerald-50/70 py-8 sm:py-10"
        >
            <div class="mx-auto max-w-7xl px-3 sm:px-6">
                <div class="text-center">
                    <p
                        data-reveal
                        class="text-[11px] font-black tracking-[0.25em] text-emerald-600 uppercase"
                    >
                        {{ text('solutions', 'eyebrow') }}
                    </p>
                    <h2
                        data-reveal
                        class="mt-1 text-xl font-black tracking-tight text-emerald-950 uppercase sm:text-3xl"
                    >
                        {{ text('solutions', 'heading') }}
                    </h2>
                </div>

                <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    <article
                        v-for="solution in solutions"
                        :key="solution.title"
                        data-reveal
                        class="group overflow-hidden rounded-2xl border border-emerald-900/10 bg-white shadow-sm"
                    >
                        <img
                            :src="solution.image"
                            :alt="solution.title"
                            class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105"
                            loading="lazy"
                        />
                        <div class="p-3">
                            <h3
                                class="text-xs leading-snug font-black text-emerald-900 uppercase sm:text-sm"
                            >
                                {{ solution.title }}
                            </h3>
                            <p
                                class="mt-1 line-clamp-3 text-[11px] leading-relaxed text-slate-600"
                            >
                                {{ solution.description }}
                            </p>
                        </div>
                    </article>
                </div>

                <div
                    data-reveal
                    class="mt-6 grid gap-3 overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-700 to-emerald-500 p-5 text-center text-white sm:grid-cols-2"
                >
                    <div>
                        <p class="text-xs font-black uppercase">
                            {{ text('solutions', 'statsEyebrow') }}
                        </p>
                        <p
                            class="rootbio-counter text-3xl font-black text-lime-200 sm:text-5xl"
                            :data-target="number('solutions', 'statsValue', 3826534)"
                        >
                            0
                        </p>
                        <p class="text-[11px] text-emerald-50">
                            {{ text('solutions', 'statsValueLabel') }}
                        </p>
                    </div>
                    <div class="sm:border-l sm:border-white/20">
                        <p
                            class="rootbio-counter text-3xl font-black text-white sm:text-5xl"
                            :data-target="
                                number('solutions', 'statsSecondaryValue', 99)
                            "
                        >
                            0
                        </p>
                        <p class="text-[11px] text-emerald-50">
                            {{ text('solutions', 'statsSecondaryLabel') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== INGREDIENTS ===== -->
        <section class="relative bg-white py-8 sm:py-10">
            <div class="mx-auto max-w-7xl px-3 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-xl font-black tracking-tight text-emerald-950 uppercase sm:text-3xl"
                >
                    {{ text('ingredients', 'heading') }}
                </h2>

                <div class="mt-6 grid grid-cols-2 gap-3 lg:grid-cols-4">
                    <article
                        v-for="ingredient in ingredients"
                        :key="ingredient.title"
                        data-reveal
                        class="overflow-hidden rounded-2xl border border-emerald-900/10 bg-white text-center shadow-sm"
                    >
                        <img
                            :src="ingredient.image"
                            :alt="ingredient.title"
                            class="aspect-square w-full object-cover"
                            loading="lazy"
                        />
                        <div class="p-2.5">
                            <h3
                                class="text-[11px] font-black text-emerald-900 uppercase sm:text-xs"
                            >
                                {{ ingredient.title }}
                            </h3>
                            <p
                                class="mt-0.5 line-clamp-2 text-[10px] leading-relaxed text-slate-600"
                            >
                                {{ ingredient.description }}
                            </p>
                        </div>
                    </article>
                </div>

                <p
                    data-reveal
                    class="mt-5 text-center text-sm font-black tracking-[0.15em] text-emerald-700 uppercase sm:text-xl"
                >
                    {{ text('ingredients', 'footerText') }}
                </p>
            </div>
        </section>

        <!-- ===== PLANT TYPES (image chips) ===== -->
        <section class="relative bg-emerald-50/70 py-8 sm:py-10">
            <div class="mx-auto max-w-7xl px-3 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-xl font-black tracking-tight text-emerald-950 uppercase sm:text-3xl"
                >
                    {{ text('plantTypes', 'heading') }}
                </h2>

                <div
                    class="mt-6 grid grid-cols-3 gap-3 sm:grid-cols-6"
                >
                    <figure
                        v-for="plant in plantImages"
                        :key="plant.label"
                        data-reveal
                        class="overflow-hidden rounded-2xl border border-emerald-900/10 bg-white shadow-sm"
                    >
                        <img
                            :src="plant.image"
                            :alt="plant.label"
                            class="aspect-square w-full object-cover"
                            loading="lazy"
                        />
                        <figcaption
                            class="px-1.5 py-1.5 text-center text-[10px] font-black text-emerald-900 uppercase"
                        >
                            {{ plant.label }}
                        </figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <!-- ===== HIGHLIGHTS ===== -->
        <section class="relative bg-white py-8 sm:py-10">
            <div class="mx-auto max-w-7xl px-3 sm:px-6">
                <div class="text-center">
                    <h2
                        data-reveal
                        class="text-sm font-black text-emerald-700 uppercase"
                    >
                        {{ text('highlights', 'heading') }}
                    </h2>
                    <p
                        data-reveal
                        class="mt-1 text-lg font-black tracking-tight text-emerald-950 uppercase sm:text-2xl"
                    >
                        {{ text('highlights', 'subheading') }}
                    </p>
                </div>

                <ul class="mt-5 grid gap-2.5 md:grid-cols-2">
                    <li
                        v-for="(item, index) in highlights"
                        :key="item.value"
                        data-reveal
                        class="flex items-start gap-3 rounded-2xl border border-emerald-900/10 bg-emerald-50/60 p-3.5"
                    >
                        <span
                            class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-xs font-black text-white"
                        >
                            {{ index + 1 }}
                        </span>
                        <span class="text-xs leading-relaxed font-medium text-slate-700 sm:text-sm">{{
                            item.value
                        }}</span>
                    </li>
                </ul>
            </div>
        </section>

        <!-- ===== TESTIMONIALS ===== -->
        <section class="relative bg-emerald-50/70 py-8 sm:py-10">
            <div class="mx-auto max-w-7xl px-3 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-xl font-black tracking-tight text-emerald-950 uppercase sm:text-3xl"
                >
                    {{ text('testimonials', 'heading') }}
                </h2>

                <div class="mt-6 grid gap-3 sm:grid-cols-2 md:grid-cols-3">
                    <figure
                        v-for="testimonial in testimonials"
                        :key="testimonial.author"
                        data-reveal
                        class="overflow-hidden rounded-2xl border border-emerald-900/10 bg-white shadow-sm"
                    >
                        <img
                            :src="testimonial.image"
                            :alt="testimonial.author"
                            class="aspect-[4/3] w-full object-cover"
                            loading="lazy"
                        />
                        <figcaption class="p-3">
                            <Quote class="size-4 text-emerald-400" />
                            <p
                                class="mt-1 line-clamp-3 text-[11px] leading-relaxed text-slate-700 italic"
                            >
                                "{{ testimonial.quote }}"
                            </p>
                            <p
                                class="mt-2 border-t border-slate-100 pt-2 text-[11px] font-black text-emerald-900 uppercase"
                            >
                                {{ testimonial.author }}
                            </p>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <!-- ===== PROBLEM SELECTOR ===== -->
        <section class="relative bg-white py-8 sm:py-10">
            <div class="mx-auto max-w-7xl px-3 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-xl font-black tracking-tight text-emerald-950 uppercase sm:text-3xl"
                >
                    {{ text('problemSelector', 'heading') }}
                </h2>

                <div class="mt-5 flex flex-wrap justify-center gap-2">
                    <span
                        v-for="tag in problemTags"
                        :key="tag.value"
                        data-reveal
                        class="rounded-full border-2 border-amber-300 bg-amber-50 px-4 py-2 text-xs font-black text-amber-700 uppercase shadow-sm sm:text-sm"
                    >
                        {{ tag.value }}
                    </span>
                </div>
            </div>
        </section>

        <!-- ===== PRESS & CERTIFICATES ===== -->
        <section class="relative bg-emerald-50/70 py-8 sm:py-10">
            <div class="mx-auto max-w-7xl px-3 sm:px-6">
                <div class="grid gap-3 sm:grid-cols-2">
                    <figure
                        data-reveal
                        class="overflow-hidden rounded-2xl border border-emerald-900/10 bg-white shadow-sm"
                    >
                        <img
                            :src="text('press', 'image')"
                            alt="Sản phẩm ROOTBIO được người Nhật đánh giá cao"
                            class="aspect-[4/3] w-full object-cover"
                            loading="lazy"
                        />
                        <figcaption
                            class="flex flex-wrap items-center gap-2 p-3"
                        >
                            <span
                                class="rounded-full bg-emerald-700 px-3 py-1 text-[10px] font-black text-white uppercase"
                            >
                                {{ text('press', 'badgeOne') }}
                            </span>
                            <span
                                class="rounded-full border-2 border-emerald-700 px-3 py-1 text-[10px] font-black text-emerald-800 uppercase"
                            >
                                {{ text('press', 'badgeTwo') }}
                            </span>
                        </figcaption>
                    </figure>

                    <figure
                        data-reveal
                        class="overflow-hidden rounded-2xl border border-emerald-900/10 bg-white shadow-sm"
                    >
                        <img
                            :src="text('certificates', 'image')"
                            alt="Chứng nhận và xét nghiệm phân bón ROOTBIO"
                            class="aspect-[4/3] w-full object-cover"
                            loading="lazy"
                        />
                        <figcaption class="p-3">
                            <h3
                                class="flex items-center gap-1.5 text-xs font-black text-emerald-900 uppercase"
                            >
                                <Award class="size-4" />
                                {{ text('certificates', 'heading') }}
                            </h3>
                            <p
                                class="mt-1 line-clamp-2 text-[11px] leading-relaxed text-slate-600"
                            >
                                {{ text('certificates', 'description') }}
                            </p>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <!-- ===== REVIEWS ===== -->
        <section class="relative bg-white py-8 sm:py-10">
            <div class="mx-auto max-w-7xl px-3 sm:px-6">
                <div class="grid gap-4 lg:grid-cols-3">
                    <div
                        data-reveal
                        class="rounded-2xl border border-emerald-900/10 bg-emerald-50/60 p-4 text-center"
                    >
                        <div
                            class="flex items-center justify-center gap-1 text-amber-500"
                        >
                            <Star
                                v-for="star in 5"
                                :key="star"
                                class="size-4 fill-current"
                            />
                        </div>
                        <p
                            class="mt-2 text-4xl font-black text-emerald-600"
                        >
                            {{ number('reviews', 'averageRating', 5) }}
                        </p>
                        <p class="text-xs text-slate-500">
                            {{ text('reviews', 'totalReviews') }}
                        </p>
                    </div>

                    <div class="space-y-2 lg:col-span-2">
                        <article
                            v-for="review in reviews"
                            :key="review.name"
                            data-reveal
                            class="rounded-2xl border border-emerald-900/10 bg-white p-3 shadow-sm"
                        >
                            <div
                                class="flex items-center justify-between gap-3"
                            >
                                <p class="text-xs font-black text-emerald-900">
                                    {{ review.name }}
                                </p>
                                <p class="shrink-0 text-[10px] text-slate-400">
                                    {{ review.time }}
                                </p>
                            </div>
                            <p class="mt-1 line-clamp-2 text-xs text-slate-600">
                                {{ review.content }}
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== CUSTOMER FEEDBACK GALLERY ===== -->
        <section
            v-if="props.feedbacks.length"
            class="relative bg-lime-50 py-8 sm:py-10"
        >
            <div class="mx-auto max-w-7xl px-3 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-xl font-black tracking-tight text-emerald-950 uppercase sm:text-2xl"
                >
                    Hình ảnh vườn cây của bà con
                </h2>

                <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    <article
                        v-for="feedback in props.feedbacks"
                        :key="feedback.id"
                        data-reveal
                        class="overflow-hidden rounded-2xl border border-emerald-900/10 bg-white shadow-sm"
                    >
                        <img
                            v-if="feedback.image"
                            :src="feedback.image"
                            :alt="feedback.name"
                            class="aspect-[4/3] w-full object-cover"
                            loading="lazy"
                        />

                        <div class="p-3">
                            <div class="flex items-center gap-2">
                                <p class="truncate text-xs font-black text-emerald-900">
                                    {{ feedback.name }}
                                </p>
                                <div class="ml-auto flex gap-0.5 text-amber-500">
                                    <span
                                        v-for="star in 5"
                                        :key="star"
                                        class="text-[10px]"
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
                            <p
                                class="mt-1 line-clamp-2 text-[11px] leading-relaxed text-slate-600 italic"
                            >
                                "{{ feedback.content }}"
                            </p>

                            <div
                                v-if="feedback.photos?.length"
                                class="mt-2 grid grid-cols-3 gap-1.5"
                            >
                                <img
                                    v-for="(photo, index) in feedback.photos"
                                    :key="index"
                                    :src="photo"
                                    :alt="`Ảnh cây trồng của ${feedback.name}`"
                                    class="aspect-square w-full rounded-lg object-cover"
                                    loading="lazy"
                                />
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- ===== CTA FORM ===== -->
        <section
            id="dang-ky"
            class="relative overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-lime-50 py-10 sm:py-12"
        >
            <div class="mx-auto grid max-w-7xl items-start gap-6 px-3 sm:px-6 lg:grid-cols-2 lg:gap-10">
                <div>
                    <h2
                        data-reveal
                        class="text-xl leading-snug font-black text-emerald-950 uppercase sm:text-2xl"
                    >
                        {{ text('cta', 'heading') }}
                    </h2>

                    <ul class="mt-4 grid gap-2 sm:grid-cols-2">
                        <li
                            v-for="benefit in benefits"
                            :key="benefit.value"
                            class="flex items-center gap-2 rounded-xl border border-emerald-900/10 bg-white p-2.5 shadow-sm"
                        >
                            <span
                                class="flex size-5 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-700"
                            >
                                <Check class="size-3" />
                            </span>
                            <span class="text-[11px] font-bold text-emerald-900 sm:text-xs">
                                {{ benefit.value }}
                            </span>
                        </li>
                    </ul>

                    <ul class="mt-4 grid gap-1.5">
                        <li
                            v-for="commitment in commitments"
                            :key="commitment.value"
                            class="flex items-start gap-2 text-[11px] leading-relaxed text-slate-600"
                        >
                            <Leaf class="mt-0.5 size-3 shrink-0 text-emerald-500" />
                            <span class="line-clamp-2">{{ commitment.value }}</span>
                        </li>
                    </ul>

                    <!-- Oversized offer CTA -->
                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <a
                            :href="text('hero', 'primaryCtaHref', '#dang-ky')"
                            class="rootbio-cta rootbio-cta-ring rootbio-cta-shake inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-emerald-600 via-emerald-500 to-lime-500 px-8 py-5 text-xl font-black text-white uppercase shadow-2xl shadow-emerald-600/40 sm:text-2xl"
                        >
                            {{ text('hero', 'primaryCtaLabel', 'Nhận ưu đãi') }}
                            <ArrowRight class="rootbio-cta-icon size-6" />
                        </a>

                        <a
                            :href="`tel:${text('footer', 'hotline', '0973.42.6704').replace(/\D/g, '')}`"
                            class="rootbio-cta rootbio-cta-ring inline-flex items-center gap-2 rounded-full border-2 border-emerald-700 bg-white px-7 py-5 text-lg font-black text-emerald-800 uppercase shadow-xl shadow-emerald-900/10"
                        >
                            <Phone class="size-5" />
                            {{ text('footer', 'hotline', '0973.42.6704') }}
                        </a>
                    </div>
                </div>

                <div data-reveal>
                    <LeadForm
                        :title="text('cta', 'formTitle')"
                        :subtitle="text('cta', 'formSubtitle')"
                        :coupon-code="text('cta', 'couponCode', 'HT212')"
                        :plant-types="formPlantTypes"
                        :symptoms="formSymptoms"
                    />
                </div>
            </div>
        </section>

        <!-- ===== FOOTER ===== -->
        <footer
            class="rootbio-footer border-t border-emerald-900/10 bg-emerald-50/60 pt-6 pb-24 text-slate-600 sm:pb-8"
        >
            <div class="mx-auto max-w-7xl px-3 sm:px-6">
                <div class="grid gap-5 md:grid-cols-3">
                    <div>
                        <p class="text-base font-black text-emerald-900 uppercase">
                            {{ text('footer', 'brandName', 'ROOTBIO') }}
                        </p>
                        <p class="mt-1.5 text-[11px] leading-relaxed">
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
                    </div>

                    <div>
                        <p class="flex items-center gap-1.5 font-black text-emerald-900 uppercase">
                            <TrendingUp class="size-4" />
                            {{ text('footer', 'plantListHeading') }}
                        </p>
                        <ul class="mt-2 grid grid-cols-2 gap-1 text-[11px]">
                            <li
                                v-for="plant in plantTypes"
                                :key="plant.value"
                            >
                                {{ plant.value }}
                            </li>
                        </ul>
                    </div>

                    <div>
                        <p class="font-black text-emerald-900 uppercase">
                            {{ text('footer', 'infoHeading') }}
                        </p>
                        <ul class="mt-2 space-y-1 text-[11px]">
                            <li v-for="link in infoLinks" :key="link.value">
                                {{ link.value }}
                            </li>
                        </ul>
                    </div>
                </div>

                <p
                    class="mt-5 border-t border-emerald-900/10 pt-4 text-center text-[10px] text-slate-500"
                >
                    {{ text('footer', 'copyright') }}
                </p>
            </div>
        </footer>

        <!-- ===== FLOATING CTA (ưu đãi & đăng ký nổi bật, hiển thị liên tục) ===== -->
        <FloatingCta
            :coupon-code="text('finalCta', 'couponCode', 'HT212')"
            :register-label="text('stickyCta', 'registerLabel', 'Đăng ký nhận ưu đãi')"
            :register-href="text('stickyCta', 'registerHref', '#dang-ky')"
            :hotline="text('footer', 'hotline', '0973.42.6704')"
            :hotline-href="text('footer', 'hotlineHref', 'tel:0973426704')"
            :people-count="number('finalCta', 'peopleCount', 99)"
        />

        <!-- ===== REGISTER MODAL (hiện ngay khi vào trang) ===== -->
        <RegisterModal
            :title="text('finalCta', 'title', 'Nhận ưu đãi - Tặng 100 chai dùng thử')"
            :subtitle="text('finalCta', 'subtitle', 'Điền thông tin để kỹ sư nông nghiệp tư vấn miễn phí.')"
            :coupon-code="text('finalCta', 'couponCode', 'HT212')"
            :people-count="number('finalCta', 'peopleCount', 99)"
            :hotline="text('footer', 'hotline', '0973.42.6704')"
            :hotline-href="text('footer', 'hotlineHref', 'tel:0973426704')"
            :images="
                galleryItems.map((item) => ({
                    src: item.src,
                    title: item.title,
                }))
            "
            :plant-types="formPlantTypes"
            :symptoms="formSymptoms"
        />
    </div>
</template>
