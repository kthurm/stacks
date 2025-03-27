<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>
<template>
    <div
        class="radial-gradient flex min-h-screen flex-col items-center pt-6 sm:pt-12"
    >
        <ApplicationLogo class="h-9 w-auto fill-current text-white sm:h-16" />
        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
