<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import { router, useForm } from '@inertiajs/vue3';
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
    isFeatured: props.book.isFeatured === 1 ? 'Yes' : 'No',
});

const submit = () => {
    form.isFeatured = form.isFeatured === 'Yes' ? 1 : 0;

    form.put(route('books.update', props.book.id));
};

const deleteBook = async () => {
    if (confirm('Are you sure you want to delete this book?')) {
        await axios.delete(route('books.destroy', props.book.id));
        router.visit(route('dashboard'), { preserveState: false });
    }
};
</script>

<template>
    <AppLayout>
        <div class="container mx-auto max-w-[500px] p-6">
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
                    <p
                        v-if="form.errors?.title"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.title }}
                    </p>
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
                    <p
                        v-if="form.errors?.author"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.author }}
                    </p>
                </div>
                <div class="mt-6">
                    <label
                        for="publisher"
                        class="block text-sm font-medium text-gray-700"
                        >Publisher</label
                    >
                    <input
                        v-model="form.publisher"
                        type="text"
                        id="publisher"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2"
                        required
                    />
                    <p
                        v-if="form.errors?.publisher"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.publisher }}
                    </p>
                </div>

                <div class="mt-6">
                    <label
                        for="isbn"
                        class="block text-sm font-medium text-gray-700"
                        >Isbn</label
                    >
                    <input
                        v-model="form.isbn"
                        type="text"
                        id="isbn"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2"
                        required
                    />
                    <p
                        v-if="form.errors?.isbn"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.isbn }}
                    </p>
                </div>

                <div class="mt-6">
                    <label
                        for="category"
                        class="block text-sm font-medium text-gray-700"
                        >Category</label
                    >
                    <input
                        v-model="form.category"
                        type="text"
                        id="category"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2"
                        required
                    />
                    <p
                        v-if="form.errors?.category"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.category }}
                    </p>
                </div>

                <div class="mt-6">
                    <label
                        for="cover_image"
                        class="block text-sm font-medium text-gray-700"
                        >Cover_image</label
                    >
                    <input
                        v-model="form.cover_image"
                        type="text"
                        id="cover_image"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2"
                        required
                    />
                    <p
                        v-if="form.errors?.cover_image"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.cover_image }}
                    </p>
                </div>

                <div class="mt-6">
                    <label
                        for="summary"
                        class="block text-sm font-medium text-gray-700"
                        >Summary</label
                    >
                    <textarea
                        v-model="form.summary"
                        name="summary"
                        id="summary"
                        rows="3"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    ></textarea>
                    <p
                        v-if="form.errors?.summary"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.summary }}
                    </p>
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
                    <p
                        v-if="form.errors?.published_year"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.published_year }}
                    </p>
                </div>
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700"
                        >Is Featured</label
                    >
                    <div class="flex items-center">
                        <input
                            v-model="form.isFeatured"
                            type="radio"
                            value="Yes"
                            id="featuredYes"
                            name="isFeatured"
                            class="mr-2"
                        />
                        <label for="featuredYes" class="mr-4">Yes</label>
                        <input
                            v-model="form.isFeatured"
                            type="radio"
                            value="No"
                            id="featuredNo"
                            name="isFeatured"
                            class="mr-2"
                        />
                        <label for="featuredNo">No</label>
                    </div>
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
