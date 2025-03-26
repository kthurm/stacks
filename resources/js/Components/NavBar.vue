<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import { defineProps } from 'vue';

const props = defineProps({
    canLogin: {
        type: Boolean,
        default: true, // Set a default if not provided
    },
    canRegister: {
        type: Boolean,
        default: true, // Set a default if not provided
    },
});
</script>

<template>
    <div class="relative top-0 w-screen bg-white shadow-lg lg:sticky">
        <div
            class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4"
        >
            <a href="/" class="navbar-brand">
                <ApplicationLogo
                    class="h-9 w-auto fill-current text-black sm:h-16"
                />
            </a>

            <div class="flex items-center space-x-4 px-2">
                <NavLink :href="route('books.index')">Books</NavLink>
                <nav
                    v-if="props.canLogin"
                    class="-mx-3 flex flex-1 justify-end"
                >
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Dashboard
                    </Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Log in
                        </Link>

                        <Link
                            v-if="props.canRegister"
                            :href="route('register')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Register
                        </Link>
                    </template>
                </nav>
            </div>
        </div>
    </div>
</template>
