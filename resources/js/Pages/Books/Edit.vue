<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';
import { defineProps } from 'vue';

const props = defineProps({
    book: Object,
});

const form = useForm({
    title: props.book.title,
    author: props.book.author,
    published_year: props.book.published_year,
    publisher: props.book.publisher,
    isbn: props.book.isbn,
    page_count: props.book.page_count,
    summary: props.book.summary,
    category: props.book.category,
    cover_image: props.book.cover_image,
});

const submit = () => {
    form.put(route('books.update', props.book.id));
};

const deleteBook = async () => {
    if (confirm('Are you sure you want to delete this book?')) {
        await axios.delete(route('books.destroy', props.book.id));
        Inertia.visit(route('dashboard'), { preserveState: false });
    }
};
</script>

<template>
    <AppLayout>
        <div class="container mx-auto p-6">
            <h1 class="text-3xl font-semibold">Edit Book</h1>

            <form @submit.prevent="submit">
                <div class="mt-6">
                    <label
                        for="title"
                        class="block text-sm font-medium text-gray-700"
                        >Title</label
                    >
                    <input
                        v-model="form.title"
                        type="text"
                        id="title"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2"
                        required
                    />
                </div>

                <div class="mt-6">
                    <label
                        for="author"
                        class="block text-sm font-medium text-gray-700"
                        >Author</label
                    >
                    <input
                        v-model="form.author"
                        type="text"
                        id="author"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2"
                        required
                    />
                </div>

                <div class="mt-6">
                    <label
                        for="published_year"
                        class="block text-sm font-medium text-gray-700"
                        >Published Year</label
                    >
                    <input
                        v-model="form.published_year"
                        type="number"
                        id="published_year"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2"
                        required
                    />
                </div>

                <div class="mt-6">
                    <button
                        type="submit"
                        class="rounded bg-blue-600 px-4 py-2 text-white"
                    >
                        Save Changes
                    </button>
                </div>
            </form>

            <button
                @click="deleteBook"
                class="mt-4 rounded bg-red-600 px-4 py-2 text-white"
            >
                Delete Book
            </button>
        </div>
    </AppLayout>
</template>
