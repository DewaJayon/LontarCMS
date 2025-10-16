<script setup>
import InputError from "@/Components/InputError.vue";
import { Button } from "@/Components/ui/button";
import { Label } from "@/Components/ui/label";

import { useForm, usePage } from "@inertiajs/vue3";

import ProfilePicture from "@/Components/ProfilePicture.vue";
import { Input } from "@/Components/ui/input";
import { Textarea } from "@/Components/ui/textarea";
import { Spinner } from "@/Components/ui/spinner";
import { ref } from "vue";
import { toast } from "vue-sonner";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    phone: user.phone,
    address: user.address,
});

const isLoading = ref(false);

const submit = () => {
    isLoading.value = true;

    form.patch(route("profile.update"), {
        preserveScroll: true,
        showProgress: false,
        preserveState: true,
        onSuccess: () => {
            toast.success("Profil berhasil diperbarui.");
            isLoading.value = false;
        },
    });
};
</script>

<template>
    <div class="bg-zinc-100 rounded-xl shadow-sm p-8 dark:bg-zinc-900">
        <h2 class="text-2xl font-bold mb-6">Informasi Profil</h2>

        <div class="mb-8">
            <Label
                class="block text-sm font-semibold text-muted-foreground mb-3"
            >
                Foto Profil
            </Label>
            <div class="flex items-center gap-6">
                <ProfilePicture class="h-24 w-24" />
                <div>
                    <Button
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-medium text-sm"
                    >
                        Upload Foto
                    </Button>
                    <Button
                        variant="outline"
                        class="bg-transparent hover:bg-red-500 border-red-500 ml-2 hover:text-white"
                    >
                        Hapus
                    </Button>
                    <p class="text-xs text-muted-foreground mt-2">
                        JPG atau PNG (Max 2MB)
                    </p>
                </div>
            </div>
        </div>

        <form class="space-y-6" id="form-profile" @submit.prevent="submit">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <Label
                        for="name"
                        class="block text-sm font-semibold text-muted-foreground mb-2"
                    >
                        Nama
                    </Label>
                    <Input
                        type="text"
                        id="name"
                        class="w-full px-4 py-6"
                        v-model="form.name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div>
                    <Label
                        for="email"
                        class="block text-sm font-semibold text-muted-foreground mb-2"
                    >
                        Email
                    </Label>
                    <Input
                        type="text"
                        id="email"
                        class="w-full px-4 py-6"
                        v-model="form.email"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <Button
                    class="py-4 px-6 disabled:opacity-50"
                    form="form-profile"
                    type="submit"
                    :disabled="form.processing"
                >
                    <Spinner v-if="form.processing" class="w-5 h-5" />
                    Simpan
                </Button>
                <Button variant="outline" class="py-4 px-6"> Batal </Button>
            </div>
        </form>
    </div>
</template>
