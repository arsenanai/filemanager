<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, Head, Link } from "@inertiajs/vue3";
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/InputLabel.vue';

const props = defineProps({
    file: {
        type: Object,
        default: null,
    },
});

const params = new URLSearchParams(document.location.search)
const backURL = params.has('prev') ? params.get('prev') : '/files';

const form = useForm({
    title: props.file.title,
    upload: props.file.upload,
    redirectURL: backURL,
});

const submit = () => {
    form.put(`/files/${props.file.id}`);
};
</script>

<template>

    <Head title="Manage Files" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit File</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Link :href="backURL"
                            class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 mb-4">
                        Back
                        </Link>

                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                                    Title:</label>
                                <input type="text"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter Title" id="title" v-model="form.title" />

                            </div>

                            <!-- <div class="mb-4">
                                <label 
                                    for="body" 
                                    class="block text-gray-700 text-sm font-bold mb-2">
                                    Body:</label>
                                <textarea 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="body" 
                                    v-model="form.body" 
                                    placeholder="Enter Body"></textarea>
                            </div> -->
                            <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Submit
                            </PrimaryButton>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>