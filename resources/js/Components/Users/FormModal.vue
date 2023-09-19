<script setup>
import { reactive, ref, watchEffect } from "vue";
import { Inertia } from "@inertiajs/inertia";
import BreezeButton from "@/Components/Button.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeInputError from "@/Components/InputError.vue";
import Toast from "@/Components/Toast.vue";

const props = defineProps({
  roles: Array,
  user: Object,
});

const isEdit = ref(false);

const form = reactive({
  fields: {
    username: "",
    email: "",
    password: "",
    role_id: null,
  },
  successMsg: "",
  errors: {},
  processing: false,
  modal: false,
});

watchEffect(() => {
  if (Object.keys(props.user).length > 0) {
    form.modal = true;
    isEdit.value = true;

    for (const field in form.fields) {
      form.fields[field] = props.user[field];
    }
  }
});

function submitForm() {
  const method = isEdit.value ? "put" : "post";
  const endpoint = isEdit.value ? route("users.update", { user: props.user.id }) : route("users.store");
  const payload = { ...form.fields };

  if (isEdit.value) delete payload.password;

  form.processing = true;
  axios[method](endpoint, payload)
    .then(({ data }) => {
      closeModal();
      form.successMsg = data.success;
      Inertia.visit(route("users.index"));
    })
    .catch(({ response }) => (form.errors = response.data.errors))
    .finally(() => (form.processing = false));
}

function closeModal() {
  form.modal = false;
  form.errors = {};
  Object.keys(form.fields).map((field) => (form.fields[field] = ""));
  form.fields.role_id = null;
  isEdit.value = false;
}
</script>

<template>
  <button class="ml-auto rounded px-4 py-2 bg-purple-400 text-white font-semibold" @click="form.modal = true">
    Create
  </button>

  <section class="fixed inset-0 flex items-center justify-center bg-black/40" v-show="form.modal" @click="closeModal">
    <div class="bg-white rounded-lg p-4 w-full max-w-lg shadow-lg" @click.stop>
      <div class="flex justify-between">
        {{ isEdit ? "Edit" : "Create" }} User

        <button class="text-xs underline" @click="closeModal">close</button>
      </div>

      <form class="mt-10" @submit.prevent="submitForm">
        <div>
          <BreezeLabel for="role" value="Role" />
          <select
            id="role"
            class="mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            v-model="form.fields.role_id"
          >
            <option :value="null" selected>Select</option>
            <option v-for="role in props.roles" :value="role.id" v-text="role.name"></option>
          </select>
          <BreezeInputError :message="form.errors.role_id?.[0] ?? null" />
        </div>

        <div class="mt-4">
          <BreezeLabel for="username" value="Username" />
          <BreezeInput id="username" type="text" class="mt-1 block w-full" v-model="form.fields.username" />
          <BreezeInputError :message="form.errors.username?.[0] ?? null" />
        </div>

        <div class="mt-4">
          <BreezeLabel for="email" value="Email" />
          <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.fields.email" />
          <BreezeInputError :message="form.errors.email?.[0] ?? null" />
        </div>

        <div class="mt-4" v-if="!isEdit">
          <BreezeLabel for="password" value="Password" />
          <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.fields.password" />
          <BreezeInputError :message="form.errors.password?.[0] ?? null" />
        </div>

        <BreezeButton class="mt-8 ml-auto" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Submit
        </BreezeButton>
      </form>
    </div>
  </section>

  <Toast :message="form.successMsg" @clear-msg="form.successMsg = ''" />
</template>
