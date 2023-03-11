import {createStore} from "vuex"

import product from "./modules/product"
import checkout from "./modules/checkout"

const store = createStore({
    modules: {
        product,
        checkout,
    },
    state() {
        return {};
    },
    mutations: {},
    actions: {},
    getters: {},
})

export default store
