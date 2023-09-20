<script setup>
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import BreezeButton from "@/Components/Button.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeInputError from "@/Components/InputError.vue";
import Toast from "@/Components/Toast.vue";

const initialFields = () => {
  return {
    title: "",
    items: [{ title: "" }],
  };
};
const form = reactive({
  modal: false,
  processing: false,
  errors: {},
  successMsg: "",
  fields: initialFields(),
});

function addItem(additional) {
  form.fields.items.push({
    title: "",
    ...additional,
  });
}

function submitForm() {
  form.processing = true;

  axios
    .post(route("todos.store"), form.fields)
    .then(({ data }) => {
      closeModal();
      form.successMsg = data.success;
      Inertia.visit(route("dashboard"));
    })
    .catch(({ response }) => (form.errors = response.data.errors))
    .finally(() => (form.processing = false));
}

function closeModal() {
  form.modal = false;
  form.errors = {};
  form.fields = initialFields();
}
</script>

<template>
  <button class="ml-auto rounded px-4 py-2 bg-amber-400 text-white font-extrabold" @click="form.modal = true">
    New List 📝
  </button>

  <section
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
    v-show="form.modal"
    @click="closeModal"
  >
    <div class="bg-white rounded-lg mx-4 p-4 w-full max-w-lg shadow-lg" @click.stop>
      <div class="flex justify-between">
        <p>Create</p>

        <button class="text-xs underline" @click="closeModal">close</button>
      </div>

      <form class="mt-10 space-y-4" @submit.prevent="submitForm">
        <!-- title -->
        <div>
          <BreezeLabel for="title" value="Title" />
          <BreezeInput
            id="title"
            type="text"
            class="mt-1 block w-full"
            placeholder="List Title"
            v-model="form.fields.title"
          />
          <BreezeInputError :message="form.errors.title?.[0] ?? null" />
        </div>

        <!-- items -->
        <div>
          <BreezeLabel value="Items" />

          <template v-for="(item, index) in form.fields.items" :key="item.id">
            <div class="flex gap-2 mt-1">
              <BreezeInput
                type="text"
                class="w-full"
                placeholder="Add list todo items..."
                v-model="form.fields.items[index].title"
              />
              <BreezeInput
                v-if="Object.hasOwn(form.fields.items[index], 'target_date')"
                type="date"
                :min="new Date().toISOString().slice(0, 10)"
                v-model="form.fields.items[index].target_date"
              />
              <button
                v-show="form.fields.items.length > 1"
                type="button"
                class="shrink-0 flex items-center justify-center w-4 h-4 rounded-full border self-center text-xs text-red-600 font-bold border-red-600"
                @click.prevent="form.fields.items.splice(index, 1)"
              >
                &#8722;
              </button>
            </div>

            <BreezeInputError :message="form.errors[`items.${index}.title`]?.[0] ?? null" />
            <BreezeInputError :message="form.errors[`items.${index}.target_date`]?.[0] ?? null" />
          </template>

          <!-- add item button -->
          <div class="flex gap-2 mt-3">
            <button type="button" class="text-xs underline" @click.prevent="addItem()">+ add item</button>
            <button type="button" class="text-xs underline" @click.prevent="addItem({ target_date: '' })">
              + add item with date
            </button>
          </div>
        </div>

        <BreezeButton class="mt-8" type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Submit
        </BreezeButton>
      </form>
    </div>
  </section>

  <Toast :message="form.successMsg" @clear-msg="form.successMsg = ''" />
</template>
