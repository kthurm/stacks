<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import { defineProps } from 'vue';
import NavButtonLink from './NavButtonLink.vue';

const props = defineProps({
    canLogin: {
        type: Boolean,
        default: true,
    },
    canRegister: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <div class="relative top-0 z-[100] w-screen bg-white shadow-lg lg:sticky">
        <div
            class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4"
        >
            <a href="/books" class="navbar-brand">
                <ApplicationLogo
                    class="block h-9 w-auto fill-current text-black sm:h-16"
                />
            </a>

            <div>
                <nav
                    v-if="props.canLogin"
                    class="space-x- flex flex-col justify-end space-y-1 md:flex-row md:space-x-10 md:space-y-0"
                >
                    <div class="flex justify-end space-x-2">
                        <NavLink :href="route('books.index')">Books</NavLink>
                        <NavLink :href="route('userbooks.index')"
                            >My Books</NavLink
                        >

                        <NavLink
                            v-if="$page.props.user"
                            :href="route('logout')"
                            method="POST"
                        >
                            Logout
                        </NavLink>

                        <template v-else>
                            <NavLink :href="route('login')"> Log in </NavLink>
                            <NavLink
                                v-if="props.canRegister"
                                :href="route('register')"
                            >
                                Register
                            </NavLink>
                        </template>
                    </div>
                    <div
                        v-if="
                            $page.props.user &&
                            $page.props.user.role === 'librarian'
                        "
                        class="flex justify-end space-x-2"
                    >
                        <NavButtonLink :href="route('books.create')"
                            >Add New Book
                        </NavButtonLink>

                        <NavButtonLink :href="route('dashboard')" preserve-state
                            >Dashboard
                        </NavButtonLink>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</template>
