<script setup>
import HeaderAccount from "./HeaderAccount.vue";
import ThemeSwitcher from "./ThemeSwitcher.vue";
import Separator from "./ui/separator/Separator.vue";
import { SidebarTrigger } from "./ui/sidebar";
</script>

<template>
    <header class="shadow-sm border-b">
        <div class="flex items-center justify-between px-6 py-4">
            <div class="flex items-center">
                <SidebarTrigger />
                <Separator orientation="vertical" class="mr-2 h-4" />
                <slot name="breadcrumb" />
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <ThemeSwitcher />

                    <!-- <HeaderNotification /> -->
                </div>
                <div class="relative">
                    <HeaderAccount />
                </div>
            </div>
        </div>
    </header>
</template>
