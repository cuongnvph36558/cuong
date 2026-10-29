<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3';
import { Download, Search, Trash2, Users, X } from '@lucide/vue';
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
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import {
    destroy as leadDestroy,
    exportMethod as leadsExport,
    index as leadsIndex,
} from '@/routes/admin/leads';

type Lead = {
    id: number;
    name: string;
    phone: string;
    address: string | null;
    coupon_code: string | null;
    variant: string | null;
    plant_type: string | null;
    symptoms: string[] | null;
    note: string | null;
    source: string | null;
    created_at: string;
};

type Props = {
    leads: {
        data: Lead[];
        current_page: number;
        last_page: number;
        from: number | null;
        to: number | null;
        total: number;
        links: { url: string | null; label: string; active: boolean }[];
    };
    filters: {
        search: string;
        symptom: string;
    };
    stats: {
        total: number;
        today: number;
        week: number;
    };
    symptoms: Record<string, number>;
};

const props = defineProps<Props>();

const page = usePage();
const isAdmin = computed(() => page.props.auth.user?.is_admin === true);

const search = ref(props.filters.search);
const symptom = ref(props.filters.symptom || 'all');

watch(
    () => props.filters.search,
    (value) => {
        search.value = value;
    },
);

watch(
    () => props.filters.symptom,
    (value) => {
        symptom.value = value || 'all';
    },
);

const symptomOptions = Object.keys(props.symptoms);

const hasFilters = computed(
    () => search.value !== '' || symptom.value !== 'all',
);

function applyFilters(): void {
    router.get(
        leadsIndex().url,
        {
            search: search.value || undefined,
            symptom: symptom.value === 'all' ? undefined : symptom.value,
        },
        { preserveState: true, replace: true },
    );
}

function resetFilters(): void {
    search.value = '';
    symptom.value = 'all';
    router.get(leadsIndex().url, {}, { preserveState: true, replace: true });
}

function removeLead(id: number): void {
    if (!confirm('Bạn có chắc muốn xoá dữ liệu này?')) {
        return;
    }

    router.delete(leadDestroy(id).url, { preserveScroll: true });
}

