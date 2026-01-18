<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem, Quote } from '@/types';

defineProps<{ quote: Quote }>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
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
            <template v-slot:description>{{ quote.quote }} - {{ quote.author }}</template>
        </PageHeader>
    </AppLayout>
</template>
