<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
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

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">
                    Dữ liệu khách hàng
                </h1>
                <p class="text-sm text-muted-foreground">
                    Tất cả khách hàng đăng ký từ trang chủ ROOTBIO.
                </p>
            </div>

            <Button variant="outline" @click="exportCsv"> Xuất CSV </Button>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <Card>
                <CardHeader class="pb-2">
                    <CardTitle
                        class="text-sm font-medium text-muted-foreground"
                    >
                        Tổng khách hàng
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="text-3xl font-bold">
                        {{ props.stats.total }}
                    </p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="pb-2">
                    <CardTitle
                        class="text-sm font-medium text-muted-foreground"
                    >
                        Hôm nay
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="text-3xl font-bold">
                        {{ props.stats.today }}
                    </p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="pb-2">
                    <CardTitle
                        class="text-sm font-medium text-muted-foreground"
                    >
                        7 ngày gần nhất
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="text-3xl font-bold">
                        {{ props.stats.week }}
                    </p>
                </CardContent>
            </Card>
        </div>

        <Card>
            <CardHeader>
                <CardTitle>Bộ lọc</CardTitle>
            </CardHeader>
            <CardContent>
                <div class="flex flex-wrap items-end gap-3">
                    <div class="w-full sm:w-72">
                        <label
                            for="admin-search"
                            class="mb-1 block text-sm font-medium"
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

                    <div class="w-full sm:w-56">
                        <span class="mb-1 block text-sm font-medium">
                            Tình trạng cây
                        </span>
                        <Select v-model="symptom">
                            <SelectTrigger>
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

                    <Button @click="applyFilters">Lọc</Button>
                    <Button variant="ghost" @click="resetFilters">
                        Đặt lại
                    </Button>
                </div>
            </CardContent>
        </Card>

        <Card>
            <CardHeader>
                <CardTitle>
                    Danh sách
                    <span class="text-sm font-normal text-muted-foreground">
                        ({{ props.leads.total }} bản ghi)
                    </span>
                </CardTitle>
            </CardHeader>
            <CardContent>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead
                            class="border-b text-xs text-muted-foreground uppercase"
                        >
                            <tr>
                                <th class="px-3 py-2">#</th>
                                <th class="px-3 py-2">Họ tên</th>
                                <th class="px-3 py-2">Số điện thoại</th>
                                <th class="px-3 py-2">Địa chỉ</th>
                                <th class="px-3 py-2">Loại cây</th>
                                <th class="px-3 py-2">Tình trạng</th>
                                <th class="px-3 py-2">Mã</th>
                                <th class="px-3 py-2">Thời gian</th>
                                <th class="px-3 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(lead, index) in props.leads.data"
                                :key="lead.id"
                                class="border-b last:border-0 hover:bg-muted/50"
                            >
                                <td class="px-3 py-3 text-muted-foreground">
                                    {{
                                        (props.leads.current_page - 1) * 15 +
                                        index +
                                        1
                                    }}
                                </td>
                                <td class="px-3 py-3 font-medium">
                                    {{ lead.name }}
                                    <p
                                        v-if="lead.note"
                                        class="mt-0.5 max-w-xs truncate text-xs text-muted-foreground"
                                    >
                                        {{ lead.note }}
                                    </p>
                                </td>
                                <td class="px-3 py-3">
                                    <a
                                        :href="`tel:${lead.phone}`"
                                        class="font-medium text-primary underline-offset-4 hover:underline"
                                    >
                                        {{ lead.phone }}
                                    </a>
                                </td>
                                <td class="px-3 py-3 text-muted-foreground">
                                    {{ lead.address ?? '—' }}
                                </td>
                                <td class="px-3 py-3 text-muted-foreground">
                                    {{ lead.plant_type ?? '—' }}
                                </td>
                                <td class="px-3 py-3">
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
                                <td class="px-3 py-3">
                                    <Badge variant="outline">
                                        {{ lead.coupon_code ?? '—' }}
                                    </Badge>
                                </td>
                                <td
                                    class="px-3 py-3 whitespace-nowrap text-muted-foreground"
                                >
                                    {{ formatDate(lead.created_at) }}
                                </td>
                                <td class="px-3 py-3 text-right">
                                    <button
                                        type="button"
                                        class="text-xs font-medium text-destructive hover:underline"
                                        @click="removeLead(lead.id)"
                                    >
                                        Xoá
                                    </button>
                                </td>
                            </tr>

                            <tr v-if="!props.leads.data.length">
                                <td
                                    colspan="9"
                                    class="px-3 py-10 text-center text-muted-foreground"
                                >
                                    Chưa có dữ liệu khách hàng.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div
                    v-if="props.leads.last_page > 1"
                    class="mt-4 flex flex-wrap items-center gap-1"
                >
                    <Link
                        v-for="link in props.leads.links"
                        :key="link.label"
                        :href="link.url ?? '#'"
                        class="rounded-md border px-3 py-1.5 text-xs font-medium transition hover:bg-accent"
                        :class="
                            link.active
                                ? 'border-primary bg-primary text-primary-foreground'
                                : 'text-muted-foreground'
                        "
                        preserve-scroll
                    >
                        {{ link.label }}
                    </Link>
                </div>
            </CardContent>
        </Card>

        <p v-if="!isAdmin" class="text-xs text-muted-foreground">
            Bạn đang xem trang quản trị dưới quyền không đầy đủ.
        </p>
    </div>
</template>
