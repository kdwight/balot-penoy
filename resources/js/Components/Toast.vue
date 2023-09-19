<script setup>
import { watchEffect } from "vue";

const props = defineProps({
  message: String,
});

const emit = defineEmits(["clearMsg"]);

watchEffect(() => {
  if (props.message) {
    setTimeout(() => emit("clearMsg"), 3000);
  }
});
</script>

<template>
  <div
    class="fixed flex items-center gap-1 bg-blue-500 text-white font-bold py-2 pl-2 pr-4 rounded-md bottom-4 right-6 text-sm shadow-lg"
    v-show="props.message"
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      stroke-width="1.5"
      stroke="currentColor"
      class="w-6 h-6 fill-emerald-400"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
      />
    </svg>

    <p v-text="props.message"></p>
  </div>
</template>
