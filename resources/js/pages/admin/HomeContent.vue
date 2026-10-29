<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { useHttp } from '@inertiajs/vue3';
import {
    ArrowDown,
    ArrowUp,
    Beaker,
    Building2,
    ClipboardList,
    ExternalLink,
    Gift,
    Globe,
    Images,
    LayoutTemplate,
    Leaf,
    Package,
    Phone,
    Plus,
    Quote,
    Rocket,
    RotateCcw,
    Save,
    Search,
    ShieldCheck,
    Sparkles,
    Star,
    Tags,
    Timer,
    Trash2,
    TriangleAlert,
    Trophy,
    FlaskConical,
} from '@lucide/vue';
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import AdminPanel from '@/components/admin/AdminPanel.vue';
import HomeContentImageField from '@/components/admin/HomeContentImageField.vue';
import HomeContentTextField from '@/components/admin/HomeContentTextField.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { home as homeRoute } from '@/routes';
import {
    reset as homeContentReset,
    update as homeContentUpdate,
} from '@/routes/admin/home-content';
import type {
    HomeContent,
    HomeContentField,
    HomeContentItem,
    HomeContentSection,
} from '@/types/homeContent';

type Props = {
    schema: HomeContentSection[];
    content: HomeContent;
};

const props = defineProps<Props>();

type SaveResponse = {
    message: string;
    content: HomeContent;
};

type ResetResponse = {
    message: string;
    content: HomeContent;
};

const icons: Record<string, unknown> = {
    search: Search,
    sparkles: Sparkles,
    leaf: Leaf,
    'triangle-alert': TriangleAlert,
    'flask-conical': FlaskConical,
    'beaker': Beaker,
    'globe': Globe,
    'images': Images,
    'quote': Quote,
    trophy: Trophy,
    'clipboard-list': ClipboardList,
    'shield-check': ShieldCheck,
    tags: Tags,
    star: Star,
    rocket: Rocket,
    'building-2': Building2,
    phone: Phone,
    timer: Timer,
    package: Package,
    gift: Gift,
};

const form = ref<HomeContent>(cloneContent(props.content));
const savedContent = ref<HomeContent>(cloneContent(props.content));
const activeSection = ref(props.schema[0]?.key ?? '');

const saveForm = useHttp<{ content: HomeContent }, SaveResponse>({
    content: cloneContent(props.content),
});

const resetForm = useHttp<Record<string, never>, ResetResponse>({});

const dirty = computed(() => {
    return JSON.stringify(form.value) !== JSON.stringify(savedContent.value);
});

/**
 * Deep clone the content so edits never mutate the Inertia page props.
 */
function cloneContent(content: HomeContent): HomeContent {
    return JSON.parse(JSON.stringify(content)) as HomeContent;
}

const activeSectionData = computed(
    () =>
        props.schema.find((section) => section.key === activeSection.value) ??
        props.schema[0],
);

function sectionContent(key: string): Record<string, unknown> {
    if (!form.value[key]) {
        form.value[key] = {};
    }

    return form.value[key] as Record<string, unknown>;
}

function fieldValue(sectionKey: string, fieldKey: string): unknown {
    return sectionContent(sectionKey)[fieldKey];
}

function updateField(
    sectionKey: string,
    fieldKey: string,
    value: unknown,
): void {
    sectionContent(sectionKey)[fieldKey] = value;
}

function listItems(sectionKey: string, fieldKey: string): HomeContentItem[] {
    const value = sectionContent(sectionKey)[fieldKey];

    return Array.isArray(value) ? (value as HomeContentItem[]) : [];
}

function updateListItem(
    sectionKey: string,
    fieldKey: string,
    index: number,
    itemKey: string,
    value: unknown,
): void {
    const items = listItems(sectionKey, fieldKey);
    const item = items[index];

    if (item) {
        item[itemKey] = value as string | number | null;
    }
}

function addListItem(sectionKey: string, field: HomeContentField): void {
    const items = listItems(sectionKey, field.key);
    const blank: HomeContentItem = {};

    for (const itemField of field.itemFields ?? []) {
        blank[itemField.key] =
            itemField.type === 'number' ? 0 : String(itemField.default ?? '');
    }

    items.push(blank);
    updateField(sectionKey, field.key, items);
}

function removeListItem(
    sectionKey: string,
    fieldKey: string,
    index: number,
): void {
    const items = listItems(sectionKey, fieldKey);
    items.splice(index, 1);
    updateField(sectionKey, fieldKey, items);
}

function moveListItem(
    sectionKey: string,
    fieldKey: string,
    index: number,
    direction: -1 | 1,
): void {
    const items = listItems(sectionKey, fieldKey);
    const target = index + direction;

    if (target < 0 || target >= items.length) {
        return;
    }

    const [moved] = items.splice(index, 1);
    items.splice(target, 0, moved);
    updateField(sectionKey, fieldKey, items);
}

