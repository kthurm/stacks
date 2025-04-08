<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import NavBar from '../Components/NavBar.vue';

const props = defineProps({
    user: {
        role: String,
    },
});
</script>
<template>
    <div>
        <NavBar />

        <main>
            <template
                v-if="$page.props.user && $page.props.user.role !== 'librarian'"
                ><div
                    class="mx-auto mt-16 flex h-screen max-w-7xl flex-col items-center"
                >
                    <h1 class="text-2xl">
                        Sorry, but this page is restricted to librarians.
                    </h1>
                    <p class="mt-3 text-lg">
                        Try this page instead:
                        <Link
                            :href="route('books.index')"
                            class="font-bold text-blue-800 hover:text-blue-400"
                            >Books</Link
                        >
                    </p>
                </div>
            </template>
            <template v-else>
                <slot />
            </template>
        </main>
    </div>
</template>
