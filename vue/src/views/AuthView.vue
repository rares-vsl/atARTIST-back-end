<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
const route = useRoute()
const routeName = ref(route.name)
</script>

<template>
    <a href="/"
       class="hidden xl:flex items-start
        absolute top-10 left-10 z-10 p-0.5 rounded-full opacity-80 gap-2">
        <img :src="'/images/logo.svg'"
             class="w-7 h-7 " />
        <span class="font-kalam font-light  text-3xl text-white">ARTIST</span>
    </a>

    <div class="md:flex w-full overflow-hidden h-screen">
        <div
             class="relative overflow-hidden hidden xl:flex w-[32rem] pt-[8.5rem] space-y-16 px-12 flex-col justify-top items-center text-white bg-gradient-to-tr from-indigo-500 via-blue-700 to-blue-500 z-1">
            <div class="space-y-8 w-full">
                <h1 class="font-bold text-5xl font-sans leading-tight">Take your career to the next level!</h1>
                <p class="font-light text-base font-sans w-[18rem]">
                    Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Donec commodo, massa nec
                    efficitur luctus, dui massa vulputate
                </p>
            </div>

            <RouterView name="Hero" />
        </div>

        <div class="grow flex flex-col justify-start items-center bg-white  py-[7%] h-full overflow-y-auto">
            <div class="flex flex-col p-12 md:w-[42rem] w-full">
                <RouterView name="Form" />
            </div>
        </div>
    </div>
</template>

