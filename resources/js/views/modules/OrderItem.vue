<template>
    <div class="flex-shrink-0">
        <img :src="imageUrl" :alt="imageAlt"
             class="w-20 rounded-md">
    </div>

    <div class="ml-6 flex flex-1 flex-col">
        <div class="flex">
            <div class="min-w-0 flex-1">
                <h4 class="text-sm">
                    <a href="#"
                       class="font-medium text-gray-700 hover:text-gray-800">{{
                            title
                        }}</a>
                </h4>
                <p class="mt-1 text-sm text-gray-500">{{ subTitle }}</p>
            </div>
        </div>

        <div class="flex flex-1 items-end justify-between pt-2">
            <p class="mt-1 text-sm font-medium text-gray-900">{{ price }}</p>

            <div class="ml-4">
                <label for="quantity" class="sr-only">Quantity</label>
                <select id="quantity" name="quantity"
                        :value="currentQuantity"
                        @change="updateQuantity"
                        class="rounded-md border border-gray-300 text-left text-base font-medium
                                                text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none
                                                focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                    <option v-for="index in range(maxQuantity)"
                            :value="index" :key="index">{{ index }}
                    </option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "OrderItem"
}
</script>
<script setup>
import {range} from "lodash";

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    subTitle: {
        type: String,
        required: true
    },
    price: {
        type: String,
        required: true
    },
    imageUrl: {
        type: String,
        required: true
    },
    imageAlt: {
        type: String,
    },
    maxQuantity: {
        type: Number,
        default: 8
    },
    currentQuantity: {
        type: [String, Number],
        default: ''
    }
})

const emit = defineEmits(['update:currentQuantity'])

const updateQuantity = ($event) => {
    emit('update:currentQuantity', $event.target.value)
}

</script>