async function save(): Promise<void> {
    try {
        saveForm.content = cloneContent(form.value);

        const response = await saveForm.put(homeContentUpdate().url, {
            onError: (errors) => {
                toast.error(
                    Object.values(errors).flat().join(' ') ||
                        'Không lưu được nội dung.',
                );
            },
        });

        if (response?.content) {
            form.value = cloneContent(response.content);
            savedContent.value = cloneContent(response.content);
            toast.success('Đã cập nhật nội dung trang chủ.');
        }
    } catch {
        toast.error('Không lưu được nội dung.');
    }
}

async function restoreDefaults(): Promise<void> {
    if (!confirm('Bạn có chắc muốn khôi phục toàn bộ nội dung về mặc định?')) {
        return;
    }

    try {
        const response = await resetForm.post(homeContentReset().url);

        if (response?.content) {
            form.value = cloneContent(response.content);
            savedContent.value = cloneContent(response.content);
            toast.success('Đã khôi phục nội dung mặc định.');
        }
    } catch {
        toast.error('Không khôi phục được nội dung.');
    }
}
</script>

<template>
    <Head title="Nội dung trang chủ" />

    <div class="admin-page p-4 md:p-6">
        <AdminPageHeader
            title="Nội dung trang chủ"
            description="Chỉnh sửa toàn bộ nội dung hiển thị trên trang chủ ELICPO."
            :icon="LayoutTemplate"
        >
            <template #actions>
                <Button variant="outline" as-child>
                    <a :href="homeRoute().url" target="_blank" rel="noopener">
                        <ExternalLink />
                        Xem trang chủ
                    </a>
                </Button>

                <Button
                    variant="outline"
                    :disabled="resetForm.processing"
                    @click="restoreDefaults"
                >
                    <RotateCcw />
                    Khôi phục mặc định
                </Button>

                <Button :disabled="saveForm.processing || !dirty" @click="save">
                    <Save />
                    {{ saveForm.processing ? 'Đang lưu...' : 'Lưu thay đổi' }}
                </Button>
            </template>
        </AdminPageHeader>

        <p
            v-if="dirty"
            class="flex items-center gap-2 rounded-lg border border-amber-500/40 bg-amber-500/10 px-4 py-2.5 text-sm text-amber-700 dark:text-amber-300"
        >
            <TriangleAlert class="size-4 shrink-0" />
            Bạn có thay đổi chưa được lưu. Nhấn "Lưu thay đổi" để áp dụng.
        </p>

        <div class="grid gap-5 lg:grid-cols-[260px_1fr]">
            <!-- Section navigation -->
            <nav class="admin-panel h-fit space-y-1 p-2 lg:sticky lg:top-24">
                <button
                    v-for="section in props.schema"
                    :key="section.key"
                    type="button"
                    class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2.5 text-left text-sm font-medium transition"
                    :class="
                        activeSection === section.key
                            ? 'bg-primary text-primary-foreground shadow-sm'
                            : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground'
                    "
                    @click="activeSection = section.key"
                >
                    <component
                        :is="icons[section.icon] ?? Sparkles"
                        class="size-4 shrink-0"
                    />
                    <span class="truncate">{{ section.label }}</span>
                </button>
            </nav>

            <!-- Section editor -->
            <AdminPanel v-if="activeSectionData" flush>
                <template #header>
                    <h2 class="admin-panel-title">
                        {{ activeSectionData.label }}
                    </h2>
                    <p class="admin-panel-description">
                        {{ activeSectionData.description }}
                    </p>
                </template>

                <div class="space-y-6 p-5">
                    <div
                        v-for="field in activeSectionData.fields"
                        :key="field.key"
                        class="space-y-2 border-b border-border/50 pb-6 last:border-0 last:pb-0"
                    >
                        <!-- Simple text / textarea / number field -->
                        <template
                            v-if="
                                field.type !== 'list' && field.type !== 'image'
                            "
                        >
                            <Label
                                :for="`${activeSectionData.key}-${field.key}`"
                                class="text-foreground"
                            >
                                {{ field.label }}
                            </Label>

                            <HomeContentTextField
                                :id="`${activeSectionData.key}-${field.key}`"
                                :multiline="field.type === 'textarea'"
                                :type="
                                    field.type === 'number' ? 'number' : 'text'
                                "
                                :model-value="
                                    field.type === 'number'
                                        ? Number(
                                              fieldValue(
                                                  activeSectionData.key,
                                                  field.key,
                                              ) ?? 0,
                                          )
                                        : String(
                                              fieldValue(
                                                  activeSectionData.key,
                                                  field.key,
                                              ) ?? '',
                                          )
                                "
                                @update:model-value="
                                    updateField(
                                        activeSectionData.key,
                                        field.key,
                                        $event,
                                    )
                                "
                            />
                        </template>

                        <!-- Image field -->
                        <HomeContentImageField
                            v-else-if="field.type === 'image'"
                            :label="field.label"
                            :model-value="
                                String(
                                    fieldValue(
                                        activeSectionData.key,
                                        field.key,
                                    ) ?? '',
                                )
                            "
                            @update:model-value="
                                updateField(
                                    activeSectionData.key,
                                    field.key,
                                    $event,
                                )
                            "
                        />

                        <!-- Repeatable list field -->
                        <template v-else>
                            <div
                                class="flex items-center justify-between gap-3"
                            >
                                <Label class="text-foreground">
                                    {{ field.label }}
                                </Label>
                                <Button
                                    type="button"
                                    variant="outline"
                                    size="sm"
                                    @click="
                                        addListItem(
                                            activeSectionData.key,
                                            field,
                                        )
                                    "
                                >
                                    <Plus />
                                    Thêm
                                </Button>
                            </div>

                            <div
                                class="space-y-3"
                                :class="
                                    listItems(activeSectionData.key, field.key)
                                        .length === 0
                                        ? 'rounded-lg border border-dashed p-6 text-center text-sm text-muted-foreground'
                                        : ''
                                "
                            >
                                <p
                                    v-if="
                                        listItems(
                                            activeSectionData.key,
                                            field.key,
                                        ).length === 0
                                    "
                                >
                                    Chưa có mục nào. Bấm "Thêm" để bắt đầu.
                                </p>

                                <div
                                    v-for="(item, index) in listItems(
                                        activeSectionData.key,
                                        field.key,
                                    )"
                                    :key="index"
                                    class="space-y-3 rounded-xl border border-border/70 bg-muted/30 p-4"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <span
                                            class="text-xs font-semibold text-muted-foreground"
                                        >
                                            {{ field.itemLabel }}
                                            #{{ index + 1 }}
                                        </span>

                                        <div class="flex items-center gap-1">
                                            <Button
                                                type="button"
                                                variant="ghost"
                                                size="icon-sm"
                                                :disabled="index === 0"
                                                @click="
                                                    moveListItem(
                                                        activeSectionData.key,
                                                        field.key,
                                                        index,
                                                        -1,
                                                    )
                                                "
                                            >
                                                <ArrowUp />
                                            </Button>
                                            <Button
                                                type="button"
                                                variant="ghost"
                                                size="icon-sm"
                                                :disabled="
                                                    index ===
                                                    listItems(
                                                        activeSectionData.key,
                                                        field.key,
                                                    ).length -
                                                        1
                                                "
                                                @click="
                                                    moveListItem(
                                                        activeSectionData.key,
                                                        field.key,
                                                        index,
                                                        1,
                                                    )
                                                "
                                            >
                                                <ArrowDown />
                                            </Button>
                                            <Button
                                                type="button"
                                                variant="ghost"
                                                size="icon-sm"
                                                class="text-destructive hover:text-destructive"
                                                @click="
                                                    removeListItem(
                                                        activeSectionData.key,
                                                        field.key,
                                                        index,
                                                    )
                                                "
                                            >
                                                <Trash2 />
                                            </Button>
                                        </div>
                                    </div>

                                    <div
                                        v-for="itemField in field.itemFields ??
                                        []"
                                        :key="itemField.key"
                                        class="space-y-2"
                                    >
                                        <Label
                                            :for="`${activeSectionData.key}-${field.key}-${index}-${itemField.key}`"
                                            class="text-foreground"
                                        >
                                            {{ itemField.label }}
                                        </Label>

                                        <HomeContentImageField
                                            v-if="itemField.type === 'image'"
                                            :label="itemField.label"
                                            :model-value="
                                                String(
                                                    item[itemField.key] ?? '',
                                                )
                                            "
                                            @update:model-value="
                                                updateListItem(
                                                    activeSectionData.key,
                                                    field.key,
                                                    index,
                                                    itemField.key,
                                                    $event,
                                                )
                                            "
                                        />

                                        <HomeContentTextField
                                            v-else
                                            :id="`${activeSectionData.key}-${field.key}-${index}-${itemField.key}`"
                                            :multiline="
                                                itemField.type === 'textarea'
                                            "
                                            :type="
                                                itemField.type === 'number'
                                                    ? 'number'
                                                    : 'text'
                                            "
                                            :model-value="
                                                itemField.type === 'number'
                                                    ? Number(
                                                          item[itemField.key] ??
                                                              0,
                                                      )
                                                    : String(
                                                          item[itemField.key] ??
                                                              '',
                                                      )
                                            "
                                            @update:model-value="
                                                updateListItem(
                                                    activeSectionData.key,
                                                    field.key,
                                                    index,
                                                    itemField.key,
                                                    $event,
                                                )
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </AdminPanel>
        </div>
    </div>
</template>
