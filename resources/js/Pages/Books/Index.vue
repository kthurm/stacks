<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { debounce } from 'lodash';
import { ref, watch } from 'vue';

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
        sortOption: string;
        filters: {
            search: string | null;
            sort: string;
        };
    };
    noResults: boolean;
}>();

let search = ref(props.books.filters.search || '');
let sortOption = ref(props.books.filters.sort || 'created_at');

const debouncedSearch = debounce(() => {
    Inertia.get(
        route('books.index'),
        {
            search: search.value,
            sort: sortOption.value,
            page: props.books.current_page,
        },
        {
            preserveState: true,
            replace: true,
        },
    );
}, 300);

watch(search, () => {
    debouncedSearch();
});

watch(sortOption, () => {
    Inertia.get(
        route('books.index'),
        {
            search: search.value,
            sort: sortOption.value,
            page: props.books.current_page,
        },
        {
            preserveState: true,
            replace: true,
        },
    );
});
const clearSearch = () => {
    search.value = '';
    Inertia.get(
        route('books.index'),
        {
            search: '',
            sort: sortOption.value,
            page: props.books.current_page,
        },
        {
            preserveState: true,
            replace: true,
        },
    );
};
</script>

<template>
    <Head title="Books" />

    <AppLayout>
        <div class="radial-gradient min-h-screen">
            <div class="container mx-auto py-3 lg:py-12">
                <h1
                    class="mb-6 text-center font-serif text-6xl tracking-tight text-white drop-shadow-md lg:my-2"
                >
                    Featured Books
                </h1>

                <div
                    class="flex items-center justify-end pr-4 text-right text-xs"
                >
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search"
                        class="mr-1 rounded border-gray-300 bg-gray-100 p-1"
                    />

                    <button @click="clearSearch" class="mr-4 block text-white">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"
                            />
                        </svg>
                    </button>
                    <select
                        v-model="sortOption"
                        class="w-[145px] rounded border-gray-300 bg-gray-100 p-1 pl-2"
                    >
                        <option value="created_at">Last Added</option>
                        <option value="title">Title A-Z</option>
                        <option value="published_year">Published Year</option>
                        <option value="author">Author A-Z</option>
                    </select>
                </div>

                <div
                    v-if="props.noResults"
                    class="mx-auto my-10 w-fit rounded border border-blue-900 bg-gray-100 p-5 text-center text-blue-900 shadow-lg"
                >
                    <p>
                        <b> No results found for:</b> "{{ search }}".<br />
                        Please try a different term.
                    </p>
                </div>

                <div
                    v-if="!props.noResults && props.books.data.length === 0"
                    class="text-center text-gray-500"
                >
                    No books available.
                </div>

                <div
                    class="grid grid-cols-1 gap-10 p-4 sm:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="book in props.books.data"
                        :key="book.id"
                        class="rounded-lg bg-gray-50 shadow-xl"
                    >
                        <Link
                            :href="`/books/${book.id}`"
                            class="block cursor-pointer"
                        >
                            <img
                                :src="book.cover_image"
                                alt="book.title"
                                class="rounded-lg-t mb-2 h-80 w-full overflow-hidden rounded-t-lg object-cover"
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
            </div>
        </div>
    </AppLayout>
</template>
