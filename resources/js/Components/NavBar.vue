<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from './NavLink.vue';
</script>

<template>
    <nav class="w-screen bg-white shadow">
        <div
            class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4"
        >
            <a href="/" class="navbar-brand">
                <ApplicationLogo class="h-24 w-auto fill-current text-black" />
            </a>
            <div>
                <NavLink :href="route('books.index')">Books</NavLink>
                <div v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                    <template v-if="$page.props.auth.user">
                        <Link :href="route('dashboard')">Dashboard</Link>
                    </template>

                    <template v-else>
                        <Link :href="route('login')">Log in</Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Register
                        </Link>
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'NavBar',
};
</script>
