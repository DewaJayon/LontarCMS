<script setup>
import InputError from "@/Components/InputError.vue";
import { Button } from "@/Components/ui/button";
import { Card, CardContent } from "@/Components/ui/card";
import { Checkbox } from "@/Components/ui/checkbox";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Spinner } from "@/Components/ui/spinner";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Eye } from "lucide-vue-next";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};

const showPassword = (element) => {
    const passwordInput = document.getElementById(element);
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
};
</script>

<template>
    <Head>
        <title>Login</title>
    </Head>

    <AuthLayout>
        <div class="flex flex-col gap-6">
            <Card class="overflow-hidden w-full">
                <CardContent class="grid p-0 md:grid-cols-2">
                    <form class="p-6 md:p-8" @submit.prevent="submit">
                        <div class="flex flex-col gap-6">
                            <div class="flex flex-col items-center text-center">
                                <h1 class="text-2xl font-bold">
                                    Selamat Datang
                                </h1>
                                <p class="text-balance text-muted-foreground">
                                    Silahkan login untuk melanjutkan
                                </p>
                            </div>
                            <div class="grid gap-2">
                                <Label for="email">Email</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    placeholder="m@example.com"
                                    required
                                    v-model="form.email"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.email"
                                />
                            </div>

                            <div class="grid gap-2">
                                <div class="relative">
                                    <Input
                                        id="password"
                                        type="password"
                                        placeholder="••••••••"
                                        v-model="form.password"
                                        required
                                        class="pr-10"
                                        autocomplete="off"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.password"
                                    />

                                    <span
                                        class="absolute right-0 inset-y-0 flex items-center px-3"
                                    >
                                        <Eye
                                            class="cursor-pointer"
                                            @click="showPassword('password')"
                                        />
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <Checkbox
                                    class="cursor-pointer"
                                    id="remember"
                                    v-model="form.remember"
                                    :checked="form.remember"
                                />
                                <label
                                    for="remember"
                                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 cursor-pointer"
                                >
                                    Ingat Saya
                                </label>
                            </div>

                            <Button
                                type="submit"
                                class="w-full"
                                :disabled="form.processing"
                                :class="{ 'opacity-50': form.processing }"
                            >
                                <Spinner
                                    v-if="form.processing"
                                    class="w-5 h-5"
                                />
                                Login
                            </Button>
                        </div>
                    </form>
                    <div class="relative hidden bg-muted md:block">
                        <img
                            src="https://placehold.co/600x400"
                            alt="Mobilin Logo"
                            class="absolute inset-0 h-full w-full object-cover dark:brightness-[0.2] dark:grayscale"
                        />
                    </div>
                </CardContent>
            </Card>
        </div>
    </AuthLayout>
</template>
