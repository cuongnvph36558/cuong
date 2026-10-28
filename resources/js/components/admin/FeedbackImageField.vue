<script setup lang="ts">
import { Image, Trash2, Upload } from '@lucide/vue';
import { ref } from 'vue';
import { useHttp } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { upload as feedbackUpload } from '@/routes/admin/feedbacks';

type Props = {
    /** Current image path. */
    modelValue: string;
    /** Field label shown above the input. */
    label: string;
};

const props = defineProps<Props>();

const emit = defineEmits<{
    (e: 'update:modelValue', payload: string): void;
}>();

type UploadResponse = {
    message: string;
    path: string;
};

const fileInput = ref<HTMLInputElement | null>(null);

const upload = useHttp<{ image: File }, UploadResponse>({
    image: null as unknown as File,
});

function browse(): void {
    fileInput.value?.click();
}

async function onFileChange(event: Event): Promise<void> {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0];

    if (!file) {
        return;
    }

    upload.image = file;

    try {
        const response = await upload.post(feedbackUpload().url, {
            onError: (errors) => {
                toast.error(
                    Object.values(errors).flat().join(' ') ||
                        'Không tải được ảnh lên.',
                );
            },
        });

        if (response?.path) {
            emit('update:modelValue', response.path);
            toast.success('Đã tải ảnh lên thành công.');
        }
    } catch {
        toast.error('Không tải được ảnh lên.');
    } finally {
        input.value = '';
    }
}

function clear(): void {
    emit('update:modelValue', '');
}
</script>

<template>
    <div class="space-y-2">
        <Label class="text-foreground">{{ props.label }}</Label>

        <div class="flex items-start gap-3">
            <div
                class="flex size-24 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-border/70 bg-muted"
            >
                <img
                    v-if="props.modelValue"
                    :src="props.modelValue"
                    :alt="props.label"
                    class="size-full object-cover"
                />
                <Image v-else class="size-6 text-muted-foreground" />
            </div>

            <div class="min-w-0 flex-1 space-y-2">
                <p class="truncate text-xs text-muted-foreground">
                    {{ props.modelValue || 'Chưa chọn ảnh' }}
                </p>

                <div class="flex flex-wrap items-center gap-2">
                    <Button
                        type="button"
                        variant="outline"
                        size="sm"
                        :disabled="upload.processing"
                        @click="browse"
                    >
                        <Upload />
                        {{ upload.processing ? 'Đang tải...' : 'Tải ảnh lên' }}
                    </Button>

                    <Button
                        v-if="props.modelValue"
                        type="button"
                        variant="ghost"
                        size="sm"
                        class="text-destructive hover:text-destructive"
                        @click="clear"
                    >
                        <Trash2 />
                        Xoá
                    </Button>
                </div>
            </div>
        </div>

        <input
            ref="fileInput"
            type="file"
            class="hidden"
            accept="image/*"
            @change="onFileChange"
        />
    </div>
</template>
