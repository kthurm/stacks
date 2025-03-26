<script setup lang="ts">
import NavBar from '../Components/NavBar.vue';
</script>
<template>
    <NavBar />
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:pt-12"
    >
        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
