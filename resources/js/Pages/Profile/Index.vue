<script setup>
import { Head } from "@inertiajs/vue3";

import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import ProfileLayout from "@/Layouts/ProfileLayout.vue";
</script>

<template>
    <Head>
        <title>Pengaturan</title>
    </Head>

    <ProfileLayout>
        <UpdateProfileInformationForm />
    </ProfileLayout>
</template>
