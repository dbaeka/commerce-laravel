<template>
    <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm" ref="wrapper">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "BaseCard"
}
</script>
<script setup>
import {ref, defineExpose} from "vue";

const wrapper = ref(null)
defineExpose({wrapper})
</script>
