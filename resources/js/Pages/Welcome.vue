<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome To Stacks" />
    <div
        class="radial-gradient flex min-h-screen flex-col items-center justify-between dark:text-white/50"
    >
        <div
            class="flex min-h-screen w-full flex-col items-center justify-center px-6"
        >
            <header class="justified-center flex flex-col">
                <ApplicationLogo
                    class="h-32 w-auto fill-white text-white drop-shadow-lg"
                />
            </header>
            <nav
                v-if="canLogin"
                class="mx-3 my-12 flex justify-center space-x-5"
            >
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('books.index')"
                    class="rounded-md bg-blue-950 px-3 py-2 text-white ring-1 transition hover:bg-blue-600 focus:outline-none focus-visible:ring-[#FF2D20]"
                >
                    Book Dashboard
                </Link>

                <Link
                    v-if="$page.props.auth.user"
                    :href="route('logout')"
                    method="POST"
                    class="rounded-md bg-blue-950 px-3 py-2 text-white ring-1 transition hover:bg-blue-600 focus:outline-none focus-visible:ring-[#FF2D20]"
                >
                    Log out
                </Link>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="rounded-md bg-blue-950 px-3 py-2 text-white ring-1 transition hover:bg-blue-600 focus:outline-none focus-visible:ring-[#FF2D20]"
                    >
                        Log in
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-md bg-blue-950 px-3 py-2 text-white ring-1 transition hover:bg-blue-600 focus:outline-none focus-visible:ring-[#FF2D20]"
                    >
                        Register
                    </Link>
                </template>
            </nav>

            <main class="mt-6"></main>
        </div>
        <footer
            class="w-full bg-blue-950 py-2 text-center text-sm text-white/70"
        >
            Stacks Library App
        </footer>
    </div>
</template>
