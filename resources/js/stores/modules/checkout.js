import {formatInCurrency} from "../../helpers";
import * as FormService from "../../services/form";
import * as CheckoutService from "../../services/checkout";
import {useToast} from "vue-toastification";

const toast = useToast()

const getInitialState = () => ({
    items: {},
    sub_total: 0,
    shipping: 0,
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
    },
    actions: {
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
        shippingCost: (state) => formatInCurrency(state.shipping),
        totalCost: (state) => formatInCurrency(state.sub_total + state.shipping),
        subTotalCost: (state) => formatInCurrency(state.sub_total),
        orderItems: (state) => state.items,
        getItemQuantity: (state) => (id) => {
            return state.items[id] ? state.items[id].quantity : 0
        },
    }
}
export default checkout
