<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

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
});

// Handle form submission
const submit = () => {
    form.post(route('books.store'), {
        onFinish: () => {
            if (!form.errors.length) {
                // Redirect to dashboard if no validation errors
                Inertia.visit(route('dashboard'));
            }
        },
    });
};
</script>

<template>
    <Head title="Create a New Book" />
    <AppLayout>
        <div class="container mx-auto mt-5 max-w-3xl border p-4 shadow">
            <h1 class="my-5 text-4xl">Add a Book</h1>

            <!-- Book creation form -->
            <form @submit.prevent="submit" class="space-y-4">
                <!-- Book Title -->
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
                        class="mt-1 block w-full rounded-md border border-gray-300 p-2"
                        required
                    />
                    <p
                        v-if="form.errors.title"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.title }}
                    </p>
                </div>

                <!-- Book Author -->
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
                        v-if="form.errors.author"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.author }}
                    </p>
                </div>

                <!-- Category -->
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
                        v-if="form.errors.category"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.category }}
                    </p>
                </div>

                <!-- Published Year -->
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
                        v-if="form.errors.published_year"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.published_year }}
                    </p>
                </div>

                <!-- Publisher -->
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
                        v-if="form.errors.publisher"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.publisher }}
                    </p>
                </div>

                <!-- ISBN -->
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
                        v-if="form.errors.isbn"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.isbn }}
                    </p>
                </div>

                <!-- Page Count -->
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
                        v-if="form.errors.page_count"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.page_count }}
                    </p>
                </div>

                <!-- Summary -->
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
                        v-if="form.errors.summary"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.summary }}
                    </p>
                </div>

                <!-- Book Cover Image URL -->
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
                        v-if="form.errors.cover_image"
                        class="mt-1 text-xs text-red-600"
                    >
                        {{ form.errors.cover_image }}
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
