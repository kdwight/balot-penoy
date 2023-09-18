<script setup>
import axios from "axios";
import { onMounted, reactive, ref } from "vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeButton from "@/Components/Button.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import Status from "@/Components/Status.vue";
import BreezeInputError from "@/Components/InputError.vue";

const collection = reactive({
    fetching: false,
    items: [],
});

function fetchUsers() {
    collection.fetching = true;
    axios
        .get(route("users.list"))
        .then(({ data }) => {
            collection.items = data.data;
        })
        .catch(({ response }) => console.warn(response));
}

const form = reactive({
    fields: {
        username: "",
        email: "",
        password: "",
    },
    errors: {},
    processing: false,
    modal: false,
});
function submitForm() {
    form.processing = true;

    axios
        .post(route("users.store"), form.fields)
        .then(({ data }) => {
            console.log(data.success);
            form.modal = false;
            Object.keys(form.fields).map((field) => (form.fields[field] = ""));
        })
        .catch(({ response }) => (form.errors = response.data.errors))
        .finally(() => (form.processing = false));
}

onMounted(async () => {
    await fetchUsers();
});
</script>

<template>
    <Head title="Users" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    User Management
                </h2>

                <button
                    class="ml-auto rounded px-4 py-2 bg-purple-400 text-white font-semibold"
                    @click="form.modal = true"
                >
                    Create
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- datatable -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="user in collection.items"
                                    :key="user.id"
                                >
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                    >
                                        {{ user.username }}
                                    </td>

                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                    >
                                        {{ user.email }}
                                    </td>

                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                    >
                                        <status
                                            :attributes="user"
                                            :endpoint="`/users/${user.id}/status`"
                                        />
                                    </td>

                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                    >
                                        <button
                                            class="text-indigo-600 hover:text-indigo-900"
                                            @click="form.modal = true"
                                        >
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- datatable -->
            </div>
        </div>

        <!-- form modal -->
        <section
            class="fixed inset-0 flex items-center justify-center bg-black/40"
            v-show="form.modal"
            @click="form.modal = false"
        >
            <div
                class="bg-white rounded-lg p-4 w-full max-w-lg shadow-lg"
                @click.stop
            >
                <div class="flex justify-between">
                    Create User

                    <button
                        class="text-xs underline"
                        @click="form.modal = false"
                    >
                        close
                    </button>
                </div>

                <form class="mt-10" @submit.prevent="submitForm">
                    <div class="mt-4">
                        <BreezeLabel for="username" value="Username" />
                        <BreezeInput
                            id="username"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.fields.username"
                        />
                        <BreezeInputError
                            :message="form.errors.username?.[0] ?? null"
                        />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel for="email" value="Email" />
                        <BreezeInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.fields.email"
                        />
                        <BreezeInputError
                            :message="form.errors.email?.[0] ?? null"
                        />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel for="password" value="Password" />
                        <BreezeInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.fields.password"
                        />
                        <BreezeInputError
                            :message="form.errors.password?.[0] ?? null"
                        />
                    </div>

                    <BreezeButton
                        class="mt-8 ml-auto"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Submit
                    </BreezeButton>
                </form>
            </div>
        </section>
        <!-- form modal -->
    </BreezeAuthenticatedLayout>
</template>
