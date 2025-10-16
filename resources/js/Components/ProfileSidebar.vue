<script setup>
import { LogOut, User, UserLock } from "lucide-vue-next";
import { Button } from "@/Components/ui/button";
</script>

<template>
    <aside class="lg:w-64 flex-shrink-0">
        <nav
            class="bg-zinc-100 rounded-xl shadow-sm p-4 sticky top-24 dark:bg-zinc-900"
        >
            <ul class="space-y-1">
                <li>
                    <Button
                        variant="ghost"
                        class="w-full justify-start gap-3 bg-transparent hover:bg-gray-400 dark:hover:bg-zinc-700"
                        :class="
                            route().current('profile.edit')
                                ? 'bg-gray-300 dark:bg-zinc-800'
                                : 'bg-transparent'
                        "
                        @click="$inertia.visit(route('profile.edit'))"
                    >
                        <User />
                        <span>Profil</span>
                    </Button>
                </li>

                <li>
                    <Button
                        variant="ghost"
                        class="w-full justify-start gap-3 bg-transparent hover:bg-gray-400 dark:hover:bg-zinc-700"
                        :class="
                            route().current('profile.security')
                                ? 'bg-gray-300 dark:bg-zinc-800'
                                : 'bg-transparent'
                        "
                        @click="$inertia.visit(route('profile.security'))"
                    >
                        <UserLock />
                        <span>Keamanan</span>
                    </Button>
                </li>
            </ul>

            <div class="mt-6 pt-6 border-t">
                <Button
                    @click="$inertia.post(route('logout'))"
                    variant="ghost"
                    class="w-full justify-start gap-3 bg-transparent hover:bg-red-200"
                >
                    <LogOut class="text-red-500" />
                    <span class="text-red-500">Keluar</span>
                </Button>
            </div>
        </nav>
    </aside>
</template>
