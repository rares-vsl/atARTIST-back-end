<script setup>
import { ref, reactive, computed } from 'vue'
import {
  AtSymbolIcon, EnvelopeIcon, UserIcon, LockClosedIcon, ArrowUturnRightIcon,
  EyeIcon, EyeSlashIcon
}
  from '@heroicons/vue/24/solid'

import axios from '@/axiosConfig.js'
import { useUserStore } from '@/stores/UserStore'

import Input from '@/components/FormInput.vue'
import Submit from '@/components/FormSubmit.vue'

const user = reactive({
  name: 'test',
  username: 'test',
  email: 't@test.com',
  password: 'AdubuD4b$',
  password_confirmation: 'AdubuD4b$',
})

let dirtyUser = ''

const msg = reactive({
  name: [],
  username: [],
  email: [],
  password: [],
  password_confirmation: [],
})


const store = useUserStore();

const loading = ref(false)
const pswShow = ref(false)

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

function availableUsername() {
  if (!user.username) {
    return ''
  }

  axios.get('auth/username', {
    params: {
      username: user.username,
    }
  })
    .then(function (response) {
      msg.username = []
    })
    .catch((error) => {
      parseErrorsMsg(error.response)
    })
}

function availableEmail() {
  if (!user.email) {
    return ''
  }

  axios.get('auth/email', {
    params: {
      email: user.email,
    }
  })
    .then(function (response) {
      msg.email = []
    })
    .catch((error) => {
      parseErrorsMsg(error.response)
    })
}

function showPassword() {
  pswShow.value = !pswShow.value
}

const isDisabled = computed(() => {
  let countEmptyInput = Object.keys(user).filter(el => user[el] === '').length

  let countMsg = Object.keys(msg).filter(el => msg[el] != '').length

  return countEmptyInput || countMsg
})

const passwordType = computed(() => {
  if (pswShow.value)
    return 'text'
  return 'password'
})

function signUp() {
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
      Create an account
    </h1>

    <p>Already have account? <RouterLink :to="{ name: 'sign-in' }"
                  class="text-blue-700">
        Sign In
      </RouterLink>
    </p>
  </div>

  <form @submit.prevent="signUp"
        class="space-y-6">
    <Input v-model="user.name"
           :blur="clearErrorsMsg"
           :type="'name'"
           :name="'name'"
           :id="'name'"
           :placeholder="'Name'"
           :title="'Enter your name'"
           :required="true"
           :msg="msg.name">
    <UserIcon class="h-6 w-6 text-gray-400 mr-4"
              title="So nice to see you!" />
    </Input>
    <Input v-model="user.username"
           :blur="availableUsername"
           :type="'text'"
           :name="'username'"
           :id="'username'"
           :placeholder="'Username'"
           :title="'Enter your username'"
           :required="true"
           :msg="msg.username">
    <AtSymbolIcon class="h-6 w-6 text-gray-400 mr-4" />
    </Input>

    <Input v-model="user.email"
           :blur="availableEmail"
           :type="'email'"
           :name="'email'"
           :id="'email'"
           :placeholder="'Email'"
           :title="'Enter your email'"
           :required="true"
           :msg="msg.email">
    <EnvelopeIcon class="h-6 w-6 text-gray-400 mr-4" />
    </Input>
    <div class="flex relative">
      <Input class="grow"
             v-model="user.password"
             :blur="clearErrorsMsg"
             :type="passwordType"
             :name="'password'"
             :id="'password'"
             :placeholder="'Password'"
             :title="'Enter your password'"
             :required="true"
             :msg="msg.password">
      <LockClosedIcon class="h-6 w-6 text-gray-400 mr-4" />
      </Input>
      <a @click="showPassword"
         tpye="password"
         class="absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer">
        <EyeSlashIcon v-if="pswShow"
                      class="h-6 w-6 text-gray-400" />
        <EyeIcon v-else
                 class="h-6 w-6 text-gray-400" />
      </a>
    </div>

    <Input v-model="user.password_confirmation"
           :blur="clearErrorsMsg"
           :type="'password'"
           :name="'password_confirmation'"
           :id="'password_confirmation'"
           :placeholder="'Confirm password'"
           :title="'Re-enter your password'"
           :required="true"
           :msg="msg.password_confirmation">
    <ArrowUturnRightIcon class="h-6 w-6 text-gray-400 mr-4" />
    </Input>

    <div>
      <Submit :submitStatus="isDisabled"
              :loading="loading">Sign Up</Submit>
    </div>
  </form>

</template>