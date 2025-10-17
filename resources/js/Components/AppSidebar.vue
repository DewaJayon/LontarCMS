<script setup>
import { Link, usePage } from "@inertiajs/vue3";

import {
    SidebarContent,
    SidebarGroup,
    SidebarGroupLabel,
    SidebarGroupContent,
    SidebarMenu,
    SidebarMenuItem,
    SidebarMenuButton,
    Sidebar,
    SidebarHeader,
} from "@/Components/ui/sidebar";

import { LayoutDashboard, UserRound } from "lucide-vue-next";
import { filterMenuByRole } from "@/lib/utils";

const user = usePage().props.auth.user;

const general = [
    {
        title: "Dashboard",
        routeName: "home",
        icon: LayoutDashboard,
        roles: ["admin", "staff"],
    },
    {
        title: "User",
        routeName: "users.index",
        icon: UserRound,
        roles: ["admin"],
    },
];
</script>

<template>
    <Sidebar>
        <SidebarHeader>
            <div class="flex items-center gap-2 justify-center mt-2">
                <img
                    class="h-8 w-8"
                    src="https://placehold.co/100x100"
                    alt="Logo"
                />
                <span class="font-bold dark:text-white">Lontar</span>
            </div>
        </SidebarHeader>
        <SidebarContent>
            <SidebarGroup>
                <SidebarGroupLabel> Dashboard </SidebarGroupLabel>
                <SidebarGroupContent>
                    <SidebarMenu>
                        <SidebarMenuItem
                            v-for="item in general"
                            :key="item.title"
                        >
                            <SidebarMenuButton
                                asChild
                                :is-active="route().current(item.routeName)"
                            >
                                <Link
                                    :href="
                                        route().has(item.routeName)
                                            ? route(item.routeName)
                                            : '#'
                                    "
                                >
                                    <component :is="item.icon" />
                                    <span>{{ item.title }}</span>
                                </Link>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </SidebarGroupContent>
            </SidebarGroup>
        </SidebarContent>
    </Sidebar>
</template>
