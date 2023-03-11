import {formatInCurrency} from "../../helpers";
import * as FormService from "../../services/form";
import * as CheckoutService from "../../services/checkout";
import {useToast} from "vue-toastification";

const toast = useToast()

const getInitialState = () => ({
    items: {},
    sub_total: 0,
    shipping: 5,
    currency: 'USD',
    maxQuantity: 8,
    formErrors: {},
    form: {
        email: "",
        first_name: "",
        last_name: "",
        address: "",
        apartment_suite: "",
        city: "",
        country: "",
        state_province: "",
        postal_code: "",
        phone: ""
    }
})

const checkout = {
    namespaced: true,
    state: getInitialState(),
    modules: {},
    mutations: {
        UPDATE_ITEMS: (state, payload = []) => {
            state.items[payload.product_id] = payload
        },
        UPDATE_COST: (state, payload = 0) => {
            state.sub_total = payload
        },
        SET_FORM_ERRORS: (state, payload = {}) => {
            state.formErrors = payload
        },
        RESET_STATE: (state) => {
            Object.assign(state, getInitialState())
        },
        SET_DEFAULT_CONFIG: (state, payload = []) => {
            state.currency = payload.base_currency
            state.maxQuantity = payload.max_quantity
            state.shipping = payload.shipping_cost
        },
    },
    actions: {
        async getDefaultConfig({commit}) {
            await CheckoutService.getDefaultConfig()
                .then(response => {
                    commit('SET_DEFAULT_CONFIG', response.data)
                }).catch(() => {
                    toast.error("Failed to getting config")
                })
        },
        async submitForm({commit, state}) {
            let order_data = {
                "items": state.items,
                "shipping": state.shipping,
                "sub_total": state.sub_total,
                "total": state.sub_total + state.shipping
            }
            await CheckoutService.submitOrder(state.form, order_data)
                .then(() => {
                    commit('RESET_STATE')
                    toast.success("Checkout submitted successfully")
                }).catch(error => {
                    commit('SET_FORM_ERRORS', FormService.getErrors(error))
                })
        },
        resetFormErrors({commit}) {
            commit('SET_FORM_ERRORS')
        },
        updateOrder({commit, dispatch, getters}, payload) {
            commit('UPDATE_ITEMS', payload)
            dispatch('updateCost')
        },

        updateCost({commit, getters}) {
            const sub_total = Object.values(getters.orderItems).reduce((acc, item) => {
                return acc + (item.price * item.quantity);
            }, 0);
            commit('UPDATE_COST', sub_total)
        }

    },
    getters: {
        getFormErrors: (state) => state.formErrors,
        getForm: (state) => state.form,
        shippingCost: (state) => formatInCurrency(state.shipping, state.currency),
        totalCost: (state) => formatInCurrency(state.sub_total + state.shipping, state.currency),
        subTotalCost: (state) => formatInCurrency(state.sub_total, state.currency),
        getBaseCurrency: (state) => state.currency,
        getMaxQuantity: (state) => state.maxQuantity,
        orderItems: (state) => state.items,
        getItemQuantity: (state) => (id) => {
            return state.items[id] ? state.items[id].quantity : 0
        },
        validOrderItems: (state) => {
            return !_.every(_.values(state.items), {quantity: 0});
        },
        validForm: (state) => {
            return !_.some(_.omit(state.form, 'apartment_suite'), _.isEmpty);
        }
    }
}
export default checkout
