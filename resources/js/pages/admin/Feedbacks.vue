<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import {
    MessageSquareQuote,
    Pencil,
    Plus,
    Search,
    Star,
    Trash2,
} from '@lucide/vue';
import { computed, ref, watch } from 'vue';
import AdminEmptyState from '@/components/admin/AdminEmptyState.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import AdminPagination from '@/components/admin/AdminPagination.vue';
import AdminPanel from '@/components/admin/AdminPanel.vue';
import AdminStatCard from '@/components/admin/AdminStatCard.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    create as feedbackCreate,
    destroy as feedbackDestroy,
    edit as feedbackEdit,
    index as feedbacksIndex,
} from '@/routes/admin/feedbacks';

type Feedback = {
    id: number;
    name: string;
    role: string | null;
    rating: number;
    content: string;
    image: string | null;
    photos: string[] | null;
    is_featured: boolean;
    sort_order: number;
    created_at: string;
};

type Props = {
    feedbacks: {
        data: Feedback[];
        current_page: number;
        last_page: number;
        total: number;
        links: { url: string | null; label: string; active: boolean }[];
    };
    filters: {
        search: string;
    };
    stats: {
        total: number;
        featured: number;
        withImages: number;
    };
};

const props = defineProps<Props>();

const search = ref(props.filters.search);

watch(
    () => props.filters.search,
    (value) => {
        search.value = value;
    },
);

const hasFilters = computed(() => search.value !== '');

function applyFilters(): void {
    router.get(
        feedbacksIndex().url,
        { search: search.value || undefined },
        { preserveState: true, replace: true },
    );
}

function resetFilters(): void {
    search.value = '';
    router.get(
        feedbacksIndex().url,
        {},
        { preserveState: true, replace: true },
    );
}

function removeFeedback(id: number): void {
    if (!confirm('Bạn có chắc muốn xoá phản hồi này?')) {
        return;
    }

    router.delete(feedbackDestroy(id).url, { preserveScroll: true });
}

