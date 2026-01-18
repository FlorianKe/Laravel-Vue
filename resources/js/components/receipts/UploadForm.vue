<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/receipts';

const form = useForm({
    receipt: null,
});

const fileInput = ref<HTMLInputElement | null>(null);

function submit() {
    form.post(store().url, {
        onSuccess: () => {
            if (fileInput.value) {
                fileInput.value.value = '';
            }
        },
    });
}
</script>

<template>
    <div class="w-1/3">
        <div class="upload-card">
            <h3 class="text-lg font-semibold">Scanner</h3>

            <form @submit.prevent="submit" class="flex flex-col gap-2">
                <input
                    ref="fileInput"
                    type="file"
                    @input="form.receipt = $event.target.files[0]"
                />
                <InputError :message="form.errors.receipt" />
                <Button type="submit" :disabled="!form.isDirty">
                    <Spinner v-if="form.processing" />
                    Upload
                </Button>
            </form>
        </div>
    </div>
</template>
