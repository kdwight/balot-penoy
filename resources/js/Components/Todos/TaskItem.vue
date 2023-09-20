<script setup>
import { computed, onMounted, reactive, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import BreezeInput from "@/Components/Input.vue";
import BreezeInputError from "@/Components/InputError.vue";

const props = defineProps({
  topic: Object,
  item: Object,
});

const emit = defineEmits(["success"]);

const isEditting = ref(false);
const isNewItem = computed(() => !Object.hasOwn(props.item, "id"));

function checkDeadline(date) {
  const diff = (new Date(date) - new Date()) / (1000 * 3600 * 24);

  return diff <= 2;
}

function toggleStatus(item) {
  axios
    .patch(route("todos.status", { item }), { completed: !item.completed })
    .then(({ data }) => emit("success", data.success))
    .catch(({ response }) => console.log(response));
}

function deleteTodo(item) {
  axios.delete(route("todos.delete-item", { item })).then(({ data }) => {
    Inertia.reload();
    emit("success", data.success);
  });
}

const form = reactive({
  errors: {},
  fields: {},
});

function editItem() {
  const { title, target_date } = props.item;
  const fields = {
    title,
    target_date,
  };

  if (!target_date) delete fields.target_date;

  form.fields = fields;
  isEditting.value = true;
}

function saveItem() {
  const method = isNewItem.value ? "post" : "put";
  const endpoint = isNewItem.value
    ? route("todos.store-item", { todo: props.topic.id })
    : route("todos.update-item", { item: props.item.id });

  axios[method](endpoint, form.fields)
    .then(({ data }) => {
      Inertia.reload();
      emit("success", data.success);
      isEditting.value = false;
    })
    .catch(({ response }) => (form.errors = response.data.errors));
}

onMounted(() => {
  if (isNewItem.value) {
    form.fields = props.item;
    isEditting.value = true;
  }
});
</script>

<template>
  <li :class="['pt-2', { 'hover:bg-slate-200': !isEditting }]">
    <div :class="['flex items-center', { 'text-green-500': props.item.completed }]">
      <template v-if="isEditting">
        <div class="w-full flex gap-2 ml-5">
          <BreezeInput type="text" class="w-full" placeholder="Add list todo items..." v-model="form.fields.title" />
          <BreezeInput
            v-if="Object.hasOwn(props.item, 'target_date')"
            type="date"
            :min="new Date().toISOString().slice(0, 10)"
            v-model="form.fields.target_date"
          />
        </div>
      </template>

      <template v-else>
        <div class="flex items-center gap-2 mr-2 text-xs">
          <button :class="props.item.completed ? 'text-red-500' : 'text-blue-500'" @click="toggleStatus(item)">
            {{ props.item.completed ? "🟢" : "◯" }}
          </button>
        </div>

        <p>{{ props.item.title }}</p>

        <span
          :class="[
            'ml-auto text-xs',
            checkDeadline(item?.target_date ?? null) ? 'text-red-600 font-extrabold' : 'text-violet-400',
          ]"
        >
          {{ props.item.target_date }}
        </span>
      </template>
    </div>

    <div class="mt-2 ml-5 flex items-center gap-2 text-xs">
      <template v-if="isEditting">
        <button class="hover:underline" @click="isEditting = !isEditting">close</button>
        <button class="hover:underline text-cyan-600" @click="saveItem">save</button>
      </template>

      <template v-else>
        <button class="hover:underline font-extrabold" @click="editItem">edit</button>
        <button class="hover:underline text-red-400" @click="deleteTodo(item)">delete</button>
      </template>
    </div>
  </li>
</template>
