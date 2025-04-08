<script setup lang="ts">
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const { flash } = usePage().props;

const props = defineProps<{
    book: {
        id: number;
        title: string;
        author: string;
        published_year: number;
        summary: string;
        cover_image: string;
        publisher: string;
        page_count: number;
        category: string;
        rating: number;
        available: boolean;
        stock: number;
        isbn: string;
        borrowed_at: string | null;
        due_date: string | null;
        isCheckedOut: boolean;
    };

    user: {
        role: string;
    };
}>();

const form = useForm({
    book_id: props.book.id,
    user_id: '',
});

const borrowBook = () => {
    form.submit('post', route('books.borrow', props.book.id), {
        onSuccess: (response) => {
            console.log('Success response:', response);
            alert(flash.success || 'Happy Reading!');
        },
        onError: (errors) => {
            console.log('Error response:', errors);
            alert(flash.error || 'Something went wrong, please try again.');
        },
    });
};
</script>

<template>
    <Head title="Book Details" />
    <AppLayout>
        <div
            class="max-w-9xl container mx-auto flex flex-col px-2 pt-10 lg:flex-row lg:space-x-14"
        >
            <div class="flex flex-col items-center">
                <img
                    :src="props.book.cover_image"
                    alt="{{ props.book.title }}"
                    class="mx-auto mb-6 w-60 max-w-60 shadow-xl"
                />

                <PrimaryButton
                    @click="borrowBook"
                    :disabled="!props.book.available || props.book.stock <= 0"
                    :class="{
                        'pointer-events-none bg-gray-500 hover:bg-gray-500': !(
                            props.book.available && props.book.stock > 0
                        ),
                        'bg-blue-900':
                            props.book.available && props.book.stock > 0,
                    }"
                >
                    {{
                        props.book.available && props.book.stock > 0
                            ? 'Borrow'
                            : 'Unavailable'
                    }}
                </PrimaryButton>
                <div v-if="book.borrowed_at && book.due_date">
                    <p class="mt-2 text-xs">
                        Due Date:
                        {{
                            new Date(book.due_date).toLocaleDateString(
                                'en-US',
                                {
                                    month: 'long',
                                    day: 'numeric',
                                    year: 'numeric',
                                },
                            )
                        }}
                    </p>
                </div>
            </div>

            <div class="my-3">
                <div class="mb-3 flex space-x-2 text-xs uppercase">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-3"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3"
                        />
                    </svg>
                    <Link :href="route('books.index')">All Books</Link>
                </div>

                <h1 class="mb-4 font-serif text-3xl tracking-tight">
                    {{ props.book.title }}
                </h1>
                <div class="mt-4 text-sm text-gray-600">
                    <p>
                        <span class="font-bold">Author:</span>
                        {{ props.book.author }}
                    </p>
                    <p>
                        <span class="font-bold">Published:</span>
                        {{ props.book.published_year }}
                    </p>
                    <p>
                        <span class="font-bold">{{ props.book.category }}</span>
                    </p>
                    <p>
                        <span class="font-bold">Pages:</span>
                        {{ props.book.page_count }}
                    </p>
                    <p class="mt-5 text-left">{{ props.book.summary }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
