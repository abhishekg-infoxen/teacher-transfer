<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    matches: Array,
    my_current: String,
    my_desired: String,
});
</script>

<template>
    <Head title="Find Matches" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Found Matches
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="mb-6 flex justify-between items-center">
                        <div>
                            <p class="text-gray-600">
                                Showing teachers who are currently in <strong>{{ my_desired }}</strong> and want to move to <strong>{{ my_current }}</strong>.
                            </p>
                        </div>
                    </div>

                    <div v-if="matches.length === 0" class="text-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                        <p class="text-gray-500 text-lg">No matches found yet.</p>
                        <p class="text-sm text-gray-400 mt-1">Try updating your preferences or check back later.</p>
                    </div>

                    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="match in matches" :key="match.id" class="flex flex-col border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200 bg-white">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold text-lg">
                                    {{ match.name.charAt(0).toUpperCase() }}
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ match.name }}</h3>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">{{ match.ehrms_code || 'No EHRMS' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex-1 space-y-3 text-sm text-gray-600">
                                <div class="bg-gray-50 p-2 rounded">
                                    <span class="block text-xs font-semibold text-gray-400 uppercase">Current Posting</span>
                                    <span class="font-medium text-gray-800">{{ match.current_district }}</span>
                                    <span class="text-gray-500" v-if="match.current_block">, {{ match.current_block }}</span>
                                    <div class="text-xs text-gray-500 mt-1 truncate" title="School">{{ match.current_school }}</div>
                                </div>
                                
                                <div class="bg-indigo-50 p-2 rounded">
                                    <span class="block text-xs font-semibold text-indigo-400 uppercase">Desired Posting</span>
                                    <span class="font-medium text-indigo-900">{{ match.desired_district }}</span>
                                    <span class="text-indigo-600" v-if="match.desired_block">, {{ match.desired_block }}</span>
                                </div>
                            </div>

                            <div class="mt-5 pt-4 border-t border-gray-100 flex gap-2">
                                <a v-if="match.phone" :href="'tel:' + match.phone" class="flex-1 text-center px-3 py-2 bg-green-50 text-green-700 rounded-lg text-sm font-medium hover:bg-green-100 transition-colors">
                                    Call
                                </a>
                                <a v-if="match.email" :href="'mailto:' + match.email" class="flex-1 text-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition-colors">
                                    Email
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