function exportCsv(): void {
    const url = leadsExport({
        query: {
            search: props.filters.search || undefined,
            symptom: props.filters.symptom || undefined,
        },
    }).url;

    window.location.href = url;
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
    <Head title="Danh sách khách hàng" />

    <div class="admin-page p-4 md:p-6">
        <AdminPageHeader
            title="Dữ liệu khách hàng"
            description="Tất cả khách hàng đăng ký từ trang chủ ELICPO."
            :icon="Users"
        >
            <template #actions>
                <Button variant="outline" @click="exportCsv">
                    <Download />
                    Xuất CSV
                </Button>
            </template>
        </AdminPageHeader>

        <div class="grid gap-4 sm:grid-cols-3">
            <AdminStatCard
                label="Tổng khách hàng"
                :value="props.stats.total"
                :icon="Users"
                tone="primary"
            />
            <AdminStatCard
                label="Khách hàng hôm nay"
                :value="props.stats.today"
                hint="Số lead mới trong ngày"
                tone="success"
            />
            <AdminStatCard
                label="7 ngày gần nhất"
                :value="props.stats.week"
                hint="Tổng lead trong tuần"
                tone="warning"
            />
        </div>

        <AdminPanel>
            <template #header>
                <div class="flex items-center gap-2">
                    <Search class="size-4 text-muted-foreground" />
                    <h2 class="admin-panel-title">Bộ lọc</h2>
                </div>
            </template>

            <div class="flex flex-wrap items-end gap-3">
                <div class="min-w-56 flex-1">
                    <label
                        for="admin-search"
                        class="mb-1.5 block text-sm font-medium text-foreground"
                    >
                        Tìm theo tên / số điện thoại
                    </label>
                    <Input
                        id="admin-search"
                        v-model="search"
                        placeholder="Nhập từ khoá..."
                        @keyup.enter="applyFilters"
                    />
                </div>

                <div class="w-full sm:w-64">
                    <span
                        class="mb-1.5 block text-sm font-medium text-foreground"
                    >
                        Tình trạng cây
                    </span>
                    <Select v-model="symptom">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Tất cả" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">Tất cả</SelectItem>
                            <SelectItem
                                v-for="option in symptomOptions"
                                :key="option"
                                :value="option"
                            >
                                {{ option }} ({{ props.symptoms[option] }})
                            </SelectItem>
                        </SelectContent>
                    </Select>
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
                    <X />
                    Đặt lại
                </Button>
            </div>
        </AdminPanel>

        <AdminPanel flush>
            <template #header>
                <div class="flex items-center justify-between gap-3">
                    <h2 class="admin-panel-title">
                        Danh sách khách hàng
                        <span
                            class="ml-1 text-sm font-normal text-muted-foreground"
                        >
                            ({{ props.leads.total }} bản ghi)
                        </span>
                    </h2>
                </div>
            </template>

            <div v-if="!props.leads.data.length" class="p-5">
                <AdminEmptyState
                    :icon="Users"
                    title="Chưa có dữ liệu khách hàng"
                    description="Khi có khách hàng đăng ký từ trang chủ, dữ liệu sẽ hiển thị tại đây."
                />
            </div>

            <div v-else class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="w-16">#</th>
                            <th>Họ tên</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Quy cách</th>
                            <th>Loại cây</th>
                            <th>Tình trạng</th>
                            <th>Mã</th>
                            <th>Thời gian</th>
                            <th class="w-20 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(lead, index) in props.leads.data"
                            :key="lead.id"
                        >
                            <td class="text-muted-foreground">
                                {{
                                    (props.leads.current_page - 1) * 15 +
                                    index +
                                    1
                                }}
                            </td>
                            <td>
                                <span class="font-medium text-foreground">
                                    {{ lead.name }}
                                </span>
                                <p
                                    v-if="lead.note"
                                    class="mt-0.5 max-w-xs truncate text-xs text-muted-foreground"
                                >
                                    {{ lead.note }}
                                </p>
                            </td>
                            <td>
                                <a
                                    :href="`tel:${lead.phone}`"
                                    class="font-medium text-primary underline-offset-4 hover:underline"
                                >
                                    {{ lead.phone }}
                                </a>
                            </td>
                            <td class="text-muted-foreground">
                                {{ lead.address ?? '—' }}
                            </td>
                            <td class="text-muted-foreground">
                                {{ lead.variant ?? '—' }}
                            </td>
                            <td class="text-muted-foreground">
                                {{ lead.plant_type ?? '—' }}
                            </td>
                            <td>
                                <div class="flex flex-wrap gap-1">
                                    <Badge
                                        v-for="item in lead.symptoms ?? []"
                                        :key="item"
                                        variant="secondary"
                                    >
                                        {{ item }}
                                    </Badge>
                                    <span
                                        v-if="!lead.symptoms?.length"
                                        class="text-muted-foreground"
                                    >
                                        —
                                    </span>
                                </div>
                            </td>
                            <td>
                                <Badge variant="outline">
                                    {{ lead.coupon_code ?? '—' }}
                                </Badge>
                            </td>
                            <td class="whitespace-nowrap text-muted-foreground">
                                {{ formatDate(lead.created_at) }}
                            </td>
                            <td class="text-right">
                                <Button
                                    variant="ghost"
                                    size="icon-sm"
                                    class="text-destructive hover:text-destructive"
                                    title="Xoá"
                                    @click="removeLead(lead.id)"
                                >
                                    <Trash2 />
                                </Button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <AdminPagination
                v-if="props.leads.last_page > 1"
                :links="props.leads.links"
            />
        </AdminPanel>

        <p v-if="!isAdmin" class="text-xs text-muted-foreground">
            Bạn đang xem trang quản trị dưới quyền không đầy đủ.
        </p>
    </div>
</template>
