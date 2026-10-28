<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItem } from '@/types';

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItem[];
    }>(),
    {
        breadcrumbs: () => [],
    },
);
</script>

<template>
    <header
        class="sticky top-0 z-30 flex h-16 shrink-0 items-center gap-3 border-b border-border/70 bg-background/90 px-4 backdrop-blur transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-14 md:px-6"
    >
        <SidebarTrigger class="-ml-1 size-9" />

        <Breadcrumbs :breadcrumbs="breadcrumbs" />

        <div class="ml-auto flex items-center gap-2">
            <slot name="actions" />
        </div>
    </header>
</template>
