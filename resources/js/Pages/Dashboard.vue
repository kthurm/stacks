<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps<{
    books: {
        data: Array<{
            id: number;
            title: string;
            author: string;
            published_year: number;
            summary: string;
            cover_image: string;
            isCheckedOut: boolean;
        }>;
        user: {
            role: string;
        };
        current_page: number;
        last_page: number;
        next_page_url: string | null;
        prev_page_url: string | null;
    };
}>();

const returnBook = (bookId: number) => {
    router.post(
        route('books.return', bookId),
        {},
        {
            onFinish: () => {
                console.log('it worked');
            },
            onError: (err) => {
                console.error('Error returning book:', err);
            },
        },
    );
};
</script>
<template>
    <AppLayout>
        <div class="w-full overflow-hidden rounded-lg border border-stone-200">
            <div class="mx-auto max-w-[550px] p-4">
                <h1 class="py-5 text-2xl font-semibold text-stone-800">
                    Hey,
                    <span class="capitalize">{{
                        $page.props.user?.role || 'there'
                    }}</span
                    >!
                </h1>

                <table class="border">
                    <tbody class="group text-sm text-stone-800">
                        <tr
                            v-for="book in props.books.data"
                            :key="book.id"
                            class="border-b border-stone-200 last:border-0"
                        >
                            <td class="hidden p-3 md:block">
                                <img
                                    :src="book.cover_image"
                                    alt="{{ props.book.title }}"
                                    class="rounded-lg-t object-fit mb-2 h-auto w-auto overflow-hidden"
                                />
                            </td>
                            <td class="p-3">
                                Title: <b>{{ book.title }}</b> <br />Author:
                                <b>{{ book.author }}</b>
                            </td>

                            <td class="p-3">
                                {{
                                    book.isCheckedOut
                                        ? 'Checked Out'
                                        : 'Available'
                                }}
                                <span v-if="book.isCheckedOut">
                                    <form
                                        @submit.prevent="returnBook(book.id)"
                                        method="POST"
                                        class="inline-block leading-none"
                                    >
                                        <button
                                            type="submit"
                                            class="rounded-md bg-green-500 px-3 py-1 text-white md:ml-2"
                                        >
                                            Return
                                        </button>
                                    </form>
                                </span>
                            </td>

                            <td class="p-3">
                                <button
                                    class="ml-2 rounded-md bg-blue-900 px-3 py-1 text-white"
                                >
                                    <Link :href="route('books.edit', book.id)"
                                        >Edit</Link
                                    >
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination Controls -->
                <div class="mt-4 flex justify-between">
                    <div>
                        <Link
                            v-if="props.books.prev_page_url"
                            :href="props.books.prev_page_url"
                            class="inline-block text-blue-500"
                        >
                            Previous
                        </Link>
                    </div>

                    <div class="text-sm">
                        Page {{ props.books.current_page }} of
                        {{ props.books.last_page }}
                    </div>

                    <div>
                        <Link
                            v-if="props.books.next_page_url"
                            :href="props.books.next_page_url"
                            class="inline-block text-blue-500"
                        >
                            Next
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
