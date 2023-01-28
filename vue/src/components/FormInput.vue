<script setup>
import Error from '@/components/FormError.vue'

const props = defineProps({
    'modelValue': String,
    'blur': Function,
    'change': Function,
    'type': String,
    'name': String,
    'id': String,
    'placeholder': String,
    'title': String,
    'required': {
        default: false,
        type: Boolean
    },
    'msg': {
        default: [],
        type: Array
    }
})
defineEmits(['update:modelValue'])

</script>

<template>
    <div class="flex flex-col">
        <div class="flex items-center">
        <slot>

        </slot>
        <input :value="modelValue"
               @input="$emit('update:modelValue', $event.target.value)"
               @blur="blur"
               @change="change"
               :type="type"
               :name="name"
               :id="id"
               :placeholder="placeholder"
               :title="title"
               :required="required"
               :class="[
                'form-control block w-full px-4 py-2 text-xl font-normal text-black bg-white border border-solid  rounded transition ease-in-out m-0 focus:border-blue-600 focus:border-2 focus:outline-none ',
                msg.length ? 'border-red-600 bg-red-100' : 'border-gray-300',
                type === 'password' ? 'tracking-widest' : ''
                ]" />
    </div>
    <Error v-if="msg.length"
           class="mt-3 ml-10"
           :msg="msg" />
    </div>
</template>
