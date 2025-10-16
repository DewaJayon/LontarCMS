<script setup>
import InputError from "@/Components/InputError.vue";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Spinner } from "@/Components/ui/spinner";
import ProfileLayout from "@/Layouts/ProfileLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Eye } from "lucide-vue-next";
import { ref } from "vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import { toast } from "vue-sonner";

const showPassword = (element) => {
    const passwordInput = document.getElementById(element);
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
};

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updatePassword = () => {
    form.put(route("password.update"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset(), toast.success("Password berhasil diperbarui.");
        },
        onError: () => {
            if (form.errors.password) {
                form.reset("password", "password_confirmation");
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset("current_password");
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <Head>
        <title>Keamanan</title>
    </Head>

    <ProfileLayout>
        <div class="bg-zinc-100 rounded-xl shadow-sm p-8 dark:bg-zinc-900">
            <h2 class="text-2xl font-bold mb-6">Keamanan</h2>

            <div class="space-y-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Ubah Password</h3>
                    <form
                        class="space-y-4"
                        @submit.prevent="updatePassword"
                        id="updatePasswordForm"
                    >
                        <div>
                            <Label
                                for="currentPassword"
                                class="block text-sm font-semibold text-muted-foreground"
                            >
                                Password Saat Ini
                            </Label>
                            <div class="relative flex items-center">
                                <Input
                                    id="currentPassword"
                                    type="password"
                                    placeholder="••••••••"
                                    v-model="form.current_password"
                                    required
                                    class="w-full pr-10 py-5"
                                    autocomplete="off"
                                />
                                <Eye
                                    class="absolute right-3 text-gray-500 cursor-pointer"
                                    @click="showPassword('currentPassword')"
                                />
                            </div>
                            <InputError
                                class="mt-2"
                                :message="form.errors.current_password"
                            />
                        </div>

                        <div>
                            <Label
                                for="newPassword"
                                class="block text-sm font-semibold text-muted-foreground"
                            >
                                Password Baru
                            </Label>
                            <div class="relative flex items-center">
                                <Input
                                    id="newPassword"
                                    type="password"
                                    placeholder="••••••••"
                                    v-model="form.password"
                                    required
                                    class="w-full pr-10 py-5"
                                    autocomplete="off"
                                />
                                <Eye
                                    class="absolute right-3 text-gray-500 cursor-pointer"
                                    @click="showPassword('newPassword')"
                                />
                            </div>
                            <InputError
                                class="mt-2"
                                :message="form.errors.password"
                            />
                        </div>

                        <div>
                            <Label
                                for="confirmPassword"
                                class="block text-sm font-semibold text-muted-foreground"
                            >
                                Konfirmasi Password
                            </Label>
                            <div class="relative flex items-center">
                                <Input
                                    id="confirmPassword"
                                    type="password"
                                    placeholder="••••••••"
                                    v-model="form.password_confirmation"
                                    required
                                    class="w-full pr-10 py-5"
                                    autocomplete="off"
                                />
                                <Eye
                                    class="absolute right-3 text-gray-500 cursor-pointer"
                                    @click="showPassword('confirmPassword')"
                                />
                            </div>
                            <InputError
                                class="mt-2"
                                :message="form.errors.password_confirmation"
                            />
                        </div>

                        <Button
                            type="submit"
                            form="updatePasswordForm"
                            class="disabled:opacity-50 py-5"
                            :disabled="form.processing"
                        >
                            <Spinner v-if="form.processing" class="w-5 h-5" />
                            Update Password
                        </Button>
                    </form>
                </div>

                <div class="pt-6 border-t">
                    <DeleteUserForm />
                </div>
            </div>
        </div>
    </ProfileLayout>
</template>
