<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import DangerButton from '@/Components/DangerButton.vue';

const { files } = defineProps({
  files: {
    type: Object,
    default: () => [],
  },
});

const params = new URLSearchParams(document.location.search)
const url = document.location.href.split('/');
const prevURL = '/'+url[url.length-1];

const URLParams = reactive({});
URLParams.search = params.has('search') ? params.get('search'): '';
URLParams.page = params.has('page') ? params.get('page'): 1;

const form = useForm({});
const deleteFile = (id, title) => {
  let text = `Are you sure you want to delete the file: ${title}?\nEither OK or Cancel.`;
  if (confirm(text) == true) {
    form.delete(`files/${id}`);
  }
};

const formatBytes = (bytes, decimals = 2) => {
  if (!+bytes) return '0 Bytes'

  const k = 1024
  const dm = decimals < 0 ? 0 : decimals
  const sizes = ['Bytes', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB']

  const i = Math.floor(Math.log(bytes) / Math.log(k))

  return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
}

const isImage = (extension) => {
  return ['png', 'jpg', 'jpeg', 'svg', 'webp'].includes(extension.toLowerCase())
}

const search = () => {
  delete URLParams.page;
  navigate();
}

const paginate = (increment) => {
  if (files.current_page + increment > 0 && files.current_page + increment <= files.last_page) {
    URLParams.page = files.current_page + increment
    navigate();
  }
}

const navigate = () => {
  router.get('/files', URLParams, { replace: true });
}
</script>

<template>

  <Head title="Manage Files" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Files</h2>
    </template>

    <div class="py-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="flex flex-col md:flex-row justify-between gap-4 mb-4">
              <PrimaryButton @click="router.get( 'files/create', { prev: prevURL } )">
                + Upload a new File
              </PrimaryButton>
              <div class="grow flex">
                <TextInput class="border-gray-300 rounded-r-none shadow-none" type="search" v-model="URLParams.search"
                  id="search" />
                <SecondaryButton class="py-2 px-4 rounded-l-none border-l-0 shadow-none" @click="search()">
                  Search
                </SecondaryButton>
              </div>
              <div class="flex gap-2 justify-between items-center">
                <div class="flex justify-between items-center" v-if="files.total > 0">
                  <span class="py-2 px-2">
                    {{ files.from }} - {{ files.to }} / {{ files.total }}
                  </span>
                  <SecondaryButton @click="paginate(-1)" :disabled="files.prev_page_url===null" class="rounded-r-none"
                    :class="{ 'text-gray-400 shadow-none': files.prev_page_url !== null, 'bg-gray-300 border-gray-300 hover:bg-gray-300': files.prev_page_url === null }">
                    &laquo; Prev
                  </SecondaryButton>
                  <SecondaryButton @click="paginate(1)" :disabled="files.next_page_url===null" class="rounded-l-none"
                    :class="{ 'text-gray-400 shadow-none': files.next_page_url !== null, 'bg-gray-300 border-gray-300 hover:bg-gray-300': files.next_page_url === null }">
                    Next &raquo;
                  </SecondaryButton>
                </div>
              </div>
            </div>
            <div class="overflow-auto border rounded-lg">
              <table class="table-auto w-full">
                <thead>
                  <tr class="border-b bg-gray-50">
                    <th class="border-r px-1 py-1">Preview</th>
                    <th class="border-r px-2 py-1">Title</th>
                    <th class="border-r px-2 py-1">Size</th>
                    <th class="border-r px-2 py-1">Extension</th>
                    <th class="border-r px-2 py-1">Link</th>
                    <th class="">Action</th>
                  </tr>
                </thead>
                <tbody v-if="files.data.length">
                  <tr v-for="file in files.data" :key="file.id" class="border-b last:border-none">
                    <td class="border-r px-1 py-1">
                      <div v-if="isImage(file.extension)" class="bg-left-top bg-cover"
                        :style="'width:100px; height:100px; background-image: url(\'/storage/' + file.path + '\')'">
                      </div>
                      <div v-else style="width:100px; height:100px;"></div>
                    </td>
                    <td class="border-r px-2 py-1 w-full">{{ file.title }}</td>
                    <td class="border-r px-2 py-1 text-nowrap">{{ formatBytes(file.size) }}</td>
                    <td class="border-r px-2 py-1">{{ file.extension }}</td>
                    <td class="border-r px-2 py-1">
                      <Link class="underline" target="_blank" :href="'/storage/'+file.path">download</Link>
                    </td>
                    <td class="">
                      <div class="w-full h-full flex justify-end gap-2 px-1">
                        <PrimaryButton @click="router.get(`files/${file.id}/edit`, { prev: prevURL })">
                          Edit
                        </PrimaryButton>
                        <DangerButton @click="deleteFile(file.id, file.title)">
                          Delete
                        </DangerButton>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td class="px-2 py-1 italic text-center" colspan="6">Nothing found</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>