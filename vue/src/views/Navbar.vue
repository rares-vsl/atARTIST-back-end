<script setup>
import { ref } from 'vue'
const isAuth = ref(false)
</script>

<template>

  <nav class="bg-red-400 drop-shadow-lg shadow-black border-gray-200">
    <div class="flex justify-between items-center mx-auto text-blue-600 font-semibold">
      <RouterLink to="/">
        <span class="self-center text-xl">atARTIST</span>
      </RouterLink>

      <div class="w-auto">
        <ul class="flex p-4 gap-12">
          <li v-if="!isAuth">
            <RouterLink to="/auth/sign-in">
              Sign in
            </RouterLink>
          </li>
          <li v-if="!isAuth">
            <RouterLink to="/auth/sign-up">
              Sign up
            </RouterLink>
          </li>

          <li v-if="isAuth">
            <RouterLink to="/">
              {{ store.getters.username }}
            </RouterLink>
          </li>

          <li v-if="isAuth">
            <a @click="signOut"
               class="hover:underline cursor-pointer">Sign Out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>