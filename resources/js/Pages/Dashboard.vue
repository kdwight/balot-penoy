<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import TodoFormModal from "@/Components/Todos/FormModal.vue";
import TodoTopicSection from "@/Components/Todos/TopicSection.vue";

const props = defineProps({
  todos: Array,
});
</script>

<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Todos</h2>

        <TodoFormModal />
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <!-- container -->
        <TodoTopicSection v-for="todo in todos" :topic="todo" is-expanded />
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
