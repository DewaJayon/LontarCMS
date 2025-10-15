<script setup>
import { Link } from "@inertiajs/vue3";
import ProfilePicture from "./ProfilePicture.vue";

import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child class="outline-none cursor-pointer">
            <ProfilePicture class="w-9 h-9" />
        </DropdownMenuTrigger>
        <DropdownMenuContent>
            <DropdownMenuLabel>Akun Saya</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <Link :href="route('profile.edit')">
                <DropdownMenuItem class="cursor-pointer hover:text-black">
                    Profile
                </DropdownMenuItem>
            </Link>
            <Link
                :href="route('logout')"
                as="button"
                method="post"
                class="w-full hover:bg-accent hover:text-slate-900 cursor-pointer transition-all ease-in-out duration-300 rounded"
            >
                <DropdownMenuItem class="cursor-pointer">
                    Logout
                </DropdownMenuItem>
            </Link>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
