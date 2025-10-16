<script setup>
import { Button } from "@/Components/ui/button";
import { useForm } from "@inertiajs/vue3";
import { Label } from "@/Components/ui/label";
import { Input } from "@/Components/ui/input";
import InputError from "@/Components/InputError.vue";
import { Eye } from "lucide-vue-next";
import { Spinner } from "@/Components/ui/spinner";

import {
    AlertDialog,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "@/Components/ui/alert-dialog";

const form = useForm({
    password: "",
});

const showPassword = (element) => {
    const passwordInput = document.getElementById(element);
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
};

const handleDeleteUser = () => {
    form.delete(route("profile.destroy"), {
        preserveScroll: true,
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <h3 class="text-lg font-semibold mb-2 text-red-500">Hapus Akun</h3>

    <p class="text-muted-foreground mb-4">
        Jika Anda ingin menghapus akun Anda, klik tombol di bawah ini.
        <br />
        Akun Anda akan dihapus secara permanen dan tidak dapat dikembalikan.
    </p>

    <AlertDialog>
        <AlertDialogTrigger>
            <Button class="bg-red-500 hover:bg-red-600 text-white">
                Hapus Akun
            </Button>
        </AlertDialogTrigger>
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>
                    Apakah Anda yakin ingin menghapus akun Anda?
                </AlertDialogTitle>
                <AlertDialogDescription>
                    Akun Anda akan dihapus secara permanen dan tidak dapat
                    dikembalikan.
                </AlertDialogDescription>
            </AlertDialogHeader>

            <form @submit.prevent="handleDeleteUser" id="deleteUserForm">
                <div>
                    <Label
                        for="password"
                        class="block text-sm font-semibold text-muted-foreground"
                    >
                        Password Saat Ini
                    </Label>
                    <div class="relative flex items-center">
                        <Input
                            id="password"
                            type="password"
                            placeholder="••••••••"
                            v-model="form.password"
                            required
                            class="w-full pr-10 py-5"
                            autocomplete="off"
                        />
                        <Eye
                            class="absolute right-3 text-gray-500 cursor-pointer"
                            @click="showPassword('password')"
                        />
                    </div>
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
            </form>

            <AlertDialogFooter>
                <AlertDialogCancel> Batal </AlertDialogCancel>
                <Button
                    class="bg-red-500 text-white hover:bg-red-600 disabled:opacity-50"
                    form="deleteUserForm"
                    type="submit"
                >
                    <Spinner v-if="form.processing" class="w-5 h-5" />
                    Hapus
                </Button>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
