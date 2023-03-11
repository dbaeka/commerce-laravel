<template>
    <div>
        <h2 class="sr-only">Checkout</h2>

        <form @submit.prevent="submit" ref="loadingContainer" class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
            <CheckoutForm></CheckoutForm>
            <OrderSummary></OrderSummary>
        </form>
    </div>
</template>

<script>
export default {
    name: 'Checkout'
}
</script>

<script setup>

import OrderSummary from "../modules/OrderSummary.vue";
import CheckoutForm from "../modules/CheckoutInfo.vue";
import {computed, inject, ref} from "vue";
import {useStore} from "vuex";

const store = useStore()
const $loading = inject("$loading");
const loadingContainer = ref(null);

const form = computed(() => store.getters["checkout/getForm"])

const submit = async () => {
    let loader = $loading.show({container: loadingContainer.value});
    await store.dispatch("checkout/submitForm", form)
    loader.hide()
};
</script>
