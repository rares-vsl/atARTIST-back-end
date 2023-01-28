import { defineStore } from 'pinia'
import axios from '@/axiosConfig.js'

export const useUserStore = defineStore('user', {
    state: () => ({
        users: [],
    }),
    getters: {
        getUsers(state) {
            return state.users
        }
    },
    actions: {
        async signUp(user) {
            const response = await axios.post('auth/register', user)
            this.users = response.data.user
            localStorage.setItem('user-token', token)
            localStorage.setItem('remember-me', true)
        }
    },
})