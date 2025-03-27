<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps<{
    books: {
        data: Array<{
            id: number;
            title: string;
            author: string;
            published_year: number;
            summary: string;
            cover_image: string;
        }>;
        current_page: number;
        last_page: number;
    };
}>();
</script>
<template>
    <AppLayout>
        <div class="w-full overflow-hidden rounded-lg border border-stone-200">
            <div class="mx-auto max-w-7xl p-4">
                <h1 class="py-5 text-2xl font-semibold text-stone-800">
                    Hey,
                    <span class="capitalize">{{
                        $page.props.user?.role || 'there'
                    }}</span
                    >!
                </h1>

                <table class="w-full border">
                    <thead
                        class="border-b border-stone-200 bg-stone-100 text-start text-sm font-medium text-stone-600"
                    >
                        <tr>
                            <th class="px-2.5 py-2">Cover Image</th>
                            <th class="px-2.5 py-2">Book Title</th>
                            <th class="px-2.5 py-2">Author</th>

                            <th class="px-2.5 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="group text-sm text-stone-800">
                        <tr
                            v-for="book in props.books.data"
                            :key="book.id"
                            class="border-b border-stone-200 last:border-0"
                        >
                            <td class="p-3">
                                <img
                                    :src="book.cover_image"
                                    alt="{{ props.book.title }}"
                                    class="rounded-lg-t object-fit mb-2 h-24 w-auto overflow-hidden"
                                />
                            </td>
                            <td class="p-3">{{ book.title }}</td>
                            <td class="p-3">{{ book.author }}</td>

                            <td class="p-3">
                                <Link :href="route('books.edit', book.id)"
                                    >Edit</Link
                                >
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
