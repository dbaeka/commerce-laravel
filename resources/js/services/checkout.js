import * as Api from "../core/apis"
import {omit} from "lodash"

export async function getDefaultConfig() {
    const url = "/get-default-config"
    return Api.list(url)
}

export async function submitOrder(checkout_data, order_data) {
    const url = "/create-checkout"
    let payload = {
        "contact": {
            "email": checkout_data.email
        },
        "shipping": {
            ...omit(checkout_data, 'email')
        },
        "order": {
            "name": Math.random().toString(16),
            "items": order_data.items,
            "shipping_cost": order_data.shipping,
            "sub_total": order_data.sub_total,
            "total": order_data.total
        }
    }
    return Api.store(url, payload)
}
