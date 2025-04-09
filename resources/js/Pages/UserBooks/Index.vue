<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    books: Array,
});

const books = ref(props.books);

const submitRating = (bookId, rating) => {
    console.log('Submitting rating:', rating);

    const form = useForm({
        rating: rating,
        review: review,
    });

    form.post(route('userbooks.rate', bookId), {
        onSuccess: () => {
            const book = books.value.find((book) => book.id === bookId);
            if (book) {
                book.rating = rating;
            }
            alert('Rating submitted!');
        },
        onError: (errors) => {
            console.error(errors);
            alert('There was an error submitting the rating: ' + errors.rating);
        },
    });
};
const submitReview = (bookId, review) => {
    const form = useForm();
    form.post(route('userbooks.review', bookId), {
        review: review,
        onSuccess: () => {
            const book = books.value.find((book) => book.id === bookId);
            if (book) {
                book.review = review;
            }
            alert('Review submitted!');
        },
    });
};
</script>

<template>
    <Head title="User's Book" />
    <AppLayout>
        <div class="max-w-9xl container mx-auto flex flex-col px-2 pt-10">
            <h1 class="text-center font-serif text-6xl text-blue-900">
                My Books
            </h1>
            <div
                class="grid grid-cols-1 gap-10 p-4 sm:grid-cols-2 lg:grid-cols-4"
            >
                <div
                    v-for="book in books"
                    :key="book.id"
                    class="flex w-60 flex-col justify-between border p-3 shadow-lg md:w-72"
                >
                    <div class="mx-auto mt-4 flex flex-col items-center">
                        <img
                            :src="book.cover_image"
                            alt="{{ book.title }}"
                            class="object-fit mx-auto w-48 shadow-xl"
                        />

                        <h2 class="my-3 text-center text-sm font-bold">
                            {{ book.title }}
                        </h2>
                        <div v-if="book.borrowed_at && book.due_date">
                            <p class="text-sm">
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
                    <div class="my-3 flex flex-col items-center">
                        <p v-if="book.review">Your review: {{ book.review }}</p>

                        <!-- Rating Form -->
                        <div class="mb-3 flex space-x-1">
                            <template v-for="i in 5" :key="i">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    class="h-6 w-6 cursor-pointer"
                                    :fill="i <= book.rating ? 'gold' : 'gray'"
                                    @click="submitRating(book.id, i)"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </template>
                        </div>

                        <!-- Review Form -->
                        <textarea
                            v-model="book.review"
                            placeholder="Write your review"
                            class="mb-5 mt-3 w-full rounded border p-2"
                        ></textarea>
                        <PrimaryButton
                            @click="submitReview(book.id, book.review)"
                            preserve-scroll
                        >
                            Submit Review
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
