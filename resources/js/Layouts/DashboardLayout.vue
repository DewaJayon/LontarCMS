<script setup>
import AppSidebar from "@/Components/AppSidebar.vue";
import { SidebarProvider } from "@/Components/ui/sidebar";
import { Toaster } from "@/Components/ui/sonner";
import DashboardHeader from "@/Components/DashboardHeader.vue";
import "vue-sonner/style.css";
</script>

<template>
    <div class="flex h-screen">
        <SidebarProvider>
            <AppSidebar />
            <div class="flex-1 flex flex-col overflow-hidden">
                <DashboardHeader>
                    <template #breadcrumb>
                        <slot name="breadcrumb" />
                    </template>
                </DashboardHeader>
                <main class="flex-1 overflow-x-hidden overflow-y-auto pt-2">
                    <slot />
                </main>
            </div>
        </SidebarProvider>
        <Toaster rich-colors position="top-right" />
    </div>
</template>
