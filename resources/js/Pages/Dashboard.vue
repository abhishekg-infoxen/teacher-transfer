<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    user: Object,
    matchesCount: Number,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Welcome Card -->
                    <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Welcome, {{ user.name }}!</h3>
                        <p class="text-gray-600 mb-6">Manage your teacher transfer request and find potential partners for a mutual transfer.</p>
                        
                        <div class="flex flex-wrap gap-4 mt-4">
                            <Link
                                :href="route('matches')"
                                class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 transition duration-150"
                            >
                                <v-icon start size="small" class="me-2">mdi-account-search</v-icon>
                                Find Matches
                            </Link>
                            <Link
                                :href="route('teacher.profile')"
                                class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-lg font-bold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition duration-150"
                            >
                                <v-icon start size="small" class="me-2 text-indigo-500">mdi-account-edit</v-icon>
                                Update Profile
                            </Link>
                        </div>
                    </div>

                    <!-- Stats Card -->
                    <div class="bg-indigo-600 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white flex flex-col justify-center items-center text-center">
                        <div class="text-5xl font-black mb-2">{{ matchesCount }}</div>
                        <div class="text-lg font-medium opacity-90 uppercase tracking-wider">Potential Matches</div>
                        <p class="mt-4 text-xs opacity-75">Teachers who want to swap districts with you.</p>
                    </div>

                    <!-- Current Status Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Current Transfer Goal</h4>
                        
                        <div v-if="user.current_district && user.desired_district" class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500">
                                    <v-icon size="x-small">mdi-map-marker</v-icon>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-400">From</div>
                                    <div class="font-bold text-gray-800">{{ user.current_district }}</div>
                                </div>
                            </div>
                            
                            <div class="ms-4 border-l-2 border-dashed border-indigo-200 h-6"></div>

                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-500">
                                    <v-icon size="x-small">mdi-flag-variant</v-icon>
                                </div>
                                <div>
                                    <div class="text-xs text-indigo-400">To</div>
                                    <div class="font-bold text-indigo-900">{{ user.desired_district }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div v-else class="flex-1 flex flex-col items-center justify-center text-center py-4">
                            <v-icon color="grey-lighten-2" size="large" class="mb-2">mdi-alert-circle-outline</v-icon>
                            <p class="text-sm text-gray-500 mb-4">Please complete your transfer profile to see matches.</p>
                            <Link :href="route('teacher.profile')" class="text-indigo-600 text-xs font-bold uppercase underline">Set Preferences</Link>
                        </div>
                    </div>

                    <!-- EHRMS Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center gap-4">
                        <div class="p-3 bg-amber-50 rounded-xl text-amber-600 text-xl">
                            <v-icon>mdi-card-account-details-outline</v-icon>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs text-gray-400 uppercase font-bold">EHRMS ID</div>
                            <div class="text-lg font-bold text-gray-800">{{ user.ehrms_code || 'Not Set' }}</div>
                        </div>
                    </div>

                    <!-- Phone Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center gap-4">
                        <div class="p-3 bg-green-50 rounded-xl text-green-600 text-xl">
                            <v-icon>mdi-phone-outline</v-icon>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs text-gray-400 uppercase font-bold">Contact</div>
                            <div class="text-lg font-bold text-gray-800">{{ user.phone || 'Not Set' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
