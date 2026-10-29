<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { recent as recentRegistrations } from '@/routes/registrations';

type Registration = {
    id: number;
    name: string;
    region: string;
    package: string;
    time: string;
};

type Props = {
    /** Interval between two notifications, in milliseconds. */
    interval?: number;
    /** How long a notification stays visible, in milliseconds. */
    visibleFor?: number;
    /** Delay before the very first notification, in milliseconds. */
    initialDelay?: number;
    /** Whether the notifications are enabled. */
    enabled?: boolean;
};

const props = withDefaults(defineProps<Props>(), {
    interval: 10_000,
    visibleFor: 4_000,
    initialDelay: 4_000,
    enabled: true,
});

const registrations = ref<Registration[]>([]);
const currentIndex = ref(0);
const isVisible = ref(false);
const current = ref<Registration | null>(null);

let cycleTimer: ReturnType<typeof setInterval> | undefined;
let hideTimer: ReturnType<typeof setTimeout> | undefined;
let firstTimer: ReturnType<typeof setTimeout> | undefined;

/**
 * Fallback data used when the database holds no registration yet, so the
 * notifications still feel alive on a fresh install.
 */
const fallbackEntries = [
    { name: 'Nguyễn V.', message: 'đã đăng ký nhận tư vấn miễn phí' },
    { name: 'Trần T.', message: 'vừa để lại số điện thoại' },
    { name: 'Lê H.', message: 'đang chờ kỹ sư gọi lại' },
    { name: 'Phạm A.', message: 'đã nhận mã ưu đãi ELICPO10' },
    { name: 'Hoàng M.', message: 'vừa đăng ký dùng thử' },
    { name: 'Vũ Đ.', message: 'đã đăng ký tư vấn liều lượng' },
    { name: 'Đặng T.', message: 'vừa đặt lịch lấy mẫu' },
    { name: 'Bùi Q.', message: 'đã đăng ký nhận bảng hướng dẫn' },
];

const activeEntry = computed(() => {
    if (current.value) {
        const location = current.value.region;

        return {
            name: current.value.name,
            message:
                location !== ''
                    ? `vừa đăng ký tư vấn tại ${location}`
                    : 'vừa đăng ký nhận tư vấn',
            package: current.value.package,
        };
    }

    const fallback = fallbackEntries[currentIndex.value % fallbackEntries.length];

    return {
        ...(fallback ?? { name: 'Khách hàng', message: 'vừa đăng ký' }),
        package: '',
    };
});

async function loadRegistrations(): Promise<void> {
    try {
        const response = await fetch(recentRegistrations.url(), {
            headers: { Accept: 'application/json' },
        });

        if (!response.ok) {
            return;
        }

        const data = (await response.json()) as {
            registrations?: Registration[];
        };

        registrations.value = Array.isArray(data.registrations)
            ? data.registrations.filter((item) => item.name !== '')
            : [];
    } catch {
        // Silently keep the fallback entries.
    }
}

function showNotification(): void {
    if (registrations.value.length > 0) {
        current.value =
            registrations.value[currentIndex.value % registrations.value.length] ??
            null;
    } else {
        current.value = null;
    }

    isVisible.value = true;

    if (hideTimer) {
        clearTimeout(hideTimer);
    }

    hideTimer = setTimeout(() => {
        isVisible.value = false;
    }, props.visibleFor);

    currentIndex.value =
        (currentIndex.value + 1) %
        Math.max(registrations.value.length, fallbackEntries.length);
}

function start(): void {
    cycleTimer = setInterval(() => {
        showNotification();
    }, props.interval);
}

onMounted(() => {
    if (!props.enabled) {
        return;
    }

    void loadRegistrations().finally(() => {
        if (!props.enabled) {
            return;
        }

        firstTimer = setTimeout(() => {
            showNotification();
            start();
        }, props.initialDelay);
    });
});

onBeforeUnmount(() => {
    if (cycleTimer) {
        clearInterval(cycleTimer);
    }

    if (hideTimer) {
        clearTimeout(hideTimer);
    }

    if (firstTimer) {
        clearTimeout(firstTimer);
    }
});
</script>

<template>
    <Teleport to="body">
        <div
            class="pointer-events-none fixed inset-x-0 top-[4.5rem] z-[80] flex justify-center px-3"
            role="status"
            aria-live="polite"
            aria-atomic="true"
        >
            <Transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="translate-y-3 opacity-0 sm:scale-95"
                enter-to-class="translate-y-0 opacity-100 sm:scale-100"
                leave-active-class="transition duration-300 ease-in"
                leave-from-class="translate-y-0 opacity-100 sm:scale-100"
                leave-to-class="-translate-y-3 opacity-0 sm:scale-95"
            >
                <div
                    v-if="props.enabled && isVisible"
                    class="flex w-full max-w-[22rem] items-center gap-3 rounded-2xl border border-emerald-500/30 bg-white/95 px-3.5 py-3 shadow-xl shadow-emerald-900/10 backdrop-blur"
                >
                    <span
                        class="relative flex size-10 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-white"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path
                                d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"
                            />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <span
                            class="absolute -right-0.5 -bottom-0.5 size-3 rounded-full border-2 border-white bg-emerald-400"
                        ></span>
                    </span>

                    <span class="min-w-0 flex-1 leading-tight">
                        <span
                            class="block truncate text-[13px] font-extrabold text-slate-900"
                        >
                            {{ activeEntry.name }}
                        </span>
                        <span class="block text-[11.5px] text-slate-500">
                            {{ activeEntry.message }}
                        </span>
                        <span
                            v-if="activeEntry.package"
                            class="mt-1 inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700"
                        >
                            {{ activeEntry.package }}
                        </span>
                    </span>

                    <span
                        class="flex size-7 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-emerald-600"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                    </span>
                </div>
            </Transition>
        </div>
    </Teleport>
</template>