function formatDate(value: string): string {
    return new Date(value).toLocaleString('vi-VN', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
}
</script>

<template>
    <Head title="Phản hồi khách hàng" />

    <div class="admin-page p-4 md:p-6">
        <AdminPageHeader
            title="Phản hồi khách hàng"
            description="Quản lý các đánh giá và phản hồi hiển thị trên trang chủ."
            :icon="MessageSquareQuote"
        >
            <template #actions>
                <Button as-child>
                    <Link :href="feedbackCreate()">
                        <Plus />
                        Thêm phản hồi
                    </Link>
                </Button>
            </template>
        </AdminPageHeader>

        <div class="grid gap-4 sm:grid-cols-3">
            <AdminStatCard
                label="Tổng phản hồi"
                :value="props.stats.total"
                :icon="MessageSquareQuote"
                tone="primary"
            />
            <AdminStatCard
                label="Phản hồi nổi bật"
                :value="props.stats.featured"
                hint="Được ưu tiên hiển thị"
                tone="success"
            />
            <AdminStatCard
                label="Có hình ảnh"
                :value="props.stats.withImages"
                hint="Phản hồi kèm ảnh"
                tone="warning"
            />
        </div>

        <AdminPanel>
            <template #header>
                <div class="flex items-center gap-2">
                    <Search class="size-4 text-muted-foreground" />
                    <h2 class="admin-panel-title">Tìm kiếm</h2>
                </div>
            </template>

            <div class="flex flex-wrap items-end gap-3">
                <div class="min-w-56 flex-1">
                    <label
                        for="feedback-search"
                        class="mb-1.5 block text-sm font-medium text-foreground"
                    >
                        Tìm theo tên / vai trò / nội dung
                    </label>
                    <Input
                        id="feedback-search"
                        v-model="search"
                        placeholder="Nhập từ khoá..."
                        @keyup.enter="applyFilters"
                    />
                </div>

                <Button @click="applyFilters">
                    <Search />
                    Lọc
                </Button>
                <Button
                    variant="ghost"
                    :disabled="!hasFilters"
                    @click="resetFilters"
                >
                    Đặt lại
                </Button>
            </div>
        </AdminPanel>

        <AdminPanel flush>
            <template #header>
                <h2 class="admin-panel-title">
                    Danh sách phản hồi
                    <span
                        class="ml-1 text-sm font-normal text-muted-foreground"
                    >
                        ({{ props.feedbacks.total }} bản ghi)
                    </span>
                </h2>
            </template>

            <div v-if="!props.feedbacks.data.length" class="p-5">
                <AdminEmptyState
                    :icon="MessageSquareQuote"
                    title="Chưa có phản hồi nào"
                    description="Thêm phản hồi đầu tiên để hiển thị trên trang chủ."
                >
                    <Button as-child>
                        <Link :href="feedbackCreate()">
                            <Plus />
                            Thêm phản hồi
                        </Link>
                    </Button>
                </AdminEmptyState>
            </div>

            <div v-else class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="w-16">#</th>
                            <th>Khách hàng</th>
                            <th>Vai trò</th>
                            <th>Đánh giá</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Thời gian</th>
                            <th class="w-24 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(feedback, index) in props.feedbacks.data"
                            :key="feedback.id"
                        >
                            <td class="text-muted-foreground">
                                {{
                                    (props.feedbacks.current_page - 1) * 15 +
                                    index +
                                    1
                                }}
                            </td>
                            <td>
                                <div class="flex items-center gap-2.5">
                                    <img
                                        v-if="feedback.image"
                                        :src="feedback.image"
                                        :alt="feedback.name"
                                        class="size-9 shrink-0 rounded-lg object-cover"
                                    />
                                    <div
                                        v-else
                                        class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-muted text-xs font-semibold text-muted-foreground"
                                    >
                                        {{ feedback.name.charAt(0) }}
                                    </div>
                                    <span class="font-medium text-foreground">
                                        {{ feedback.name }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-muted-foreground">
                                {{ feedback.role ?? '—' }}
                            </td>
                            <td>
                                <div
                                    class="flex items-center gap-0.5 text-amber-500"
                                >
                                    <Star
                                        v-for="star in feedback.rating"
                                        :key="star"
                                        class="size-3.5 fill-current"
                                    />
                                    <span
                                        v-if="!feedback.rating"
                                        class="text-muted-foreground"
                                    >
                                        —
                                    </span>
                                </div>
                            </td>
                            <td class="max-w-sm">
                                <p
                                    class="line-clamp-2 text-sm text-muted-foreground"
                                >
                                    {{ feedback.content }}
                                </p>
                            </td>
                            <td>
                                <Badge
                                    :variant="
                                        feedback.is_featured
                                            ? 'default'
                                            : 'secondary'
                                    "
                                >
                                    {{
                                        feedback.is_featured
                                            ? 'Nổi bật'
                                            : 'Thường'
                                    }}
                                </Badge>
                            </td>
                            <td class="whitespace-nowrap text-muted-foreground">
                                {{ formatDate(feedback.created_at) }}
                            </td>
                            <td>
                                <div
                                    class="flex items-center justify-end gap-1"
                                >
                                    <Button
                                        variant="ghost"
                                        size="icon-sm"
                                        title="Sửa"
                                        as-child
                                    >
                                        <Link :href="feedbackEdit(feedback.id)">
                                            <Pencil />
                                        </Link>
                                    </Button>
                                    <Button
                                        variant="ghost"
                                        size="icon-sm"
                                        class="text-destructive hover:text-destructive"
                                        title="Xoá"
                                        @click="removeFeedback(feedback.id)"
                                    >
                                        <Trash2 />
                                    </Button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <AdminPagination
                v-if="props.feedbacks.last_page > 1"
                :links="props.feedbacks.links"
            />
        </AdminPanel>
    </div>
</template>
