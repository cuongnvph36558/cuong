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
import type { Feedback } from '@/types/feedback';

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

    <div class="rootbio-page flex min-h-screen flex-col bg-white text-slate-800">
        <!-- ===== HERO ===== -->
        <header
            class="rootbio-hero relative order-1 overflow-hidden bg-gradient-to-b from-emerald-50 via-white to-white"
        >
            <div class="rootbio-aurora absolute inset-0 opacity-60"></div>

            <nav
                class="relative z-20 mx-auto flex max-w-6xl items-center justify-between gap-3 px-4 py-3 sm:px-6 sm:py-4"
            >
                <div class="flex min-w-0 items-center gap-2.5">
                    <div
                        class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-600 to-lime-500 text-base font-black text-white shadow-md shadow-emerald-600/25 sm:size-11 sm:text-lg"
                    >
                        {{ text('hero', 'brandLetter', 'R') }}
                    </div>
                    <div class="min-w-0 leading-tight">
                        <p
                            class="truncate text-base font-black tracking-wide text-emerald-900 uppercase sm:text-lg"
                        >
                            {{ text('hero', 'brandName', 'ROOTBIO') }}
                        </p>
                        <p
                            class="truncate text-[11px] font-medium text-emerald-700/80"
                        >
                            {{ text('hero', 'brandTagline', 'Phân bón sinh học') }}
                        </p>
                    </div>
                </div>

                <div class="flex shrink-0 items-center gap-2">
                    <a
                        :href="`tel:${text('hero', 'navPhone').replace(/\D/g, '')}`"
                        class="hidden rounded-full border border-emerald-700/30 bg-white px-4 py-2 text-sm font-bold text-emerald-800 transition hover:border-emerald-700 hover:bg-emerald-50 sm:inline-flex"
                    >
                        {{ text('hero', 'navPhone') }}
                    </a>
                    <a
                        :href="text('hero', 'primaryCtaHref', '#dang-ky')"
                        class="rounded-full bg-emerald-600 px-4 py-2.5 text-sm font-black text-white uppercase shadow-md shadow-emerald-600/25 transition hover:bg-emerald-700 sm:px-5"
                    >
                        {{ text('hero', 'navCtaLabel', 'Đăng ký ngay') }}
                    </a>
                </div>
            </nav>

            <div
                class="relative z-10 mx-auto grid max-w-6xl items-center gap-8 px-4 pt-6 pb-10 sm:px-6 sm:pt-8 sm:pb-14 lg:grid-cols-2 lg:gap-12"
            >
                <div>
                    <p
                        data-reveal
                        class="mb-3 inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3.5 py-1.5 text-[11px] font-black tracking-wide text-emerald-800 uppercase ring-1 ring-emerald-600/15"
                    >
                        <span class="relative flex size-2">
                            <span
                                class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-500 opacity-70"
                            ></span>
                            <span
                                class="relative inline-flex size-2 rounded-full bg-emerald-600"
                            ></span>
                        </span>
                        {{ text('hero', 'badgeText') }}
                    </p>

                    <h1
                        data-reveal
                        class="text-[2rem] leading-[1.1] font-black tracking-tight text-emerald-950 uppercase sm:text-5xl lg:text-6xl"
                    >
                        {{ text('hero', 'titlePrefix', 'Phân bón') }}
                        <span class="text-emerald-600">
                            {{ text('hero', 'titleAccent', 'ROOTBIO') }}
                        </span>
                        <br />
                        <span
                            class="mt-1 block text-base font-bold text-emerald-800 sm:text-2xl"
                        >
                            {{ text('hero', 'titleSubtitle') }}
                        </span>
                    </h1>

                    <p
                        data-reveal
                        class="mt-4 max-w-xl text-[15px] leading-relaxed text-slate-600 sm:text-base"
                    >
                        {{ text('hero', 'description') }}
                    </p>

                    <div data-reveal class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <a
                            :href="text('hero', 'primaryCtaHref', '#dang-ky')"
                            class="rounded-full bg-emerald-600 px-7 py-3.5 text-center text-sm font-black tracking-wide text-white uppercase shadow-lg shadow-emerald-600/25 transition hover:-translate-y-0.5 hover:bg-emerald-700"
                        >
                            {{ text('hero', 'primaryCtaLabel', 'Nhận ưu đãi') }}
                        </a>
                        <a
                            :href="text('hero', 'secondaryCtaHref', '#hieu-qua')"
                            class="rounded-full border-2 border-emerald-700/40 px-7 py-3.5 text-center text-sm font-bold tracking-wide text-emerald-800 uppercase transition hover:border-emerald-700 hover:bg-emerald-50"
                        >
                            {{ text('hero', 'secondaryCtaLabel', 'Xem hiệu quả') }}
                        </a>
                    </div>

                    <div
                        data-reveal
                        class="mt-7 grid grid-cols-2 gap-2 sm:grid-cols-4 sm:gap-3"
                    >
                        <div
                            v-for="feature in features"
                            :key="feature.value"
                            class="rounded-xl border border-emerald-900/10 bg-white px-2.5 py-2.5 text-center text-[11px] font-bold text-emerald-900 uppercase shadow-sm"
                        >
                            {{ feature.value }}
                        </div>
                    </div>
                </div>

                <div class="relative" data-reveal>
                    <TiltCard :max="12" :scale="1.04">
                        <div
                            class="relative aspect-square overflow-hidden rounded-[1.75rem] border border-emerald-900/10 bg-white shadow-xl shadow-emerald-900/10"
                        >
                            <img
                                :src="text('hero', 'productImage')"
                                alt="Phân bón ROOTBIO"
                                class="size-full object-cover"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-emerald-950/45 via-transparent to-transparent"
                            ></div>
                            <div
                                class="absolute right-4 bottom-4 left-4 rounded-2xl bg-white/95 p-3.5 shadow-lg backdrop-blur sm:right-6 sm:bottom-6 sm:left-6 sm:p-4"
                            >
                                <p
                                    class="text-sm font-black text-emerald-700 uppercase"
                                >
                                    {{ text('hero', 'productBadgeTitle') }}
                                </p>
                                <p class="mt-1 text-xs text-slate-600">
                                    {{ text('hero', 'productBadgeText') }}
                                </p>
                            </div>
                        </div>
                    </TiltCard>

                    <div
                        class="absolute -top-3 -left-2 flex animate-bounce items-center gap-2 rounded-2xl bg-lime-400 px-3.5 py-2.5 text-left shadow-lg shadow-lime-500/30 sm:top-8 sm:-left-4 sm:px-4 sm:py-3"
                    >
                        <p class="text-xl font-black text-emerald-950 sm:text-2xl">
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

        <!-- ===== PROBLEMS ===== -->
        <section
            class="relative order-2 overflow-hidden bg-white py-12 sm:py-16"
        >
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="text-center">
                    <h2
                        data-reveal
                        class="text-2xl font-black tracking-tight text-emerald-950 uppercase sm:text-4xl"
                    >
                        {{ text('problems', 'heading') }}
                    </h2>
                    <div
                        class="mx-auto mt-3 h-1 w-16 rounded-full bg-emerald-500"
                    ></div>
                </div>

                <div class="mt-8 grid items-center gap-8 lg:grid-cols-2">
                    <div class="relative order-1 lg:order-1">
                        <TiltCard :max="10" :scale="1.03">
                            <div
                                class="relative aspect-[4/3] overflow-hidden rounded-3xl border border-emerald-900/10 bg-emerald-50 shadow-xl shadow-emerald-900/10"
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
                                        ? 'w-8 bg-emerald-500'
                                        : 'w-2 bg-emerald-200 hover:bg-emerald-400'
                                "
                                :aria-label="problem.title"
                                @click="activeSlide = index"
                            ></button>
                        </div>
                    </div>

                    <div class="order-2 space-y-3 lg:order-2">
                        <div
                            v-for="problem in problems"
                            :key="problem.title"
                            data-reveal
                            class="group rounded-2xl border border-emerald-900/10 bg-emerald-50/60 p-4 transition hover:border-amber-400 hover:bg-amber-50 sm:p-5"
                        >
                            <h3
                                class="flex items-start gap-2 text-base font-black text-emerald-900 uppercase sm:text-lg"
                            >
                                <span
                                    class="text-xl leading-none text-amber-500 transition-transform duration-300 group-hover:scale-125"
                                >
                                    ⚠
                                </span>
                                {{ problem.title }}
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                                {{ problem.description }}
                            </p>
                        </div>

                        <div
                            data-reveal
                            class="rounded-2xl border border-amber-300 bg-amber-50 p-5"
                        >
                            <h3
                                class="text-lg font-black text-amber-700 uppercase sm:text-xl"
                            >
                                {{ text('problems', 'warningTitle', 'Cảnh báo!') }}
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-amber-900/80">
                                {{ text('problems', 'warningText') }}
                            </p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span
                                    v-for="tag in warningTags"
                                    :key="tag.value"
                                    class="rounded-full border border-amber-300 bg-white px-3 py-1 text-[11px] font-black text-amber-700 uppercase"
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
        <section
            id="hieu-qua"
            class="relative order-3 overflow-hidden bg-emerald-50/70 py-12 sm:py-16"
        >
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="text-center">
                    <p
                        data-reveal
                        class="text-xs font-black tracking-[0.25em] text-emerald-600 uppercase"
                    >
                        {{ text('solutions', 'eyebrow') }}
                    </p>
                    <h2
                        data-reveal
                        class="mt-2 text-2xl font-black tracking-tight text-emerald-950 uppercase sm:text-4xl"
                    >
                        {{ text('solutions', 'heading') }}
                    </h2>
                    <p
                        data-reveal
                        class="mx-auto mt-4 max-w-2xl text-[15px] leading-relaxed text-slate-600"
                    >
                        {{ text('solutions', 'description') }}
                    </p>
                </div>

                <div class="mt-8 grid gap-4 sm:grid-cols-2 sm:gap-5">
                    <TiltCard
                        v-for="solution in solutions"
                        :key="solution.title"
                        :max="8"
                        :scale="1.02"
                        data-reveal
                    >
                        <div
                            class="flex h-full gap-4 rounded-3xl border border-emerald-900/10 bg-white p-4 shadow-sm transition hover:shadow-md sm:p-5"
                        >
                            <img
                                :src="solution.image"
                                :alt="solution.title"
                                class="size-20 shrink-0 rounded-2xl object-cover sm:size-24"
                            />
                            <div>
                                <h3
                                    class="text-sm font-black text-emerald-900 uppercase sm:text-base"
                                >
                                    {{ solution.title }}
                                </h3>
                                <p
                                    class="mt-2 text-sm leading-relaxed text-slate-600"
                                >
                                    {{ solution.description }}
                                </p>
                            </div>
                        </div>
                    </TiltCard>
                </div>

                <div
                    data-reveal
                    class="mt-8 overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-700 to-emerald-500 p-6 text-center text-white shadow-xl shadow-emerald-700/20 sm:p-8"
                >
                    <p class="text-sm font-black uppercase sm:text-lg">
                        {{ text('solutions', 'statsEyebrow') }}
                    </p>
                    <p
                        class="rootbio-counter text-4xl font-black text-lime-200 sm:text-6xl"
                        :data-target="number('solutions', 'statsValue', 3826534)"
                    >
                        0
                    </p>
                    <p class="mt-1 font-medium text-emerald-50">
                        {{ text('solutions', 'statsValueLabel') }}
                    </p>
                    <p
                        class="rootbio-counter mt-4 text-2xl font-black text-white"
                        :data-target="number('solutions', 'statsSecondaryValue', 99)"
                    >
                        0
                    </p>
                    <p class="text-emerald-50">
                        {{ text('solutions', 'statsSecondaryLabel') }}
                    </p>
                </div>
            </div>
        </section>

        <!-- ===== CTA FORM ===== -->
        <section
            id="dang-ky"
            class="relative order-4 overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-lime-50 py-12 sm:py-16"
        >
            <div class="mx-auto grid max-w-6xl items-start gap-8 px-4 sm:px-6 lg:grid-cols-2 lg:gap-12">
                <div data-reveal>
                    <h2
                        class="text-2xl leading-snug font-black text-emerald-950 uppercase sm:text-3xl"
                    >
                        {{ text('cta', 'heading') }}
                    </h2>
                    <p class="mt-3 text-[15px] leading-relaxed text-slate-600">
                        {{ text('cta', 'description') }}
                    </p>

                    <ul class="mt-6 grid gap-2.5 sm:grid-cols-2 lg:grid-cols-1">
                        <li
                            v-for="benefit in benefits"
                            :key="benefit.value"
                            class="flex items-center gap-3 rounded-2xl border border-emerald-900/10 bg-white p-3.5 shadow-sm"
                        >
                            <span
                                class="flex size-6 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-sm text-emerald-700"
                            >
                                ✔
                            </span>
                            <span class="text-sm font-bold text-emerald-900">
                                {{ benefit.value }}
                            </span>
                        </li>
                    </ul>

                    <ul class="mt-6 space-y-2.5">
                        <li
                            v-for="commitment in commitments"
                            :key="commitment.value"
                            class="flex items-start gap-3 text-sm leading-relaxed text-slate-600"
                        >
                            <span class="mt-1 text-emerald-500">◆</span>
                            <span>{{ commitment.value }}</span>
                        </li>
                    </ul>
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

        <!-- ===== PLANT TYPES ===== -->
        <section
            class="relative order-5 overflow-hidden bg-white py-12 sm:py-16"
        >
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-2xl font-black tracking-tight text-emerald-950 uppercase sm:text-4xl"
                >
                    {{ text('plantTypes', 'heading') }}
                </h2>

                <div
                    class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 lg:grid-cols-6"
                >
                    <TiltCard
                        v-for="plant in plantTypes"
                        :key="plant.value"
                        :max="8"
                        :scale="1.06"
                        data-reveal
                    >
                        <div
                            class="flex h-24 items-center justify-center rounded-2xl border border-emerald-900/10 bg-gradient-to-br from-emerald-50 to-lime-100 p-3 text-center shadow-sm sm:h-28"
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

        <!-- ===== TESTIMONIALS ===== -->
        <section
            class="relative order-6 overflow-hidden bg-emerald-50/70 py-12 sm:py-16"
        >
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-2xl font-black tracking-tight text-emerald-950 uppercase sm:text-4xl"
                >
                    {{ text('testimonials', 'heading') }}
                </h2>

                <div class="mt-8 grid gap-4 sm:grid-cols-2 sm:gap-5 md:grid-cols-3">
                    <TiltCard
                        v-for="testimonial in testimonials"
                        :key="testimonial.author"
                        :max="8"
                        :scale="1.02"
                        data-reveal
                    >
                        <figure
                            class="flex h-full flex-col rounded-3xl border border-emerald-900/10 bg-white p-5 shadow-sm sm:p-6"
                        >
                            <img
                                :src="testimonial.image"
                                :alt="testimonial.author"
                                class="size-14 rounded-2xl object-cover"
                            />
                            <blockquote
                                class="mt-4 flex-1 text-sm leading-relaxed text-slate-700"
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
            class="relative order-7 overflow-hidden bg-white py-12 sm:py-16"
        >
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="text-center">
                    <h2
                        data-reveal
                        class="text-xl font-black text-emerald-700 uppercase sm:text-3xl"
                    >
                        {{ text('highlights', 'heading') }}
                    </h2>
                    <p
                        data-reveal
                        class="mt-3 text-lg font-black tracking-tight text-emerald-950 uppercase sm:text-4xl"
                    >
                        {{ text('highlights', 'subheading') }}
                    </p>
                </div>

                <ul class="mt-8 grid gap-3 md:grid-cols-2 md:gap-4">
                    <li
                        v-for="(item, index) in highlights"
                        :key="item.value"
                        data-reveal
                        class="flex items-start gap-3 rounded-2xl border border-emerald-900/10 bg-emerald-50/60 p-4 transition hover:border-emerald-400 hover:bg-emerald-50 sm:p-5"
                    >
                        <span
                            class="mt-0.5 flex size-7 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-sm font-black text-white"
                        >
                            {{ index + 1 }}
                        </span>
                        <span class="text-sm leading-relaxed text-slate-700">{{
                            item.value
                        }}</span>
                    </li>
                </ul>
            </div>
        </section>

        <!-- ===== INGREDIENTS ===== -->
        <section
            class="relative order-8 overflow-hidden bg-emerald-50/70 py-12 sm:py-16"
        >
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-2xl font-black tracking-tight text-emerald-950 uppercase sm:text-4xl"
                >
                    {{ text('ingredients', 'heading') }}
                </h2>

                <div class="mt-8 grid gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4">
                    <TiltCard
                        v-for="ingredient in ingredients"
                        :key="ingredient.title"
                        :max="10"
                        :scale="1.05"
                        data-reveal
                    >
                        <div
                            class="flex h-full flex-col items-center rounded-3xl border border-emerald-900/10 bg-white p-5 text-center shadow-sm sm:p-6"
                        >
                            <img
                                :src="ingredient.image"
                                :alt="ingredient.title"
                                class="size-20 rounded-2xl object-cover shadow-sm sm:size-24"
                            />
                            <h3
                                class="mt-4 text-sm font-black text-emerald-900 uppercase sm:text-base"
                            >
                                {{ ingredient.title }}
                            </h3>
                            <p
                                class="mt-2 text-sm leading-relaxed text-slate-600"
                            >
                                {{ ingredient.description }}
                            </p>
                        </div>
                    </TiltCard>
                </div>

                <p
                    data-reveal
                    class="mt-8 text-center text-lg font-black tracking-[0.15em] text-emerald-700 uppercase sm:text-2xl"
                >
                    {{ text('ingredients', 'footerText') }}
                </p>
            </div>
        </section>

        <!-- ===== PRESS / JAPAN ===== -->
        <section
            class="relative order-9 overflow-hidden bg-white py-12 sm:py-16"
        >
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="grid items-center gap-8 lg:grid-cols-2 lg:gap-12">
                    <div data-reveal>
                        <h2
                            class="text-xl leading-snug font-black text-emerald-950 uppercase sm:text-3xl"
                        >
                            {{ text('press', 'heading') }}
                        </h2>
                        <p
                            class="mt-4 text-[15px] leading-relaxed text-slate-600"
                        >
                            {{ text('press', 'description') }}
                        </p>

                        <div class="mt-5 flex flex-wrap gap-2.5">
                            <span
                                class="rounded-full bg-emerald-700 px-4 py-2 text-xs font-black text-white uppercase sm:text-sm"
                            >
                                {{ text('press', 'badgeOne') }}
                            </span>
                            <span
                                class="rounded-full border-2 border-emerald-700 px-4 py-2 text-xs font-black text-emerald-800 uppercase sm:text-sm"
                            >
                                {{ text('press', 'badgeTwo') }}
                            </span>
                        </div>
                    </div>

                    <div data-reveal>
                        <TiltCard :max="10" :scale="1.04">
                            <div
                                class="overflow-hidden rounded-3xl border border-emerald-900/10 bg-white shadow-xl shadow-emerald-900/10"
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

        <!-- ===== CERTIFICATES ===== -->
        <section
            class="relative order-10 overflow-hidden bg-emerald-50/70 py-12 sm:py-16"
        >
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="grid items-center gap-8 lg:grid-cols-2 lg:gap-12">
                    <div data-reveal>
                        <TiltCard :max="10" :scale="1.04">
                            <div
                                class="overflow-hidden rounded-3xl border border-emerald-900/10 bg-white shadow-xl shadow-emerald-900/10"
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
                            class="text-xl leading-snug font-black text-emerald-950 uppercase sm:text-3xl"
                        >
                            {{ text('certificates', 'heading') }}
                        </h2>
                        <p
                            data-reveal
                            class="mt-4 text-[15px] leading-relaxed text-slate-600"
                        >
                            {{ text('certificates', 'description') }}
                        </p>

                        <div class="mt-5 flex flex-col gap-3 sm:flex-row">
                            <a
                                :href="text('certificates', 'primaryCtaHref', '#dang-ky')"
                                class="rounded-full bg-emerald-600 px-6 py-3 text-center text-sm font-black text-white uppercase shadow-md shadow-emerald-600/25 transition hover:-translate-y-0.5 hover:bg-emerald-700"
                            >
                                {{ text('certificates', 'primaryCtaLabel') }}
                            </a>
                            <a
                                :href="text('certificates', 'secondaryCtaHref', '#dang-ky')"
                                class="rounded-full border-2 border-emerald-800 px-6 py-3 text-center text-sm font-black text-emerald-800 uppercase transition hover:bg-emerald-800 hover:text-white"
                            >
                                {{ text('certificates', 'secondaryCtaLabel') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== PROBLEM SELECTOR ===== -->
        <section
            class="relative order-11 overflow-hidden bg-white py-12 sm:py-16"
        >
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-2xl font-black tracking-tight text-emerald-950 uppercase sm:text-4xl"
                >
                    {{ text('problemSelector', 'heading') }}
                </h2>

                <div class="mt-8 grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-3">
                    <TiltCard
                        v-for="tag in problemTags"
                        :key="tag.value"
                        :max="10"
                        :scale="1.05"
                        data-reveal
                    >
                        <div
                            class="flex h-20 items-center justify-center rounded-2xl border-2 border-amber-300 bg-amber-50 px-2 text-center text-sm font-black text-amber-700 uppercase shadow-sm sm:h-24 sm:text-lg"
                        >
                            {{ tag.value }}
                        </div>
                    </TiltCard>
                </div>
            </div>
        </section>

        <!-- ===== REVIEWS ===== -->
        <section
            class="relative order-12 overflow-hidden bg-emerald-50/70 py-12 sm:py-16"
        >
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-2xl font-black tracking-tight text-emerald-950 uppercase sm:text-4xl"
                >
                    {{ text('reviews', 'heading') }}
                </h2>

                <div class="mt-8 grid gap-6 lg:grid-cols-3 lg:gap-8">
                    <div
                        data-reveal
                        class="rounded-3xl border border-emerald-900/10 bg-white p-5 shadow-sm sm:p-6"
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

                    <div class="space-y-3 lg:col-span-2">
                        <div
                            v-for="review in reviews"
                            :key="review.name"
                            data-reveal
                            class="rounded-2xl border border-emerald-900/10 bg-white p-4 shadow-sm sm:p-5"
                        >
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-black text-emerald-900">
                                    {{ review.name }}
                                </p>
                                <p class="shrink-0 text-xs text-slate-400">
                                    {{ review.time }}
                                </p>
                            </div>
                            <p
                                class="mt-2 text-sm leading-relaxed text-slate-600"
                            >
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

        <!-- ===== CUSTOMER FEEDBACK ===== -->
        <section
            v-if="props.feedbacks.length"
            class="relative order-[13] overflow-hidden bg-lime-50 py-14 sm:py-16"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <h2
                    data-reveal
                    class="text-center text-2xl font-black tracking-tight text-emerald-950 uppercase sm:text-3xl"
                >
                    Hình ảnh vườn cây của bà con
                </h2>
                <p
                    data-reveal
                    class="mx-auto mt-3 max-w-2xl text-center text-sm text-slate-600 sm:text-base"
                >
                    Bà con tự tay chụp và gửi hình vườn cây sau khi dùng phân bón
                    ROOTBIO. Mọi hình ảnh đều được chia sẻ thật từ khách hàng.
                </p>

                <div class="mt-10 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    <article
                        v-for="feedback in props.feedbacks"
                        :key="feedback.id"
                        data-reveal
                        class="flex h-full flex-col rounded-2xl border border-emerald-900/10 bg-white p-5 shadow-sm"
                    >
                        <div class="flex items-center gap-3">
                            <img
                                v-if="feedback.image"
                                :src="feedback.image"
                                :alt="feedback.name"
                                class="size-12 shrink-0 rounded-xl object-cover"
                            />
                            <div
                                v-else
                                class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-base font-black text-emerald-900"
                            >
                                {{ feedback.name.charAt(0) }}
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="truncate font-black text-emerald-900">
                                    {{ feedback.name }}
                                </p>
                                <p
                                    v-if="feedback.role"
                                    class="truncate text-xs text-slate-500"
                                >
                                    {{ feedback.role }}
                                </p>
                            </div>

                            <div
                                class="flex shrink-0 gap-0.5 text-amber-500"
                            >
                                <span
                                    v-for="star in 5"
                                    :key="star"
                                    class="text-xs"
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

                        <p class="mt-4 flex-1 text-sm leading-relaxed text-slate-600 italic">
                            "{{ feedback.content }}"
                        </p>

                        <div
                            v-if="feedback.photos?.length"
                            class="mt-4 grid grid-cols-3 gap-2"
                        >
                            <img
                                v-for="(photo, index) in feedback.photos"
                                :key="index"
                                :src="photo"
                                :alt="`Ảnh cây trồng của ${feedback.name}`"
                                class="aspect-square w-full rounded-xl object-cover"
                                loading="lazy"
                            />
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- ===== FINAL CTA ===== -->
        <section
            class="relative order-[14] overflow-hidden bg-gradient-to-br from-emerald-700 via-emerald-600 to-lime-600 py-12 text-center text-white sm:py-16"
        >
            <div class="rootbio-cta-aurora absolute inset-0 opacity-70"></div>

            <div class="relative mx-auto max-w-3xl px-4 sm:px-6">
                <h2
                    data-reveal
                    class="text-xl leading-snug font-black uppercase sm:text-3xl"
                >
                    {{ text('finalCta', 'heading') }}
                </h2>

                <div
                    data-reveal
                    class="mt-6 rounded-3xl bg-white/15 p-5 ring-1 ring-white/25 backdrop-blur sm:p-6"
                >
                    <p class="text-xs font-black text-lime-100 uppercase">
                        {{ text('finalCta', 'couponLabel') }}
                    </p>
                    <p
                        class="rootbio-pulse mt-2 text-3xl font-black tracking-widest text-white sm:text-4xl"
                    >
                        {{ text('finalCta', 'couponCode', 'HT212') }}
                    </p>
                    <p class="mt-3 text-sm text-emerald-50">
                        Đang có
                        <strong>{{ number('finalCta', 'peopleCount', 99) }}</strong>
                        người đăng ký nhận ưu đãi
                    </p>
                    <p class="mt-1 text-sm font-bold text-lime-100 uppercase">
                        {{ text('finalCta', 'urgencyText') }}
                    </p>
                </div>

                <a
                    :href="text('finalCta', 'buttonHref', '#dang-ky')"
                    class="mt-6 inline-block w-full rounded-full bg-lime-400 px-8 py-4 text-base font-black tracking-wide text-emerald-950 uppercase shadow-xl shadow-emerald-900/20 transition hover:-translate-y-1 hover:bg-lime-300 sm:w-auto sm:px-10 sm:text-lg"
                >
                    {{ text('finalCta', 'buttonLabel', 'Đăng ký ngay') }}
                </a>
            </div>
        </section>

        <!-- ===== FOOTER ===== -->
        <footer
            class="rootbio-footer order-[15] border-t border-emerald-900/10 bg-emerald-50/60 pt-10 pb-28 text-slate-600 sm:pb-12"
        >
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="grid gap-8 md:grid-cols-3">
                    <div>
                        <p class="text-lg font-black text-emerald-900 uppercase">
                            {{ text('footer', 'brandName', 'ROOTBIO') }}
                        </p>
                        <p class="mt-3 text-sm leading-relaxed">
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
                        <p class="font-black text-emerald-900 uppercase">
                            {{ text('footer', 'plantListHeading') }}
                        </p>
                        <ul class="mt-3 grid grid-cols-2 gap-2 text-sm">
                            <li v-for="plant in footerPlantTypes" :key="plant.value">
                                {{ plant.value }}
                            </li>
                        </ul>
                    </div>

                    <div>
                        <p class="font-black text-emerald-900 uppercase">
                            {{ text('footer', 'infoHeading') }}
                        </p>
                        <ul class="mt-3 space-y-2 text-sm">
                            <li v-for="link in infoLinks" :key="link.value">
                                <span class="mr-1 text-emerald-500">▶</span>
                                {{ link.value }}
                            </li>
                        </ul>
                    </div>
                </div>

                <p
                    class="mt-8 border-t border-emerald-900/10 pt-6 text-center text-xs text-slate-500"
                >
                    {{ text('footer', 'copyright') }}
                </p>
            </div>
        </footer>

        <!-- ===== STICKY MOBILE CTA ===== -->
        <div
            class="fixed inset-x-0 bottom-0 z-50 flex items-center gap-2 border-t border-emerald-900/15 bg-white/95 px-3 pt-2.5 pb-[calc(env(safe-area-inset-bottom)+0.625rem)] backdrop-blur lg:hidden"
        >
            <a
                :href="text('stickyCta', 'callHref', 'tel:0973426704')"
                class="flex-1 rounded-full border-2 border-emerald-700 py-2.5 text-center text-xs font-black text-emerald-800 uppercase"
            >
                {{ text('stickyCta', 'callLabel', 'Gọi ngay') }}
            </a>
            <a
                :href="text('stickyCta', 'registerHref', '#dang-ky')"
                class="flex-1 rounded-full bg-emerald-600 py-2.5 text-center text-xs font-black text-white uppercase shadow-md shadow-emerald-600/30"
            >
                {{ text('stickyCta', 'registerLabel') }}
            </a>
        </div>
    </div>
</template>
