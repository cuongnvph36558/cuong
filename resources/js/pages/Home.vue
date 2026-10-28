<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';
import LeadForm from '@/components/LeadForm.vue';
import TiltCard from '@/components/TiltCard.vue';
import { useCounter } from '@/composables/useCounter';
import { useScrollReveal } from '@/composables/useScrollReveal';
import type {
    HomeContent,
    HomeContentImageItem,
} from '@/types/homeContent';

useScrollReveal();
useCounter();

type Props = {
    content: HomeContent;
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
const ratingBars = computed(() => list('reviews', 'ratingBars'));
const problemTags = computed(() => list('problemSelector', 'items'));
const footerPlantTypes = computed(() => list('plantTypes', 'items'));
const infoLinks = computed(() => list('footer', 'infoLinks'));
const formPlantTypes = computed(() =>
    list('cta', 'plantTypes').map((item) => item.value ?? ''),
);
const formSymptoms = computed(() =>
    list('problemSelector', 'items').map((item) => item.value ?? ''),
);

const activeSlide = ref(0);
let sliderTimer: ReturnType<typeof setInterval> | undefined;

const currentProblem = computed(() => problems.value[activeSlide.value]);

watch(
    () => problems.value.length,
    (length) => {
        if (activeSlide.value >= length) {
            activeSlide.value = 0;
        }
    },
);

function startSlider(): void {
    if (problems.value.length < 2) {
        return;
    }

    sliderTimer = setInterval(() => {
        activeSlide.value = (activeSlide.value + 1) % problems.value.length;
    }, 5000);
}

onMounted(startSlider);
onUnmounted(() => clearInterval(sliderTimer));
</script>

<template>
    <Head :title="seo.title">
        <meta name="description" :content="seo.description" />
    </Head>

    <div class="rootbio-page min-h-screen bg-white text-slate-900">
        <!-- ===== HERO ===== -->
        <header
            class="relative overflow-hidden bg-gradient-to-b from-emerald-950 via-emerald-900 to-emerald-800 text-white"
        >
            <div class="rootbio-aurora absolute inset-0 opacity-70"></div>

            <nav
                class="relative z-20 mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6"
            >
                <div class="flex items-center gap-3">
                    <div
                        class="flex size-11 items-center justify-center rounded-2xl bg-gradient-to-br from-lime-300 to-emerald-500 text-lg font-black text-emerald-950 shadow-lg shadow-emerald-950/40"
                    >
                        {{ text('hero', 'brandLetter', 'R') }}
                    </div>
                    <div class="leading-tight">
                        <p class="text-lg font-black tracking-wide uppercase">
                            {{ text('hero', 'brandName', 'ROOTBIO') }}
                        </p>
                        <p class="text-[11px] font-medium text-emerald-200">
                            {{ text('hero', 'brandTagline', 'Phân bón sinh học') }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a
                        :href="`tel:${text('hero', 'navPhone').replace(/\D/g, '')}`"
                        class="hidden rounded-full bg-white/10 px-4 py-2 text-sm font-bold backdrop-blur transition hover:bg-white/20 sm:inline-flex"
                    >
                        {{ text('hero', 'navPhone') }}
                    </a>
                    <a
                        :href="text('hero', 'primaryCtaHref', '#dang-ky')"
                        class="rounded-full bg-lime-400 px-5 py-2 text-sm font-black text-emerald-950 uppercase shadow-lg shadow-lime-500/30 transition hover:bg-lime-300"
                    >
                        {{ text('hero', 'navCtaLabel', 'Đăng ký ngay') }}
                    </a>
                </div>
            </nav>

            <div
                class="relative z-10 mx-auto grid max-w-7xl items-center gap-10 px-4 py-12 sm:px-6 lg:grid-cols-2 lg:py-16"
            >
                <div>
                    <p
                        data-reveal
                        class="mb-4 inline-flex items-center gap-2 rounded-full bg-lime-400/20 px-4 py-1.5 text-xs font-black tracking-widest text-lime-300 uppercase ring-1 ring-lime-400/40"
                    >
                        <span class="relative flex size-2">
                            <span
                                class="absolute inline-flex size-full animate-ping rounded-full bg-lime-400 opacity-75"
                            ></span>
                            <span
                                class="relative inline-flex size-2 rounded-full bg-lime-400"
                            ></span>
                        </span>
                        {{ text('hero', 'badgeText') }}
                    </p>

                    <h1
                        data-reveal
                        class="text-4xl leading-[1.05] font-black tracking-tight uppercase sm:text-5xl lg:text-6xl"
                    >
                        {{ text('hero', 'titlePrefix', 'Phân bón') }}
                        <span class="text-lime-300">
                            {{ text('hero', 'titleAccent', 'ROOTBIO') }}
                        </span>
                        <br />
                        <span
                            class="text-xl font-bold text-emerald-100 sm:text-2xl"
                        >
                            {{ text('hero', 'titleSubtitle') }}
                        </span>
                    </h1>

                    <p
                        data-reveal
                        class="mt-5 max-w-xl text-base text-emerald-100/90"
                    >
                        {{ text('hero', 'description') }}
                    </p>

                    <div data-reveal class="mt-7 flex flex-wrap gap-3">
                        <a
                            :href="text('hero', 'primaryCtaHref', '#dang-ky')"
                            class="rounded-full bg-lime-400 px-7 py-3.5 text-sm font-black tracking-wide text-emerald-950 uppercase shadow-xl shadow-lime-500/30 transition hover:-translate-y-0.5 hover:bg-lime-300"
                        >
                            {{ text('hero', 'primaryCtaLabel', 'Nhận ưu đãi') }}
                        </a>
                        <a
                            :href="text('hero', 'secondaryCtaHref', '#hieu-qua')"
                            class="rounded-full border-2 border-white/30 px-7 py-3.5 text-sm font-bold tracking-wide text-white uppercase transition hover:border-white hover:bg-white/10"
                        >
                            {{ text('hero', 'secondaryCtaLabel', 'Xem hiệu quả') }}
                        </a>
                    </div>

                    <div
                        data-reveal
                        class="mt-8 grid max-w-xl grid-cols-2 gap-3 sm:grid-cols-4"
                    >
                        <div
                            v-for="feature in features"
                            :key="feature.value"
                            class="rounded-xl bg-white/10 px-3 py-2.5 text-center text-[11px] font-bold tracking-wide uppercase ring-1 ring-white/15 backdrop-blur"
                        >
                            {{ feature.value }}
                        </div>
                    </div>
                </div>

                <div class="relative" data-reveal>
                    <TiltCard :max="16" :scale="1.06" class="drop-shadow-2xl">
                        <div
                            class="relative aspect-square overflow-hidden rounded-[2rem] border-4 border-white/20 bg-emerald-950/40"
                        >
                            <img
                                :src="text('hero', 'productImage')"
                                alt="Phân bón ROOTBIO"
                                class="size-full object-cover"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-emerald-950/70 via-transparent to-transparent"
                            ></div>
                            <div
                                class="absolute right-6 bottom-6 left-6 rounded-2xl bg-emerald-950/70 p-4 backdrop-blur"
                            >
                                <p
                                    class="text-sm font-black text-lime-300 uppercase"
                                >
                                    {{ text('hero', 'productBadgeTitle') }}
                                </p>
                                <p class="mt-1 text-xs text-emerald-100">
                                    {{ text('hero', 'productBadgeText') }}
                                </p>
                            </div>
                        </div>
                    </TiltCard>

                    <div
                        class="absolute top-10 -left-4 hidden animate-bounce rounded-2xl bg-lime-400 px-4 py-3 text-center shadow-2xl shadow-lime-500/40 sm:block"
                    >
                        <p class="text-2xl font-black text-emerald-950">
                            {{ text('hero', 'floatingBadgeValue', '100') }}
                        </p>
                        <p
                            class="text-[10px] font-bold text-emerald-900 uppercase"
                        >
                            {{ text('hero', 'floatingBadgeLabel', 'Chai dùng thử') }}
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <!-- ===== PLANT TYPES ===== -->
        <section class="relative overflow-hidden py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-3xl font-black tracking-tight text-emerald-950 uppercase sm:text-4xl"
                >
                    {{ text('plantTypes', 'heading') }}
                </h2>

                <div
                    class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6"
                >
                    <TiltCard
                        v-for="plant in plantTypes"
                        :key="plant.value"
                        :max="10"
                        :scale="1.08"
                        data-reveal
                    >
                        <div
                            class="flex h-28 flex-col items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-50 to-lime-100 p-3 text-center shadow-md ring-1 ring-emerald-900/10"
                        >
                            <span
                                class="text-sm font-black text-emerald-900 uppercase"
                            >
                                {{ plant.value }}
                            </span>
                        </div>
                    </TiltCard>
                </div>
            </div>
        </section>

        <!-- ===== PROBLEMS ===== -->
        <section
            class="relative overflow-hidden bg-emerald-950 py-16 text-white"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-3xl font-black tracking-tight uppercase sm:text-4xl"
                >
                    {{ text('problems', 'heading') }}
                </h2>

                <div class="mt-10 grid items-center gap-8 lg:grid-cols-2">
                    <div class="relative order-2 lg:order-1">
                        <TiltCard :max="12" :scale="1.04">
                            <div
                                class="relative aspect-[4/3] overflow-hidden rounded-3xl border border-white/15 bg-emerald-900 shadow-2xl"
                            >
                                <Transition name="fade">
                                    <img
                                        :key="currentProblem?.title"
                                        :src="currentProblem?.image"
                                        :alt="currentProblem?.title"
                                        class="size-full object-cover"
                                    />
                                </Transition>
                            </div>
                        </TiltCard>

                        <div class="mt-4 flex justify-center gap-2">
                            <button
                                v-for="(problem, index) in problems"
                                :key="problem.title"
                                type="button"
                                class="h-2 rounded-full transition-all"
                                :class="
                                    index === activeSlide
                                        ? 'w-8 bg-lime-400'
                                        : 'w-2 bg-white/30 hover:bg-white/60'
                                "
                                :aria-label="problem.title"
                                @click="activeSlide = index"
                            ></button>
                        </div>
                    </div>

                    <div class="order-1 space-y-3 lg:order-2">
                        <div
                            v-for="problem in problems"
                            :key="problem.title"
                            data-reveal
                            class="group rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur transition hover:border-lime-400/50 hover:bg-white/10"
                        >
                            <h3
                                class="flex items-center gap-2 text-lg font-black text-lime-300 uppercase"
                            >
                                <span
                                    class="text-xl text-red-400 transition-transform duration-300 group-hover:scale-125"
                                >
                                    ⚠
                                </span>
                                {{ problem.title }}
                            </h3>
                            <p class="mt-2 text-sm text-emerald-100/80">
                                {{ problem.description }}
                            </p>
                        </div>

                        <div
                            data-reveal
                            class="rounded-2xl border border-red-500/40 bg-red-500/10 p-5"
                        >
                            <h3
                                class="text-xl font-black text-red-300 uppercase"
                            >
                                {{ text('problems', 'warningTitle', 'Cảnh báo!') }}
                            </h3>
                            <p class="mt-2 text-sm text-red-100/90">
                                {{ text('problems', 'warningText') }}
                            </p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span
                                    v-for="tag in warningTags"
                                    :key="tag.value"
                                    class="rounded-full bg-red-500/20 px-3 py-1 text-[11px] font-black text-red-200 uppercase ring-1 ring-red-400/40"
                                >
                                    {{ tag.value }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== SOLUTION ===== -->
        <section id="hieu-qua" class="relative overflow-hidden py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="text-center">
                    <p
                        data-reveal
                        class="text-sm font-black tracking-[0.3em] text-emerald-600 uppercase"
                    >
                        {{ text('solutions', 'eyebrow') }}
                    </p>
                    <h2
                        data-reveal
                        class="mt-2 text-3xl font-black tracking-tight text-emerald-950 uppercase sm:text-4xl"
                    >
                        {{ text('solutions', 'heading') }}
                    </h2>
                    <p
                        data-reveal
                        class="mx-auto mt-4 max-w-2xl text-slate-600"
                    >
                        {{ text('solutions', 'description') }}
                    </p>
                </div>

                <div class="mt-12 grid gap-5 md:grid-cols-2">
                    <TiltCard
                        v-for="solution in solutions"
                        :key="solution.title"
                        :max="9"
                        :scale="1.03"
                        data-reveal
                    >
                        <div
                            class="flex h-full gap-4 rounded-3xl border border-emerald-900/10 bg-white p-5 shadow-lg"
                        >
                            <img
                                :src="solution.image"
                                :alt="solution.title"
                                class="size-24 shrink-0 rounded-2xl object-cover"
                            />
                            <div>
                                <h3
                                    class="text-base font-black text-emerald-900 uppercase"
                                >
                                    {{ solution.title }}
                                </h3>
                                <p class="mt-2 text-sm text-slate-600">
                                    {{ solution.description }}
                                </p>
                            </div>
                        </div>
                    </TiltCard>
                </div>

                <div
                    data-reveal
                    class="mt-10 overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-900 to-emerald-700 p-8 text-center text-white shadow-2xl"
                >
                    <p class="text-lg font-black uppercase">
                        {{ text('solutions', 'statsEyebrow') }}
                    </p>
                    <p
                        class="rootbio-counter text-5xl font-black text-lime-300 sm:text-6xl"
                        :data-target="number('solutions', 'statsValue', 3826534)"
                    >
                        0
                    </p>
                    <p class="mt-1 font-medium text-emerald-100">
                        {{ text('solutions', 'statsValueLabel') }}
                    </p>
                    <p
                        class="rootbio-counter mt-4 text-2xl font-black text-white"
                        :data-target="number('solutions', 'statsSecondaryValue', 99)"
                    >
                        0
                    </p>
                    <p class="text-emerald-100">
                        {{ text('solutions', 'statsSecondaryLabel') }}
                    </p>
                </div>
            </div>
        </section>

        <!-- ===== JAPAN / PRESS ===== -->
        <section class="relative overflow-hidden bg-lime-50 py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="grid items-center gap-10 lg:grid-cols-2">
                    <div data-reveal>
                        <h2
                            class="text-2xl leading-snug font-black text-emerald-950 uppercase sm:text-3xl"
                        >
                            {{ text('press', 'heading') }}
                        </h2>
                        <p class="mt-4 text-slate-600">
                            {{ text('press', 'description') }}
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <span
                                class="rounded-full bg-emerald-900 px-5 py-2 text-sm font-black text-white uppercase"
                            >
                                {{ text('press', 'badgeOne') }}
                            </span>
                            <span
                                class="rounded-full border-2 border-emerald-900 px-5 py-2 text-sm font-black text-emerald-900 uppercase"
                            >
                                {{ text('press', 'badgeTwo') }}
                            </span>
                        </div>
                    </div>

                    <div data-reveal>
                        <TiltCard :max="12" :scale="1.05">
                            <div
                                class="overflow-hidden rounded-3xl border-4 border-white bg-white shadow-2xl"
                            >
                                <img
                                    :src="text('press', 'image')"
                                    alt="Sản phẩm ROOTBIO được người Nhật đánh giá cao"
                                    class="aspect-[4/3] w-full object-cover"
                                />
                            </div>
                        </TiltCard>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== TESTIMONIALS ===== -->
        <section class="relative overflow-hidden py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-3xl font-black tracking-tight text-emerald-950 uppercase sm:text-4xl"
                >
                    {{ text('testimonials', 'heading') }}
                </h2>

                <div class="mt-10 grid gap-5 md:grid-cols-3">
                    <TiltCard
                        v-for="testimonial in testimonials"
                        :key="testimonial.author"
                        :max="9"
                        :scale="1.03"
                        data-reveal
                    >
                        <figure
                            class="flex h-full flex-col rounded-3xl border border-emerald-900/10 bg-white p-6 shadow-lg"
                        >
                            <img
                                :src="testimonial.image"
                                :alt="testimonial.author"
                                class="size-16 rounded-2xl object-cover"
                            />
                            <blockquote
                                class="mt-4 flex-1 text-sm text-slate-700 italic"
                            >
                                "{{ testimonial.quote }}"
                            </blockquote>
                            <figcaption
                                class="mt-4 border-t border-slate-100 pt-3 text-sm font-black text-emerald-900 uppercase"
                            >
                                {{ testimonial.author }}
                            </figcaption>
                        </figure>
                    </TiltCard>
                </div>
            </div>
        </section>

        <!-- ===== HIGHLIGHTS ===== -->
        <section
            class="relative overflow-hidden bg-emerald-950 py-16 text-white"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="text-center">
                    <h2
                        data-reveal
                        class="text-2xl font-black text-lime-300 uppercase sm:text-3xl"
                    >
                        {{ text('highlights', 'heading') }}
                    </h2>
                    <p
                        data-reveal
                        class="mt-3 text-2xl font-black tracking-tight uppercase sm:text-4xl"
                    >
                        {{ text('highlights', 'subheading') }}
                    </p>
                </div>

                <ul class="mt-10 grid gap-4 md:grid-cols-2">
                    <li
                        v-for="(item, index) in highlights"
                        :key="item.value"
                        data-reveal
                        class="flex items-start gap-3 rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur transition hover:border-lime-400/40 hover:bg-white/10"
                    >
                        <span
                            class="mt-0.5 flex size-7 shrink-0 items-center justify-center rounded-full bg-lime-400 text-sm font-black text-emerald-950"
                        >
                            {{ index + 1 }}
                        </span>
                        <span class="text-sm text-emerald-50">{{ item.value }}</span>
                    </li>
                </ul>
            </div>
        </section>

        <!-- ===== INGREDIENTS ===== -->
        <section class="relative overflow-hidden py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-3xl font-black tracking-tight text-emerald-950 uppercase sm:text-4xl"
                >
                    {{ text('ingredients', 'heading') }}
                </h2>

                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <TiltCard
                        v-for="ingredient in ingredients"
                        :key="ingredient.title"
                        :max="14"
                        :scale="1.07"
                        data-reveal
                    >
                        <div
                            class="flex h-full flex-col items-center rounded-3xl border border-emerald-900/10 bg-gradient-to-b from-white to-lime-50/60 p-6 text-center shadow-lg"
                        >
                            <img
                                :src="ingredient.image"
                                :alt="ingredient.title"
                                class="size-24 rounded-2xl object-cover shadow-md"
                            />
                            <h3
                                class="mt-4 text-base font-black text-emerald-900 uppercase"
                            >
                                {{ ingredient.title }}
                            </h3>
                            <p class="mt-2 text-sm text-slate-600">
                                {{ ingredient.description }}
                            </p>
                        </div>
                    </TiltCard>
                </div>

                <p
                    data-reveal
                    class="mt-10 text-center text-2xl font-black tracking-[0.2em] text-emerald-600 uppercase"
                >
                    {{ text('ingredients', 'footerText') }}
                </p>
            </div>
        </section>

        <!-- ===== CTA FORM ===== -->
        <section
            id="dang-ky"
            class="relative overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-800 to-lime-700 py-16"
        >
            <div class="rootbio-aurora absolute inset-0 opacity-50"></div>

            <div
                class="relative mx-auto grid max-w-7xl items-start gap-10 px-4 sm:px-6 lg:grid-cols-2"
            >
                <div data-reveal>
                    <h2
                        class="text-2xl leading-snug font-black text-white uppercase sm:text-3xl"
                    >
                        {{ text('cta', 'heading') }}
                    </h2>
                    <p class="mt-3 text-emerald-50">
                        {{ text('cta', 'description') }}
                    </p>

                    <ul class="mt-8 space-y-3">
                        <li
                            v-for="benefit in benefits"
                            :key="benefit.value"
                            class="flex items-center gap-3 rounded-2xl bg-white/10 p-4 backdrop-blur"
                        >
                            <span class="text-xl">✔</span>
                            <span
                                class="text-sm font-bold text-white uppercase"
                            >
                                {{ benefit.value }}
                            </span>
                        </li>
                    </ul>

                    <ul class="mt-8 space-y-3">
                        <li
                            v-for="commitment in commitments"
                            :key="commitment.value"
                            class="flex items-start gap-3 text-sm text-emerald-50"
                        >
                            <span class="mt-0.5 text-lime-300">◆</span>
                            <span>{{ commitment.value }}</span>
                        </li>
                    </ul>
                </div>

                <div data-reveal>
                    <LeadForm
                        variant="dark"
                        :title="text('cta', 'formTitle')"
                        :subtitle="text('cta', 'formSubtitle')"
                        :coupon-code="text('cta', 'couponCode', 'HT212')"
                        :plant-types="formPlantTypes"
                        :symptoms="formSymptoms"
                    />
                </div>
            </div>
        </section>

        <!-- ===== CERTIFICATES ===== -->
        <section class="relative overflow-hidden bg-white py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="grid items-center gap-10 lg:grid-cols-2">
                    <div data-reveal>
                        <TiltCard :max="12" :scale="1.05">
                            <div
                                class="overflow-hidden rounded-3xl border-4 border-lime-200 bg-white shadow-2xl"
                            >
                                <img
                                    :src="text('certificates', 'image')"
                                    alt="Chứng nhận và xét nghiệm phân bón ROOTBIO"
                                    class="w-full object-cover"
                                />
                            </div>
                        </TiltCard>
                    </div>

                    <div>
                        <h2
                            data-reveal
                            class="text-2xl leading-snug font-black text-emerald-950 uppercase sm:text-3xl"
                        >
                            {{ text('certificates', 'heading') }}
                        </h2>
                        <p data-reveal class="mt-4 text-slate-600">
                            {{ text('certificates', 'description') }}
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a
                                :href="text('certificates', 'primaryCtaHref', '#dang-ky')"
                                class="rounded-full bg-emerald-600 px-6 py-3 text-sm font-black text-white uppercase shadow-lg shadow-emerald-600/30 transition hover:-translate-y-0.5 hover:bg-emerald-700"
                            >
                                {{ text('certificates', 'primaryCtaLabel') }}
                            </a>
                            <a
                                :href="text('certificates', 'secondaryCtaHref', '#dang-ky')"
                                class="rounded-full border-2 border-emerald-900 px-6 py-3 text-sm font-black text-emerald-900 uppercase transition hover:bg-emerald-900 hover:text-white"
                            >
                                {{ text('certificates', 'secondaryCtaLabel') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== PROBLEM SELECTOR ===== -->
        <section class="relative overflow-hidden bg-amber-50 py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-3xl font-black tracking-tight text-emerald-950 uppercase sm:text-4xl"
                >
                    {{ text('problemSelector', 'heading') }}
                </h2>

                <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <TiltCard
                        v-for="tag in problemTags"
                        :key="tag.value"
                        :max="14"
                        :scale="1.08"
                        data-reveal
                    >
                        <div
                            class="flex h-24 items-center justify-center rounded-2xl border-2 border-amber-300 bg-white text-lg font-black text-amber-700 uppercase shadow-md"
                        >
                            {{ tag.value }}
                        </div>
                    </TiltCard>
                </div>
            </div>
        </section>

        <!-- ===== REVIEWS ===== -->
        <section class="relative overflow-hidden py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-3xl font-black tracking-tight text-emerald-950 uppercase sm:text-4xl"
                >
                    {{ text('reviews', 'heading') }}
                </h2>

                <div class="mt-10 grid gap-8 lg:grid-cols-3">
                    <div
                        data-reveal
                        class="rounded-3xl border border-emerald-900/10 bg-white p-6 shadow-lg"
                    >
                        <h3
                            class="text-center text-sm font-black text-slate-600 uppercase"
                        >
                            Đánh giá trung bình
                        </h3>
                        <p
                            class="mt-3 text-center text-5xl font-black text-emerald-600"
                        >
                            {{ number('reviews', 'averageRating', 5) }}
                        </p>
                        <p class="text-center text-sm text-slate-500">
                            {{ number('reviews', 'averageRating', 5) }}/5
                        </p>

                        <div class="mt-6 space-y-2">
                            <div
                                v-for="bar in ratingBars"
                                :key="bar.stars"
                                class="flex items-center gap-2"
                            >
                                <span class="w-3 text-sm text-slate-500">
                                    {{ bar.stars }}
                                </span>
                                <div
                                    class="h-2 flex-1 overflow-hidden rounded-full bg-slate-200"
                                >
                                    <div
                                        class="h-full rounded-full bg-emerald-500"
                                        :style="{ width: `${bar.percent ?? 0}%` }"
                                    ></div>
                                </div>
                                <span
                                    class="w-10 text-right text-xs text-slate-500"
                                >
                                    {{ bar.percent ?? 0 }}%
                                </span>
                            </div>
                        </div>

                        <p class="mt-4 text-center text-xs text-slate-400">
                            {{ text('reviews', 'totalReviews') }}
                        </p>
                    </div>

                    <div class="space-y-4 lg:col-span-2">
                        <div
                            v-for="review in reviews"
                            :key="review.name"
                            data-reveal
                            class="rounded-2xl border border-emerald-900/10 bg-white p-5 shadow-sm"
                        >
                            <div class="flex items-center justify-between">
                                <p class="font-black text-emerald-900">
                                    {{ review.name }}
                                </p>
                                <p class="text-xs text-slate-400">
                                    {{ review.time }}
                                </p>
                            </div>
                            <p class="mt-2 text-sm text-slate-600">
                                {{ review.content }}
                            </p>
                            <p
                                class="mt-2 text-xs font-semibold text-slate-400"
                            >
                                Thích - Bình luận
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== FINAL CTA ===== -->
        <section
            class="relative overflow-hidden bg-emerald-950 py-16 text-center text-white"
        >
            <div class="rootbio-aurora absolute inset-0 opacity-60"></div>

            <div class="relative mx-auto max-w-3xl px-4 sm:px-6">
                <h2
                    data-reveal
                    class="text-2xl leading-snug font-black uppercase sm:text-3xl"
                >
                    {{ text('finalCta', 'heading') }}
                </h2>

                <div
                    data-reveal
                    class="mt-8 rounded-3xl bg-white/10 p-6 backdrop-blur"
                >
                    <p class="text-sm font-black text-lime-300 uppercase">
                        {{ text('finalCta', 'couponLabel') }}
                    </p>
                    <p
                        class="rootbio-pulse mt-2 text-4xl font-black tracking-widest text-white"
                    >
                        {{ text('finalCta', 'couponCode', 'HT212') }}
                    </p>
                    <p class="mt-3 text-sm text-emerald-100">
                        Đang có
                        <strong>{{ number('finalCta', 'peopleCount', 99) }}</strong>
                        người đăng ký nhận ưu đãi
                    </p>
                    <p class="mt-1 text-sm font-bold text-lime-300 uppercase">
                        {{ text('finalCta', 'urgencyText') }}
                    </p>
                </div>

                <a
                    :href="text('finalCta', 'buttonHref', '#dang-ky')"
                    class="mt-8 inline-block rounded-full bg-lime-400 px-10 py-4 text-lg font-black tracking-wide text-emerald-950 uppercase shadow-2xl shadow-lime-500/30 transition hover:-translate-y-1 hover:bg-lime-300"
                >
                    {{ text('finalCta', 'buttonLabel', 'Đăng ký ngay') }}
                </a>
            </div>
        </section>

        <!-- ===== FOOTER ===== -->
        <footer class="bg-emerald-950 pt-12 pb-28 text-emerald-100">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="grid gap-8 md:grid-cols-3">
                    <div>
                        <p class="text-lg font-black text-white uppercase">
                            {{ text('footer', 'brandName', 'ROOTBIO') }}
                        </p>
                        <p class="mt-3 text-sm">
                            {{ text('footer', 'companyName') }}<br />
                            {{ text('footer', 'address') }}<br />
                            HOTLINE:
                            <a
                                :href="text('footer', 'hotlineHref')"
                                class="hover:underline"
                            >
                                {{ text('footer', 'hotline') }}
                            </a>
                        </p>
                    </div>

                    <div>
                        <p class="font-black text-white uppercase">
                            {{ text('footer', 'plantListHeading') }}
                        </p>
                        <ul class="mt-3 grid grid-cols-2 gap-2 text-sm">
                            <li v-for="plant in footerPlantTypes" :key="plant.value">
                                {{ plant.value }}
                            </li>
                        </ul>
                    </div>

                    <div>
                        <p class="font-black text-white uppercase">
                            {{ text('footer', 'infoHeading') }}
                        </p>
                        <ul class="mt-3 space-y-2 text-sm">
                            <li v-for="link in infoLinks" :key="link.value">
                                ▶️ {{ link.value }}
                            </li>
                        </ul>
                    </div>
                </div>

                <p
                    class="mt-10 border-t border-white/10 pt-6 text-center text-xs text-emerald-300/70"
                >
                    {{ text('footer', 'copyright') }}
                </p>
            </div>
        </footer>

        <!-- ===== STICKY MOBILE CTA ===== -->
        <div
            class="fixed inset-x-0 bottom-0 z-50 flex items-center gap-2 border-t border-emerald-900/20 bg-white/95 px-3 py-2.5 backdrop-blur lg:hidden"
        >
            <a
                :href="text('stickyCta', 'callHref', 'tel:0973426704')"
                class="flex-1 rounded-full border-2 border-emerald-700 py-2.5 text-center text-xs font-black text-emerald-800 uppercase"
            >
                {{ text('stickyCta', 'callLabel', 'Gọi ngay') }}
            </a>
            <a
                :href="text('stickyCta', 'registerHref', '#dang-ky')"
                class="flex-1 rounded-full bg-emerald-600 py-2.5 text-center text-xs font-black text-white uppercase shadow-lg shadow-emerald-600/30"
            >
                {{ text('stickyCta', 'registerLabel') }}
            </a>
        </div>
    </div>
</template>
