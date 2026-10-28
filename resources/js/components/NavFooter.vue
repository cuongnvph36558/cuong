<script setup lang="ts">
import {
    SidebarGroup,
    SidebarGroupContent,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { toUrl } from '@/lib/utils';
import type { NavItem } from '@/types';

type Props = {
    items: NavItem[];
    class?: string;
};

defineProps<Props>();
</script>

<template>
    <SidebarGroup
        :class="`group-data-[collapsible=icon]:p-0 ${$props.class || ''}`"
    >
        <SidebarGroupContent>
            <SidebarMenu class="gap-1">
                <SidebarMenuItem v-for="item in items" :key="item.title">
                    <SidebarMenuButton
                        class="h-9 gap-2.5 rounded-lg px-3 text-[13px] text-sidebar-foreground/70 transition-colors hover:text-sidebar-foreground"
                        as-child
                    >
                        <a
                            :href="toUrl(item.href)"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <component :is="item.icon" class="size-4" />
                            <span>{{ item.title }}</span>
                        </a>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarGroupContent>
    </SidebarGroup>
</template>
