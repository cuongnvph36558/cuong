<script setup lang="ts">
import { ChevronLeft, ChevronRight } from '@lucide/vue';
import { Link } from '@inertiajs/vue3';

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type Props = {
    /** Pagination links returned by the server. */
    links: PaginationLink[];
};

const props = defineProps<Props>();
</script>

<template>
    <nav
        v-if="props.links.length"
        class="flex flex-wrap items-center justify-between gap-3 border-t border-border/60 px-5 py-3"
        aria-label="Phân trang"
    >
        <Link
            v-if="props.links[0]?.url"
            :href="props.links[0]?.url ?? '#'"
            preserve-scroll
            class="inline-flex items-center gap-1 rounded-lg border border-border/70 px-3 py-1.5 text-sm font-medium transition hover:bg-accent"
        >
            <ChevronLeft class="size-4" />
            Trước
        </Link>
        <span v-else></span>

        <div class="flex flex-wrap items-center gap-1">
            <template
                v-for="(link, index) in props.links"
                :key="`${link.label}-${index}`"
            >
                <span
                    v-if="link.label.includes('...')"
                    class="px-2 text-sm text-muted-foreground"
                >
                    {{ link.label }}
                </span>
                <Link
                    v-else
                    :href="link.url ?? '#'"
                    preserve-scroll
                    class="inline-flex min-w-9 items-center justify-center rounded-lg border px-3 py-1.5 text-sm font-medium transition"
                    :class="
                        link.active
                            ? 'border-primary bg-primary text-primary-foreground'
                            : 'border-border/70 text-muted-foreground hover:bg-accent hover:text-accent-foreground'
                    "
                >
                    {{ link.label }}
                </Link>
            </template>
        </div>

        <Link
            v-if="props.links[props.links.length - 1]?.url"
            :href="props.links[props.links.length - 1]?.url ?? '#'"
            preserve-scroll
            class="inline-flex items-center gap-1 rounded-lg border border-border/70 px-3 py-1.5 text-sm font-medium transition hover:bg-accent"
        >
            Sau
            <ChevronRight class="size-4" />
        </Link>
        <span v-else></span>
    </nav>
</template>
