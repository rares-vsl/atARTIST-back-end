<script setup>
const p = defineProps(['msg'])
console.log(typeof (p.msg))
</script>

<template>
  <ul class="text-red-500 font-semibold list-disc list-inside">
    <li v-for="item in Object.values(msg)"
        class="text-lg">
      {{ item }}
    </li>
  </ul>
</template>