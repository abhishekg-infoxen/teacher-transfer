<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <v-app>
        <v-main class="bg-grey-lighten-4 d-flex align-center justify-center">
            <v-container fluid>
                <v-row justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <div class="text-center mb-8">
                            <h1 class="text-h4 font-weight-bold text-indigo-darken-4">Teacher Portal</h1>
                            <p class="text-subtitle-1 text-grey-darken-1">Please sign in to your account</p>
                        </div>

                        <v-card elevation="12" class="rounded-xl pa-4 bg-white">
                            <v-card-text>
                                <v-alert
                                    v-if="status"
                                    type="success"
                                    variant="tonal"
                                    class="mb-4"
                                    density="compact"
                                >
                                    {{ status }}
                                </v-alert>

                                <v-form @submit.prevent="submit">
                                    <v-text-field
                                        v-model="form.email"
                                        label="Email Address"
                                        prepend-inner-icon="mdi-email-outline"
                                        type="email"
                                        variant="outlined"
                                        color="indigo"
                                        :error-messages="form.errors.email"
                                        required
                                        autofocus
                                        class="mb-2"
                                    ></v-text-field>

                                    <v-text-field
                                        v-model="form.password"
                                        label="Password"
                                        prepend-inner-icon="mdi-lock-outline"
                                        :type="showPassword ? 'text' : 'password'"
                                        variant="outlined"
                                        color="indigo"
                                        :error-messages="form.errors.password"
                                        required
                                        class="mb-2"
                                        :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                                        @click:append-inner="showPassword = !showPassword"
                                    ></v-text-field>

                                    <div class="d-flex align-center justify-space-between mb-4">
                                        <v-checkbox
                                            v-model="form.remember"
                                            label="Remember me"
                                            hide-details
                                            color="indigo"
                                            density="compact"
                                        ></v-checkbox>

                                        <Link
                                            v-if="canResetPassword"
                                            :href="route('password.request')"
                                            class="text-caption text-indigo-darken-2 font-weight-bold text-decoration-none"
                                        >
                                            Forgot Password?
                                        </Link>
                                    </div>

                                    <v-btn
                                        type="submit"
                                        color="indigo-darken-3"
                                        block
                                        size="large"
                                        class="rounded-lg text-none font-weight-bold"
                                        :loading="form.processing"
                                        elevation="2"
                                    >
                                        Sign In
                                    </v-btn>
                                </v-form>
                            </v-card-text>

                            <v-divider class="mx-4 my-4"></v-divider>

                            <v-card-actions class="justify-center pb-6">
                                <span class="text-body-2 text-grey-darken-1">Don't have an account?</span>
                                <Link
                                    :href="route('register')"
                                    class="ms-2 text-body-2 text-indigo-darken-4 font-weight-bold text-decoration-none"
                                >
                                    Register Now
                                </Link>
                            </v-card-actions>
                        </v-card>

                        <div class="text-center mt-8">
                            <Link href="/" class="text-caption text-grey-darken-1 text-decoration-none">
                                <v-icon size="small" start>mdi-arrow-left</v-icon>
                                Back to Homepage
                            </Link>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<style scoped>
.v-application {
    background-color: #f5f5f5 !important;
}
</style>
