<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <Link
        :href="href"
        class="inline-flex items-center rounded-md border border-transparent bg-blue-900 px-2 py-1 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-blue-600 focus:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-blue-500 md:px-4 md:py-2"
    >
        <slot />
    </Link>
</template>
