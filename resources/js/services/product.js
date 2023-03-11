import * as Api from "../core/apis"


export async function getAvailableProducts() {
    const url = "/get-products"
    return Api.list(url)
}
