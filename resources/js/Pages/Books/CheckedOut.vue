<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    checkedOutBooks: Array,
    csrfToken: String,
});
</script>
<template>
    <div v-for="book in checkedOutBooks" :key="book.id">
        <div class="book-details">
            <h3>{{ book.title }}</h3>
            <p>{{ book.author }}</p>
            <p>{{ book.published_year }}</p>
        </div>

        <form :action="route('books.return', book.id)" method="POST">
            <input type="hidden" name="_method" value="POST" />
            <input type="hidden" name="_token" :value="csrfToken" />
            <button type="submit" class="btn btn-danger">Return Book</button>
        </form>
    </div>
</template>
