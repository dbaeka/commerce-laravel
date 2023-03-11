<template>
    <button type="submit"
            class="w-full
            rounded-md
            border
            border-transparent
            bg-indigo-600
            py-3 px-4
            text-base
            font-medium
            text-white
            shadow-sm
            hover:bg-indigo-700
            focus:outline-none
            focus:ring-2
            focus:ring-indigo-500
            focus:ring-offset-2
            focus:ring-offset-gray-50">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "BaseButton",
}
</script>
<script setup>
</script>
