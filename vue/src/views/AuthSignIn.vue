<script setup>
import { ref, reactive, computed } from 'vue'
import {
  EnvelopeIcon, LockClosedIcon
}
  from '@heroicons/vue/24/solid'
import { useUserStore } from '@/stores/UserStore'

import Input from '@/components/FormInput.vue'
import Submit from '@/components/FormSubmit.vue'

const user = reactive({
  username: 'test',
  email: 't@test.com',
  name: 'test',
  password: 'AdubuD4b$',
  password_confirmation: 'AdubuD4b$',
})

let dirtyUser = ''

const msg = reactive({
  username: [],
  name: [],
  email: [],
  password: [],
  password_confirmation: [],
})

const store = useUserStore()

const loading = ref(false)

function parseErrorsMsg(response) {
  const errors = response.data.data.errors
  for (var key in errors) {
    msg[key] = errors[key]
  }
  dirtyUser = Object.assign({}, user)
}

function clearErrorsMsg(e) {
  const field = e.target.name;
  if (msg[field].length && dirtyUser[field] != user[field])
    msg[field] = []
}

const isDisabled = computed(() => {
  let countEmptyInput = Object.keys(user).filter(el => user[el] === '').length

  let countMsg = Object.keys(msg).filter(el => msg[el] != '').length

  return countEmptyInput || countMsg
})

function signIn() {
  loading.value = true

  store.signUp(user)
    .catch((error) => {
      loading.value = false
      parseErrorsMsg(error.response)
    })
}

</script>

<template>
  <div class="mb-8 text-center z-0">
    <h1 class="text-gray-800 font-bold text-3xl mb-2 text-center">
      Welcome back
    </h1>

    <p>Don't have an account?<RouterLink :to="{ name: 'sign-up' }"
                  class="text-blue-700">
        Sign up
      </RouterLink>
    </p>
  </div>

  <form @submit.prevent="signIn"
        class="space-y-6">

    <Input v-model="user.email"
           :blur="clearErrorsMsg"
           :type="'email'"
           :name="'email'"
           :id="'email'"
           :placeholder="'Email'"
           :title="'Enter your email'"
           :required="true"
           :msg="msg.email">
    <EnvelopeIcon class="h-6 w-6 text-gray-400 mr-4" />
    </Input>

    <Input class="grow"
           v-model="user.password"
           :blur="clearErrorsMsg"
           :type="'password'"
           :name="'password'"
           :id="'password'"
           :placeholder="'Password'"
           :title="'Enter your password'"
           :required="true"
           :msg="msg.password">
    <LockClosedIcon class="h-6 w-6 text-gray-400 mr-4" />
    </Input>

    <div class="flex justify-between ml-10 flex-col md:flex-row space-y-5">
      <div class="form-check flex items-center">
        <input type="checkbox"
               value=""
               id="remember"
               class="form-check-input appearance-none h-6 w-6 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer">
        <label class="form-check-label inline-block text-gray-800 text-lg"
               for="flexCheckDefault">
          Remember me
        </label>
      </div>
      <RouterLink :to="{ name: 'sign-up' }"
                  class="text-blue-700 text-lg">
        Forgot password?
      </RouterLink>
    </div>
    <div>
      <Submit :submitStatus="isDisabled"
              :loading="loading">Sign In</Submit>
    </div>
  </form>

</template>