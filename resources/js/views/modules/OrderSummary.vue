<template>
    <div class="mt-10 lg:mt-0">
        <h2 class="text-lg font-medium text-gray-900">Order summary</h2>

        <BaseCard ref="loadingContainer">
            <h3 class="sr-only">Items in your cart</h3>
            <BaseList class="divide-y divide-gray-200">
                <BaseListItem class="flex py-6 px-4 sm:px-6" v-for="product in products.data"
                              :key="product.uuid">
                    <OrderItem :title="product.name"
                               :image-url="product.image_url"
                               :image-alt="product.name + ' ' + product.color"
                               :price="formatInCurrency(product.price, baseCurrency)"
                               :sub-title="product.color"
                               :max-quantity="maxQuantity"
                               :current-quantity="getItemQuantity(product.external_id)"
                               @update:current-quantity="updateItemQuantity(product, $event)"
                    >
                    </OrderItem>
                </BaseListItem>
            </BaseList>
            <BaseDescList class="space-y-6 border-t border-gray-200 py-6 px-4 sm:px-6">
                <OrderDescItem title="Subtotal" :value="sub_total"></OrderDescItem>
                <OrderDescItem title="Shipping" :value="shipping"></OrderDescItem>
                <OrderDescItem title="Total" :value="total"
                               extra-class="border-t border-gray-200 pt-6"></OrderDescItem>
            </BaseDescList>
            <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                <BaseButton class="disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="!validOrderItems || !validForm">
                    Submit order
                </BaseButton>
            </div>
        </BaseCard>
    </div>
</template>

<script>
export default {
    name: "OrderSummary"
}
</script>

<script setup>

import {useStore} from "vuex";
import {computed, inject, onMounted, ref} from "vue";
import OrderItem from "./OrderItem.vue";
import {formatInCurrency} from "../../helpers";

const store = useStore()

const $loading = inject("$loading");
const loadingContainer = ref(null);

const products = computed(() => store.getters["product/availableProducts"]);

const sub_total = computed(() => store.getters["checkout/subTotalCost"]);
const total = computed(() => store.getters["checkout/totalCost"]);
const shipping = computed(() => store.getters["checkout/shippingCost"]);

const validOrderItems = computed(() => store.getters["checkout/validOrderItems"]);
const validForm = computed(() => store.getters["checkout/validForm"])
const baseCurrency = computed(() => store.getters["checkout/getBaseCurrency"])
const maxQuantity = computed(() => store.getters["checkout/getMaxQuantity"])

const getItemQuantity = (id) => {
    return store.getters["checkout/getItemQuantity"](id)
};

const updateItemQuantity = (product, quantity) => {
    const payload = {
        product_id: product.external_id,
        name: product.name,
        slug: product.slug,
        price: product.price,
        quantity: parseInt(quantity),
    }
    store.dispatch("checkout/updateOrder", payload);
};
const listProducts = async () => {
    let loader = $loading.show({container: loadingContainer.value.wrapper.value});
    await store.dispatch("product/fetchProducts");
    loader.hide();

};

onMounted(async () => {
    await store.dispatch("checkout/getDefaultConfig");
    await listProducts();
})

</script>
