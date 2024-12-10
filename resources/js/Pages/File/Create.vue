<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, Head, Link } from "@inertiajs/vue3";
import { router } from '@inertiajs/vue3'
import FileInput from '@/Components/FileInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const params = new URLSearchParams(document.location.search)
const backURL = params.has('prev') ? params.get('prev') : '/files';
const form = useForm({
    title: "",
    path: null,
});

const submit = () => {
    // form.post("/files");
    router.post('/files', form, {
        _method: 'put',
        forceFormData: true,
    })
};

const onFileInput = (event) => {
    form.path = event.target.files[0]
    form.title = event.target.files[0].name.split('.').slice(0, -1).join('.')
}
</script>

<template>

    <Head title="Manage Files" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Upload a new File</h2>
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
                                <InputLabel for-id="path">File:</InputLabel>
                                <FileInput id="path" @file-input="onFileInput" autofocus required />
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            </div>

                            <div class="mb-4">
                                <InputLabel for-id="title">Title:</InputLabel>
                                <TextInput id="title" type="text" class="w-full" v-model="form.title"
                                    placeholder="Enter Title" required />
                            </div>
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