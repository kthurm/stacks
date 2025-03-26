<script setup lang="ts">
import { defineProps } from 'vue';

// Define props for data passed from the controller
const props = defineProps<{
    books: Array<{ id: number; title: string; author: string }>;
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div
                            class="my-4 grid grid-cols-1 flex-wrap justify-between gap-3 rounded-md sm:grid-cols-2 lg:grid-cols-4"
                        >
                            <h1>Test Books</h1>

                            <!-- Loop through books and display them -->
                            <div
                                v-for="book in props.books"
                                :key="book.id"
                                class="my-2"
                            >
                                <h3>{{ book.title }}</h3>
                                <p>Author: {{ book.author }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
