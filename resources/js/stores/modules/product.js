import * as ProductService from "../../services/product"
import {useToast} from "vue-toastification";

const toast = useToast();

const initialState = {
    products: []
}

const product = {
    namespaced: true,
    state: initialState,
    modules: {},
    mutations: {
        SET_PRODUCTS: (state, payload = []) => {
            state.products = payload
        },
    },
    actions: {
        async fetchProducts({commit}) {
            await ProductService.getAvailableProducts()
                .then(response => {
                    commit('SET_PRODUCTS', response)
                }).catch(() => {
                    toast.error("Failed to fetch available products")
                })
        },
    },
    getters: {
        availableProducts: (state) => state.products,
    }
}
export default product
