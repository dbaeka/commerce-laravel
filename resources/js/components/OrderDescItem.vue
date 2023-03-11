<template>
    <div :class="'flex items-center justify-between ' + extraClass">
        <dt :class="titleClass">{{ title }}</dt>
        <dd :class="valueClass">{{ value }}</dd>
    </div>
</template>

<script>
export default {
    name: "OrderDescItem"
}
</script>
<script setup>
const props = defineProps({
    title: {
        type: String,
        required: true
    },
    value: {
        type: String,
        required: true
    },
    titleClass: {
        type: String,
        default: "text-sm"
    },
    valueClass: {
        type: String,
        default: "text-sm font-medium text-gray-900"
    },
    extraClass: {
        type: String,
        default: ""
    }
})
</script>
