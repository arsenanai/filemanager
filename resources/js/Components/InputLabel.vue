<script setup>
defineProps({
    forId: {
        type: String,
    },
});
</script>

<template>
    <label :for="forId" class="block text-gray-700 text-sm font-bold mb-2">
        <slot />
    </label>
</template>
