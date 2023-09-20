<script setup>
import { onMounted, ref } from "vue";
import Toast from "@/Components/Toast.vue";
import TaskItem from "@/Components/Todos/TaskItem";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
  topic: {
    type: Object,
    required: true,
  },
  isExpanded: Boolean,
});

const expanded = ref(true);
const successMsg = ref("");

const tasks = ref(props.topic.items);

function addItem(additional) {
  tasks.value.push({
    title: "",
    ...additional,
  });
}

function showToast(msg) {
  successMsg.value = msg;

  Inertia.reload();
}

function removeItem(index) {
  tasks.value.splice(index, 1);
}

onMounted(() => {
  expanded.value = props.isExpanded;
});
</script>

<template>
  <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3 first:mt-0">
    <div class="p-6 bg-white border-b border-gray-200">
      <div
        :class="['flex items-center', { 'p-2 mb-6 rounded-lg shadow-md bg-stone-200': expanded }]"
        @click="expanded = !expanded"
      >
        <h6 class="font-bold" v-text="props.topic.title"></h6>
        <span class="text-xs ml-1 underline" v-if="Object.hasOwn(props.topic, 'author')">
          {{ props.topic.author.username }} ✍️
        </span>

        <button class="ml-auto">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            :class="['w-6 h-6', { 'rotate-180': expanded }]"
          >
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
          </svg>
        </button>
      </div>

      <ul class="divide-y space-y-2" v-show="expanded">
        <TaskItem
          v-for="(item, index) in tasks"
          :key="index"
          :topic="props.topic"
          :item="item"
          @success="showToast"
          @remove-item="removeItem(index)"
        />
      </ul>

      <div class="flex justify-end gap-2 mt-3">
        <button type="button" class="text-xs underline" @click.prevent="addItem()">+ add item</button>
        <button type="button" class="text-xs underline" @click.prevent="addItem({ target_date: '' })">
          + add item with date
        </button>
      </div>
    </div>

    <Toast :message="successMsg" @clear-msg="successMsg = ''" />
  </section>
</template>
