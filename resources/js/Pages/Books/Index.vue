<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

const props = defineProps<{
    books: {
        data: Array<{
            id: number;
            title: string;
            author: string;
            published_year: number;
            description: string;
            cover_image: string;
        }>;
        current_page: number;
        last_page: number;
    };
}>();
</script>

<template>
    <Head title="Books" />
    <AppLayout>
        <div class="radial-gradient">
            <div class="container mx-auto py-12">
                <h1
                    class="mb-10 text-center font-serif text-6xl tracking-tight text-white drop-shadow-md"
                >
                    Featured Books
                </h1>

                <div
                    v-if="props.books.data.length === 0"
                    class="text-center text-gray-500"
                >
                    No books found.
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 gap-10 p-4 sm:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="book in props.books.data"
                        :key="book.id"
                        class="rounded-lg bg-gray-50 shadow-xl"
                    >
                        <!-- Use Inertia's Link component for navigation -->
                        <Link
                            :href="`/books/${book.id}`"
                            class="block cursor-pointer"
                        >
                            <img
                                :src="book.cover_image"
                                alt="{{ props.book.title }}"
                                class="rounded-lg-t mb-2 h-52 w-full overflow-hidden rounded-t-lg object-cover"
                            />
                            <div class="p-4">
                                <h2 class="mb-2 text-lg font-bold leading-none">
                                    {{ book.title }}
                                </h2>
                                <p class="text-sm text-gray-600">
                                    Author: {{ book.author }}
                                </p>
                                <p class="mt-2 text-blue-800">View Details</p>
                            </div>
                        </Link>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="props.books.last_page > 1" class="pagination">
                    <Link
                        v-if="props.books.current_page > 1"
                        :href="`/books?page=${props.books.current_page - 1}`"
                    >
                        Previous
                    </Link>
                    <Link
                        v-if="props.books.current_page < props.books.last_page"
                        :href="`/books?page=${props.books.current_page + 1}`"
                    >
                        Next
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
