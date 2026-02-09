<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    locations: Object
});

const user = usePage().props.auth.user;

const locations = ref(props.locations || {});
const districtsList = ref(Object.keys(locations.value).sort());
const currentBlocks = ref([]);
const desiredBlocks = ref([]);

const form = useForm({
    ehrms_code: user.ehrms_code || '',
    phone: user.phone || '',
    current_district: user.current_district || '',
    current_block: user.current_block || '',
    current_school: user.current_school || '',
    desired_district: user.desired_district || '',
    desired_block: user.desired_block || '',
});

onMounted(() => {
    // Initial blocks setup if user already has district set
    if (form.current_district) {
        currentBlocks.value = locations.value[form.current_district] || [];
    }
    if (form.desired_district) {
        desiredBlocks.value = locations.value[form.desired_district] || [];
    }
});

// Watch for district changes to update blocks
watch(() => form.current_district, (newDistrict) => {
    currentBlocks.value = locations.value[newDistrict] || [];
    if (!currentBlocks.value.includes(form.current_block)) {
        form.current_block = ''; // Reset block if it's not in the new district
    }
});

watch(() => form.desired_district, (newDistrict) => {
    desiredBlocks.value = locations.value[newDistrict] || [];
    if (!desiredBlocks.value.includes(form.desired_block)) {
        form.desired_block = ''; // Reset block if it's not in the new district
    }
});

const submit = () => {
    form.put(route('teacher.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="My Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                My Profile
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                
                <div class="bg-white p-4 shadow sm:p-8 sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Transfer Profile</h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Update your posting details and transfer preferences.
                            </p>
                        </header>

                        <form @submit.prevent="submit" class="mt-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="ehrms_code" value="EHRMS Code" />
                                    <TextInput
                                        id="ehrms_code"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.ehrms_code"
                                        required
                                        autofocus
                                    />
                                    <InputError class="mt-2" :message="form.errors.ehrms_code" />
                                </div>

                                <div>
                                    <InputLabel for="phone" value="Phone Number" />
                                    <TextInput
                                        id="phone"
                                        type="tel"
                                        class="mt-1 block w-full"
                                        v-model="form.phone"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.phone" />
                                </div>

                                <div class="col-span-full border-t pt-4">
                                    <h3 class="font-medium text-gray-900 mb-4">Current Posting</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <InputLabel for="current_district" value="Current District" />
                                            <select
                                                id="current_district"
                                                v-model="form.current_district"
                                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                required
                                            >
                                                <option value="">Select District</option>
                                                <option v-for="d in districtsList" :key="d" :value="d">{{ d }}</option>
                                            </select>
                                            <InputError class="mt-2" :message="form.errors.current_district" />
                                        </div>
                                        <div>
                                            <InputLabel for="current_block" value="Current Block" />
                                            <select
                                                id="current_block"
                                                v-model="form.current_block"
                                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                required
                                                :disabled="!form.current_district"
                                            >
                                                <option value="">Select Block</option>
                                                <option v-for="b in currentBlocks" :key="b" :value="b">{{ b }}</option>
                                            </select>
                                            <InputError class="mt-2" :message="form.errors.current_block" />
                                        </div>
                                        <div>
                                            <InputLabel for="current_school" value="School Name" />
                                            <TextInput
                                                id="current_school"
                                                type="text"
                                                class="mt-1 block w-full bg-gray-50"
                                                v-model="form.current_school"
                                                required
                                            />
                                            <InputError class="mt-2" :message="form.errors.current_school" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-full border-t pt-4">
                                    <h3 class="font-medium text-gray-900 mb-4">Desired Posting</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <InputLabel for="desired_district" value="Desired District" />
                                            <select
                                                id="desired_district"
                                                v-model="form.desired_district"
                                                class="mt-1 block w-full bg-indigo-50 border-indigo-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                required
                                            >
                                                <option value="">Select District</option>
                                                <option v-for="d in districtsList" :key="d" :value="d">{{ d }}</option>
                                            </select>
                                            <InputError class="mt-2" :message="form.errors.desired_district" />
                                        </div>
                                        <div>
                                            <InputLabel for="desired_block" value="Desired Block (Optional)" />
                                            <select
                                                id="desired_block"
                                                v-model="form.desired_block"
                                                class="mt-1 block w-full bg-indigo-50 border-indigo-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                :disabled="!form.desired_district"
                                            >
                                                <option value="">Select Block</option>
                                                <option v-for="b in desiredBlocks" :key="b" :value="b">{{ b }}</option>
                                            </select>
                                            <InputError class="mt-2" :message="form.errors.desired_block" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 border-t pt-4">
                                <PrimaryButton :disabled="form.processing">Save Profile</PrimaryButton>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                                </Transition>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
