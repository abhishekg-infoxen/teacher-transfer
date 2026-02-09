<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <v-app>
        <v-main class="bg-grey-lighten-4 d-flex align-center justify-center">
            <v-container fluid>
                <v-row justify="center">
                    <v-col cols="12" sm="10" md="6" lg="5">
                        <div class="text-center mb-8">
                            <h1 class="text-h4 font-weight-bold text-indigo-darken-4 text-gradient">Create Account</h1>
                            <p class="text-subtitle-1 text-grey-darken-1">Join the Teacher Mutual Transfer Portal</p>
                        </div>

                        <v-card elevation="12" class="rounded-xl pa-4 bg-white">
                            <v-card-text>
                                <v-form @submit.prevent="submit">
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="form.name"
                                                label="Full Name"
                                                prepend-inner-icon="mdi-account-outline"
                                                variant="outlined"
                                                color="indigo"
                                                :error-messages="form.errors.name"
                                                required
                                                autofocus
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="form.email"
                                                label="Email Address"
                                                prepend-inner-icon="mdi-email-outline"
                                                type="email"
                                                variant="outlined"
                                                color="indigo"
                                                :error-messages="form.errors.email"
                                                required
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6">
                                            <v-text-field
                                                v-model="form.password"
                                                label="Password"
                                                prepend-inner-icon="mdi-lock-outline"
                                                :type="showPassword ? 'text' : 'password'"
                                                variant="outlined"
                                                color="indigo"
                                                :error-messages="form.errors.password"
                                                required
                                                :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                                                @click:append-inner="showPassword = !showPassword"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6">
                                            <v-text-field
                                                v-model="form.password_confirmation"
                                                label="Confirm Password"
                                                prepend-inner-icon="mdi-lock-check-outline"
                                                :type="showPassword ? 'text' : 'password'"
                                                variant="outlined"
                                                color="indigo"
                                                :error-messages="form.errors.password_confirmation"
                                                required
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>

                                    <div class="mt-4">
                                        <v-btn
                                            type="submit"
                                            color="indigo-darken-3"
                                            block
                                            size="large"
                                            class="rounded-lg text-none font-weight-bold"
                                            :loading="form.processing"
                                            elevation="2"
                                        >
                                            Create Account
                                        </v-btn>
                                    </div>
                                </v-form>
                            </v-card-text>

                            <v-divider class="mx-4 my-4"></v-divider>

                            <v-card-actions class="justify-center pb-6">
                                <span class="text-body-2 text-grey-darken-1">Already registered?</span>
                                <Link
                                    :href="route('login')"
                                    class="ms-2 text-body-2 text-indigo-darken-4 font-weight-bold text-decoration-none"
                                >
                                    Login here
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
.text-gradient {
    background: linear-gradient(45deg, #1A237E, #3F51B5);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>
