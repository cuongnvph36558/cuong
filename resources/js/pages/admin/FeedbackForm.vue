<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ArrowLeft, ImagePlus, Save, Star, Trash2 } from '@lucide/vue';
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import AdminPanel from '@/components/admin/AdminPanel.vue';
import FeedbackImageField from '@/components/admin/FeedbackImageField.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import {
    index as feedbacksIndex,
    store as feedbackStore,
    update as feedbackUpdate,
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
};

type Props = {
    feedback: Feedback | null;
};

const props = defineProps<Props>();

const form = useForm({
    name: props.feedback?.name ?? '',
    role: props.feedback?.role ?? '',
    rating: props.feedback?.rating ?? 5,
    content: props.feedback?.content ?? '',
    image: props.feedback?.image ?? '',
    photos: props.feedback?.photos ?? ([] as string[]),
    is_featured: props.feedback?.is_featured ?? false,
    sort_order: props.feedback?.sort_order ?? 0,
});

const isEditing = computed(() => props.feedback !== null);

function addPhoto(): void {
    form.photos.push('');
}

function removePhoto(index: number): void {
    form.photos.splice(index, 1);
}

function updatePhoto(index: number, path: string): void {
    form.photos[index] = path;
}

function submit(): void {
    const options = {
        preserveScroll: true,
        onSuccess: () => {
            toast.success(
                isEditing.value
                    ? 'Đã cập nhật phản hồi.'
                    : 'Đã thêm phản hồi mới.',
            );
        },
        onError: (errors: Record<string, string>) => {
            toast.error(
                Object.values(errors).flat().join(' ') ||
                    'Không lưu được phản hồi.',
            );
        },
    };

    form.photos = form.photos.filter((photo) => photo !== '');

    if (props.feedback) {
        form.put(feedbackUpdate(props.feedback.id).url, options);

        return;
    }

    form.post(feedbackStore().url, options);
}
</script>

