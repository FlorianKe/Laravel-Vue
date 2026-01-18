<script setup lang="ts"></script>

<template>
    <h2 class="text-2xl font-bold">
        <slot name="title" />
    </h2>
    <p class="text-sm text-muted-foreground italic">
        <slot name="description" />
    </p>
</template>
