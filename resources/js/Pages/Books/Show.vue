<script setup lang="ts">
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';

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
    };
    user: {
        role: string;
    };
}>();

const form = useForm('');
function borrowBook() {
    form.post(route('books.borrow', props.book.id), {
        onSuccess: () => {},
        onError: (errors) => {
            console.error(errors);
        },
    });
}
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
                    class="mx-auto mb-2 w-60 max-w-60 shadow-xl"
                />
                <!-- Ratings -->
                <div
                    class="justified-center mx-auto mb-4 mt-5 flex w-fit space-x-1"
                >
                    <template v-for="index in 5">
                        <svg
                            v-if="index <= props.book.rating"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="h-5 w-5 text-yellow-500"
                            :key="'filled-' + index"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                clip-rule="evenodd"
                            />
                        </svg>

                        <svg
                            v-else
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="h-5 w-5 text-gray-300"
                            :key="'empty-' + index"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M12 17.27l6.18 3.73-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73-1.64 7.03L12 17.27z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </template>
                </div>

                <template v-if="props.user">
                    <PrimaryButton
                        @click="borrowBook"
                        :disabled="
                            !props.book.available || props.book.stock <= 0
                        "
                        :class="{
                            'pointer-events-none bg-gray-500 hover:bg-gray-500':
                                !(props.book.available && props.book.stock > 0),
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
                </template>
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

                    <p class="mt-5 text-left">
                        {{ props.book.summary }}
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
