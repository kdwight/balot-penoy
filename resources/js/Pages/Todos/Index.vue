<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import TodoTopicSection from "@/Components/Todos/TopicSection.vue";

const props = defineProps({
  todos: Array,
});
</script>

<template>
  <Head title="Users" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Todos</h2>
    </template>

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <!-- container -->
        <TodoTopicSection v-for="todo in todos" :topic="todo" />
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
