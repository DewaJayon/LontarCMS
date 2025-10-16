<script setup>
import ProfileSidebar from "@/Components/ProfileSidebar.vue";
import DashboardLayout from "./DashboardLayout.vue";
</script>

<template>
    <DashboardLayout>
        <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
            <div class="mb-8">
                <h1 class="text-4xl font-bold mb-2">Pengaturan</h1>
                <p class="text-muted-foreground">
                    Kelola preferensi dan pengaturan akun Anda
                </p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <ProfileSidebar />

                <main class="flex-1">
                    <slot />
                </main>
            </div>
        </div>
    </DashboardLayout>
</template>
