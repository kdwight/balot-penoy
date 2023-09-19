<script setup>
import { onMounted, reactive, ref } from "vue";
import { Head } from "@inertiajs/inertia-vue3";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import UserFormModal from "@/Components/Users/FormModal";
import { Inertia } from "@inertiajs/inertia";
import Toast from "@/Components/Toast.vue";

const props = defineProps({
  roles: Array,
});

const successMsg = ref("");
const selectedUser = ref({});
const collection = reactive({
  fetching: false,
  items: [],
});

function fetchUsers() {
  collection.fetching = true;
  axios
    .get(route("users.list"))
    .then(({ data }) => (collection.items = data.data))
    .catch(({ response }) => console.warn(response));
}

function deleteUser(user) {
  axios.delete(route("users.destroy", { user })).then(({ data }) => {
    fetchUsers();
    successMsg.value = data.success;
    Inertia.reload();
  });
}

onMounted(() => {
  fetchUsers();
});
</script>

<template>
  <Head title="Users" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <div class="flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Management</h2>

        <UserFormModal :roles="props.roles" :user="selectedUser" />
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- datatable -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
              <tbody class="bg-white divide-y divide-gray-200">
                <tr class="text-xs font-medium text-gray-900" v-for="user in collection.items" :key="user.id">
                  <td class="px-6 py-4 whitespace-nowrap">
                    {{ user.username }}
                  </td>

                  <td class="px-6 py-4">
                    {{ user.email }}
                  </td>

                  <td class="px-6 py-4">
                    {{ user.role?.name }}
                  </td>

                  <td class="px-6 py-4 flex justify-end" v-if="user.id !== 1">
                    <button class="text-indigo-600 hover:text-indigo-900" @click="selectedUser = user">Edit</button>
                    <button class="ml-1 text-rose-600 hover:text-indigo-900" @click="deleteUser(user)">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- datatable -->
      </div>
    </div>

    <Toast :message="successMsg" @clear-msg="successMsg = ''" />
  </BreezeAuthenticatedLayout>
</template>
