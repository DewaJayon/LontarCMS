<script setup>
import { Badge } from "@/Components/ui/badge";
import { computed } from "vue";

const props = defineProps({
    row: { type: Object, required: true },
});

const borderColor = computed(() => {
    switch (props.row.role) {
        case "admin":
            return "border-red-500";
        case "staff":
            return "border-green-500";
        case "researcher":
            return "border-blue-500";
        default:
            return "border-gray-500";
    }
});
</script>

<template>
    <Badge class="capitalize" :class="borderColor" variant="outline">
        {{ props.row.role }}
    </Badge>
</template>