<template>
    <Head :title="isEditing ? 'Sửa phản hồi' : 'Thêm phản hồi'" />

    <div class="admin-page p-4 md:p-6">
        <AdminPageHeader
            :title="isEditing ? 'Sửa phản hồi' : 'Thêm phản hồi'"
            description="Cập nhật thông tin phản hồi hiển thị trên trang chủ."
        >
            <template #actions>
                <Button variant="outline" as-child>
                    <Link :href="feedbacksIndex()">
                        <ArrowLeft />
                        Quay lại
                    </Link>
                </Button>
                <Button :disabled="form.processing" @click="submit">
                    <Save />
                    {{ form.processing ? 'Đang lưu...' : 'Lưu phản hồi' }}
                </Button>
            </template>
        </AdminPageHeader>

        <form
            class="grid gap-5 lg:grid-cols-[1fr_340px]"
            @submit.prevent="submit"
        >
            <AdminPanel title="Nội dung phản hồi">
                <div class="space-y-5">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="space-y-2">
                            <Label for="feedback-name" class="text-foreground">
                                Họ tên <span class="text-destructive">*</span>
                            </Label>
                            <input
                                id="feedback-name"
                                v-model="form.name"
                                type="text"
                                class="h-10 w-full rounded-lg border border-input bg-background px-3 text-sm shadow-xs transition-[color,box-shadow] outline-none placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                                placeholder="Nguyễn Văn A"
                            />
                            <p
                                v-if="form.errors.name"
                                class="text-xs text-destructive"
                            >
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="feedback-role" class="text-foreground">
                                Vai trò / Chức danh
                            </Label>
                            <input
                                id="feedback-role"
                                v-model="form.role"
                                type="text"
                                class="h-10 w-full rounded-lg border border-input bg-background px-3 text-sm shadow-xs transition-[color,box-shadow] outline-none placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                                placeholder="Chủ vườn"
                            />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <Label class="text-foreground">
                            Mức đánh giá <span class="text-destructive">*</span>
                        </Label>
                        <div class="flex items-center gap-2">
                            <button
                                v-for="star in 5"
                                :key="star"
                                type="button"
                                class="rounded-md p-1 transition hover:bg-accent"
                                :aria-label="`${star} sao`"
                                @click="form.rating = star"
                            >
                                <Star
                                    class="size-6 transition"
                                    :class="
                                        star <= form.rating
                                            ? 'fill-amber-400 text-amber-500'
                                            : 'text-muted-foreground/40'
                                    "
                                />
                            </button>
                            <span class="ml-1 text-sm text-muted-foreground">
                                {{ form.rating }} / 5
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <Label for="feedback-content" class="text-foreground">
                            Nội dung <span class="text-destructive">*</span>
                        </Label>
                        <Textarea
                            id="feedback-content"
                            v-model="form.content"
                            rows="6"
                            class="min-h-32 w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm shadow-xs transition-[color,box-shadow] outline-none placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                            placeholder="Chia sẻ trải nghiệm của khách hàng..."
                        />
                        <p
                            v-if="form.errors.content"
                            class="text-xs text-destructive"
                        >
                            {{ form.errors.content }}
                        </p>
                    </div>

                    <div class="space-y-3">
                        <Label class="text-foreground">
                            Ảnh cây trồng của khách
                        </Label>
                        <p class="text-xs text-muted-foreground">
                            Mỗi ảnh tối đa 4MB, định dạng jpg, png, webp hoặc
                            gif.
                        </p>

                        <div class="space-y-3">
                            <div
                                v-for="(photo, index) in form.photos"
                                :key="index"
                                class="rounded-lg border border-border/70 bg-muted/30 p-3"
                            >
                                <FeedbackImageField
                                    :model-value="photo"
                                    :label="`Ảnh ${index + 1}`"
                                    @update:model-value="
                                        updatePhoto(index, $event)
                                    "
                                />

                                <Button
                                    type="button"
                                    variant="ghost"
                                    size="sm"
                                    class="mt-2 text-destructive hover:text-destructive"
                                    @click="removePhoto(index)"
                                >
                                    <Trash2 />
                                    Xoá ảnh này
                                </Button>
                            </div>

                            <Button
                                type="button"
                                variant="outline"
                                size="sm"
                                @click="addPhoto"
                            >
                                <ImagePlus />
                                Thêm ảnh cây trồng
                            </Button>
                        </div>

                        <p
                            v-if="form.errors.photos"
                            class="text-xs text-destructive"
                        >
                            {{ form.errors.photos }}
                        </p>
                    </div>
                </div>
            </AdminPanel>

            <div class="space-y-5">
                <AdminPanel title="Ảnh đại diện">
                    <FeedbackImageField
                        v-model="form.image"
                        label="Ảnh khách hàng"
                    />
                </AdminPanel>

                <AdminPanel title="Tuỳ chọn hiển thị">
                    <div class="space-y-5">
                        <div class="space-y-2">
                            <Label for="feedback-sort" class="text-foreground">
                                Thứ tự hiển thị
                            </Label>
                            <input
                                id="feedback-sort"
                                v-model.number="form.sort_order"
                                type="number"
                                min="0"
                                class="h-10 w-full rounded-lg border border-input bg-background px-3 text-sm shadow-xs transition-[color,box-shadow] outline-none placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                            />
                            <p class="text-xs text-muted-foreground">
                                Số lớn hơn sẽ hiển thị trước.
                            </p>
                        </div>

                        <label
                            class="flex cursor-pointer items-center gap-3 rounded-lg border border-border/70 p-3 transition hover:bg-accent/50"
                        >
                            <input
                                v-model="form.is_featured"
                                type="checkbox"
                                class="size-4 shrink-0 rounded border-input accent-primary"
                            />
                            <span class="text-sm font-medium text-foreground">
                                Đánh dấu là phản hồi nổi bật
                            </span>
                        </label>
                    </div>
                </AdminPanel>

                <Button
                    type="submit"
                    class="w-full"
                    :disabled="form.processing"
                >
                    <Save />
                    {{ form.processing ? 'Đang lưu...' : 'Lưu phản hồi' }}
                </Button>
            </div>
        </form>
    </div>
</template>
