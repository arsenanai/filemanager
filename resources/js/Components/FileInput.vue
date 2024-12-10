<script setup>
    defineProps(['id'])
    defineEmits(['file-input'])
</script>

<template>
    <input type="file"
        class="shadow appearance-none border-dashed border-2 border-gray-500 rounded w-full py-20 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-60 flex justify-center items-center before:content-[attr(before-text)] after:content-[attr(after-text)]"
        :id="id" @input="$emit('file-input', $event)" placeholder="" before-text="Drag & Drop File here or"
        after-text="Pick a file up to 8MB." />
</template>