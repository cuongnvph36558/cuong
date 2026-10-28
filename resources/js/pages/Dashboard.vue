<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    LayoutGrid,
    LayoutTemplate,
    MessageSquareQuote,
    Users,
} from '@lucide/vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import AdminPanel from '@/components/admin/AdminPanel.vue';
import { Button } from '@/components/ui/button';
import { edit as homeContentEdit } from '@/routes/admin/home-content';
import { index as leadsIndex } from '@/routes/admin/leads';
import { index as feedbacksIndex } from '@/routes/admin/feedbacks';

const quickLinks = [
    {
        title: 'Nội dung trang chủ',
        description: 'Chỉnh sửa nội dung hiển thị trên trang chủ.',
        href: homeContentEdit(),
        icon: LayoutTemplate,
    },
    {
        title: 'Phản hồi khách hàng',
        description: 'Quản lý đánh giá và phản hồi từ khách hàng.',
        href: feedbacksIndex(),
        icon: MessageSquareQuote,
    },
    {
        title: 'Dữ liệu khách hàng',
        description: 'Xem và xuất danh sách khách hàng đã đăng ký.',
        href: leadsIndex(),
        icon: Users,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <div class="admin-page p-4 md:p-6">
        <AdminPageHeader
            title="Dashboard"
            description="Tổng quan nhanh các chức năng quản trị."
            :icon="LayoutGrid"
        />

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <AdminPanel
                v-for="link in quickLinks"
                :key="link.title"
                class="transition hover:shadow-md"
            >
                <div class="flex h-full flex-col gap-3">
                    <div
                        class="flex size-10 items-center justify-center rounded-xl bg-primary/10 text-primary"
                    >
                        <component :is="link.icon" class="size-5" />
                    </div>

                    <div class="space-y-1">
                        <h3 class="admin-panel-title">{{ link.title }}</h3>
                        <p class="text-sm text-muted-foreground">
                            {{ link.description }}
                        </p>
                    </div>

                    <Button
                        variant="outline"
                        size="sm"
                        class="mt-auto w-fit"
                        as-child
                    >
                        <Link :href="link.href">Mở</Link>
                    </Button>
                </div>
            </AdminPanel>
        </div>
    </div>
</template>
