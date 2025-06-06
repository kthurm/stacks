<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    books: Array,
});
const reviewInputs = ref({});
const books = ref(props.books);

const submitRating = (bookId, rating) => {
    const form = useForm({ rating });

    form.submit('post', route('userbooks.rate', bookId), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            const book = books.value.find((b) => b.id === bookId);
            if (book?.pivot) {
                book.pivot.rating = rating;
            } else if (book) {
                book.pivot = { rating };
            }
        },
        onError: (errors) => {
            console.error(errors);
            alert('There was an error submitting the rating.');
        },
    });
};
const submitReview = (bookId, review) => {
    const form = useForm({ review });

    form.post(route('userbooks.review', bookId), {
        onSuccess: () => {
            const book = books.value.find((b) => b.id === bookId);
            if (book) {
                book.review = review;
            }
            reviewInputs.value[bookId] = '';
            alert('Review submitted!');
        },
        onError: (errors) => {
            console.error(errors);
            alert('There was an error submitting the review: ' + errors.review);
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
                    <div class="my-3 flex flex-col">
                        <!-- Rating Form -->
                        <div class="mb-3 flex space-x-1">
                            <span class="ml-1 font-bold">My rating:</span>
                            <template v-for="i in 5" :key="i">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    class="h-6 w-6 cursor-pointer"
                                    :fill="
                                        i <= book.pivot.rating ? 'gold' : 'gray'
                                    "
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

                        <p
                            v-if="book.review || book.pivot?.review"
                            class="ml-1"
                        >
                            <span class="font-bold">My review: </span>
                            {{ book.review || book.pivot.review }}
                        </p>

                        <textarea
                            v-model="reviewInputs[book.id]"
                            placeholder="Write your review here..."
                            class="my-4 w-full rounded border p-2"
                            rows="3"
                        ></textarea>

                        <PrimaryButton
                            @click="
                                submitReview(book.id, reviewInputs[book.id])
                            "
                            preserve-scroll
                            class="mx-auto"
                        >
                            Submit Review
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
