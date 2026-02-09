<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Teacher Mutual Transfer Portal" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 min-h-screen flex flex-col justify-center items-center selection:bg-[#FF2D20] selection:text-white">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl z-10 text-center">
            
            <div class="mb-12">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 dark:text-white tracking-tight">
                    Teacher Mutual Transfer Portal
                </h1>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Find matches for your desired district transfer. Currently supporting Uttar Pradesh districts.
                </p>
            </div>

            <div v-if="canLogin" class="flex justify-center gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="rounded-full bg-[#FF2D20] px-8 py-3 text-white font-semibold text-lg hover:bg-[#e02619] transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF2D20] dark:focus:ring-offset-gray-900"
                >
                    Go to Dashboard
                </Link>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="rounded-full bg-white text-gray-900 border border-gray-300 px-8 py-3 font-semibold text-lg hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-zinc-800 dark:text-white dark:border-zinc-700 dark:hover:bg-zinc-700"
                    >
                        Log in
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-full bg-[#FF2D20] px-8 py-3 text-white font-semibold text-lg hover:bg-[#e02619] transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF2D20] dark:focus:ring-offset-gray-900"
                    >
                        Register Now
                    </Link>
                </template>
            </div>

            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 text-left max-w-4xl mx-auto">
                <div class="p-6 bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-800">
                    <div class="w-12 h-12 bg-red-50 text-[#FF2D20] rounded-lg flex items-center justify-center mb-4 text-2xl font-bold">1</div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Register Profile</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Enter your EHRMS code, current posting details, and verify your phone number.</p>
                </div>
                <div class="p-6 bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-800">
                    <div class="w-12 h-12 bg-red-50 text-[#FF2D20] rounded-lg flex items-center justify-center mb-4 text-2xl font-bold">2</div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Set Preference</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Select your desired district and block where you want to be transferred.</p>
                </div>
                <div class="p-6 bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-800">
                    <div class="w-12 h-12 bg-red-50 text-[#FF2D20] rounded-lg flex items-center justify-center mb-4 text-2xl font-bold">3</div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Find Matches</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Our system automatically finds teachers who want to swap places with you.</p>
                </div>
            </div>

            <footer class="mt-20 py-10 text-center text-sm text-black/40 dark:text-white/40">
                Built with Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
            </footer>
        </div>
    </div>
</template>
