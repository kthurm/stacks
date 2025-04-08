<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';

const { flash } = usePage().props;
const form = useForm({
    title: '',
    author: '',
    published_year: '',
    publisher: '',
    isbn: '',
    page_count: '',
    summary: '',
    category: '',
    cover_image: '',
    isFeatured: false,
    stock: 1,
    available: 1,
});

const submit = () => {
    form.post(route('books.store'), {
        onSuccess: (response) => {
            console.log('Success response:', response);
            alert(flash.success || 'Book created successfully!');
            router.visit('dashboard');
        },
        onError: (errors) => {
            console.log('Error response:', errors);
            alert(flash.error || 'Something went wrong, please try again.');
        },
    });
};
</script>

<template>
    <Head title="Create a New Book" />
    <AppLayout>
        <div class="container mx-auto mt-5 max-w-3xl border p-4 shadow">
            <h1 class="my-5 text-4xl">Add a Book</h1>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label
                        for="title"
                        class="block text-sm font-medium text-gray-700"
                        >Title</label
                    >
                    <input
                        id="title"
                        type="text"
                        v-model="form.title"
                        v-on:focus="form.clearErrors('title')"
                        class="mt-1 block w-full rounded-md border border-gray-300 p-2"
                        required
                    />
                    <p
                        v-if="form.errors?.title"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.title }}
                    </p>
                </div>

                <div>
                    <label
                        for="author"
                        class="block text-sm font-medium text-gray-700"
                        >Author</label
                    >
                    <input
                        id="author"
                        type="text"
                        v-model="form.author"
                        class="mt-1 block w-full rounded-md border border-gray-300 p-2"
                        required
                    />
                    <p
                        v-if="form.errors?.author"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.author }}
                    </p>
                </div>

                <div>
                    <label
                        for="category"
                        class="block text-sm font-medium text-gray-700"
                        >Category</label
                    >
                    <input
                        id="category"
                        type="text"
                        v-model="form.category"
                        class="mt-1 block w-full rounded-md border border-gray-300 p-2"
                        required
                    />
                    <p
                        v-if="form.errors?.category"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.category }}
                    </p>
                </div>

                <div>
                    <label
                        for="published_year"
                        class="block text-sm font-medium text-gray-700"
                        >Published Year</label
                    >
                    <input
                        id="published_year"
                        type="number"
                        v-model="form.published_year"
                        class="mt-1 block w-full rounded-md border border-gray-300 p-2"
                        required
                        min="1900"
                        max="2100"
                    />
                    <p
                        v-if="form.errors?.published_year"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.published_year }}
                    </p>
                </div>

                <div>
                    <label
                        for="publisher"
                        class="block text-sm font-medium text-gray-700"
                        >Publisher</label
                    >
                    <input
                        id="publisher"
                        type="text"
                        v-model="form.publisher"
                        class="mt-1 block w-full rounded-md border border-gray-300 p-2"
                    />
                    <p
                        v-if="form.errors?.publisher"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.publisher }}
                    </p>
                </div>

                <div>
                    <label
                        for="isbn"
                        class="block text-sm font-medium text-gray-700"
                        >ISBN</label
                    >
                    <input
                        id="isbn"
                        type="text"
                        v-model="form.isbn"
                        class="mt-1 block w-full rounded-md border border-gray-300 p-2"
                    />
                    <p
                        v-if="form.errors?.isbn"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.isbn }}
                    </p>
                </div>

                <div>
                    <label
                        for="page_count"
                        class="block text-sm font-medium text-gray-700"
                        >Page Count</label
                    >
                    <input
                        id="page_count"
                        type="number"
                        v-model="form.page_count"
                        class="mt-1 block w-full rounded-md border border-gray-300 p-2"
                    />
                    <p
                        v-if="form.errors?.page_count"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.page_count }}
                    </p>
                </div>

                <div>
                    <label
                        for="summary"
                        class="block text-sm font-medium text-gray-700"
                        >Summary</label
                    >
                    <textarea
                        id="summary"
                        v-model="form.summary"
                        class="mt-1 block w-full rounded-md border border-gray-300 p-2"
                    ></textarea>
                    <p
                        v-if="form.errors?.summary"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.summary }}
                    </p>
                </div>

                <div>
                    <label
                        for="cover_image_url"
                        class="block text-sm font-medium text-gray-700"
                        >Cover Image URL</label
                    >
                    <input
                        id="cover_image_url"
                        type="text"
                        v-model="form.cover_image"
                        class="mt-1 block w-full rounded-md border border-gray-300 p-2"
                    />
                    <p
                        v-if="form.errors?.cover_image"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.cover_image }}
                    </p>
                </div>

                <div>
                    <label
                        for="isFeatured"
                        class="block text-sm font-medium text-gray-700"
                        >Featured</label
                    >
                    <input
                        id="isFeatured"
                        type="checkbox"
                        v-model="form.isFeatured"
                        class="mr-2 mt-1"
                    />
                    <span class="text-sm text-gray-500"
                        >Mark this book as featured</span
                    >
                </div>

                <div>
                    <label
                        for="stock"
                        class="block text-sm font-medium text-gray-700"
                        >Stock</label
                    >
                    <input
                        id="stock"
                        type="number"
                        v-model="form.stock"
                        class="mt-1 block w-full rounded-md border border-gray-300 p-2"
                        required
                    />
                    <p
                        v-if="form.errors?.stock"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.stock }}
                    </p>
                </div>

                <div>
                    <label
                        for="available"
                        class="block text-sm font-medium text-gray-700"
                        >Available</label
                    >
                    <input
                        id="available"
                        type="number"
                        v-model="form.available"
                        class="mt-1 block w-full rounded-md border border-gray-300 p-2"
                        required
                    />
                    <p
                        v-if="form.errors?.available"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.available }}
                    </p>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button
                        type="submit"
                        class="rounded-md bg-blue-900 px-3 py-2 font-bold text-white hover:bg-blue-500"
                    >
                        Create Book
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
