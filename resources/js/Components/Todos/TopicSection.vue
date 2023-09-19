<script setup>
import { Inertia } from "@inertiajs/inertia";
import { onMounted, ref } from "vue";

const props = defineProps({
  topic: {
    type: Object,
    required: true,
  },
  isExpanded: Boolean,
});

const expanded = ref(true);

function toggleStatus(item) {
  axios
    .patch(route("todos.status", { todo: item.id }), { completed: !item.completed })
    .then(({ data }) => Inertia.reload())
    .catch(({ response }) => console.log(response));
}

onMounted(() => {
  expanded.value = props.isExpanded;
});
</script>

<template>
  <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3 first:mt-0">
    <div class="p-6 bg-white border-b border-gray-200">
      <div :class="['flex items-center', { 'p-2 mb-6 rounded-lg shadow-md bg-stone-200': expanded }]">
        <h6 class="font-bold" v-text="props.topic.title"></h6>
        <span class="text-xs ml-1 underline" v-if="Object.hasOwn(props.topic, 'author')">
          {{ props.topic.author.username }} ✍️
        </span>

        <button class="ml-auto" @click="expanded = !expanded">
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
        <li v-for="item in topic.items" :key="item.id">
          <div :class="['flex items-center', { 'text-green-500': item.completed }]">
            {{ item.title }}

            <div class="flex items-center gap-2 ml-auto text-xs">
              <button :class="item.completed ? 'text-red-500' : 'text-blue-500'" @click="toggleStatus(item)">
                {{ item.completed ? "🟢" : "◯" }}
              </button>
            </div>
          </div>

          <span class="text-xs text-violet-400">{{ item.target_date }}</span>
        </li>
      </ul>
    </div>
  </section>
</template>
