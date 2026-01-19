<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

import PageHeader from '@/components/PageHeader.vue';
import UploadForm from '@/components/receipts/UploadForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { index } from '@/routes/receipts';
import { type BreadcrumbItem, Receipts } from '@/types';

defineProps<{ receipts: Receipts[] }>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: index().url,
    },
];
const page = usePage();
const name = computed(() => page.props.auth.user.name);
</script>

<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <PageHeader>
            <template v-slot:title> Hello, {{ name }}! </template>
        </PageHeader>

        <div class="mt-8 flex w-full gap-4">
            <div class="w-2/3">
                <h3 class="text-lg font-semibold">All your receipts</h3>
                <ul class="unstiled-list">
                    <li
                        v-for="receipt in receipts"
                        :key="receipt.id"
                        class="py-1"
                    >
                        {{ receipt.merchant }} - {{ receipt.total }}€ -
                        {{ receipt.vat }}%
                    </li>
                </ul>
            </div>
            <UploadForm />
        </div>
    </AppLayout>
</template>
