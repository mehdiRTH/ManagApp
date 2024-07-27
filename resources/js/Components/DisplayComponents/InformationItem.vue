<script lang="ts" setup></script>
<template>
    <div
        class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
        <p class="text-sm text-gray-600">
            <slot name="label" />
        </p>
        <p class="text-base font-medium w-full">
            <slot name="value" />
        </p>
    </div>
</template>
