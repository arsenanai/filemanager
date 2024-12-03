<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
  files: {
    type: Array,
    default: () => [],
  },
});

const form = useForm({});

const deleteFile = (id) => {
  form.delete(`files/${id}`);
};
</script>

<template>

  <Head title="Manage Files" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Files</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <Link href="files/create"><button
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Upload a new
              File</button>
            </Link>
            <table class="table-auto w-full">
              <thead>
                <tr>
                  <!-- <th class="border px-4 py-2">Preview</th> -->
                  <th class="border px-4 py-2">Title</th>
                  <th class="border px-4 py-2">Size</th>
                  <th class="border px-4 py-2">Type</th>
                  <th class="border px-4 py-2" width="250px">Action</th>
                </tr>
              </thead>
              <tbody v-if="files.length > 0">
                <tr v-for="file in files" :key="file.id">
                  <!-- <td class="border px-4 py-2">{{ file.path }}</td> -->
                  <td class="border px-4 py-2">{{ file.title }}</td>
                  <td class="border px-4 py-2">{{ file.size }}</td>
                  <td class="border px-4 py-2">{{ file.extension }}</td>
                  <td class="border px-4 py-2">
                    <Link :href="`files/${file.id}/edit`">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                    </Link>
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2"
                      @click="deleteFile(file.id)">
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>