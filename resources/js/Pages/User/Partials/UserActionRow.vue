<script setup>
import { Button } from "@/Components/ui/button";
import { Trash2 } from "lucide-vue-next";
import { router, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { toast } from "vue-sonner";
import { Spinner } from "@/Components/ui/spinner";
import UserUpdateForm from "../Form/UserUpdateForm.vue";

import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "@/Components/ui/alert-dialog";

const props = defineProps({
    row: { type: Object, required: true },
});

const isLoading = ref(false);
const isDialogOpen = ref(false);
const page = usePage();
const user = page.props.auth.user.name;

const destroy = (id, name) => {
    isLoading.value = true;
    isDialogOpen.value = true;

    router.delete(route("users.destroy", id), {
        preserveScroll: true,
        showProgress: false,
        onSuccess: () => {
            toast.success(page.props.flash.success, {
                description: `User ${name} berhasil dihapus oleh ${user}`,
            });
        },
        onError: () => {
            toast.error(page.props.flash.error);
        },
        onFinish: () => {
            isLoading.value = false;
            isDialogOpen.value = false;
        },
    });
};
</script>

<template>
    <div class="flex items-center justify-center">
        <UserUpdateForm :row="row" />

        <AlertDialog v-model:open="isDialogOpen">
            <AlertDialogTrigger>
                <Button
                    variant="ghost"
                    size="icon"
                    class="dark:hover:bg-red-900 hover:bg-red-500 group"
                >
                    <Trash2
                        class="w-4 h-4 text-red-500 dark:group-hover:text-white group-hover:text-black"
                    />
                </Button>
            </AlertDialogTrigger>
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>
                        Apakah anda yakin ingin menghapus
                        <span class="underline font-bold">
                            {{ row.name }} ?
                        </span>
                    </AlertDialogTitle>
                    <AlertDialogDescription>
                        Data yang telah dihapus tidak dapat dikembalikan!
                        Tindakan ini tidak dapat dibatalkan!
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Batal</AlertDialogCancel>
                    <AlertDialogAction
                        @click="destroy(row.id, row.name)"
                        class="bg-red-500 hover:bg-red-600 text-white"
                    >
                        <Spinner v-if="isLoading" class="w-5 h-5" />
                        {{ isLoading ? "Loading..." : "Hapus" }}
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </div>
</template>
