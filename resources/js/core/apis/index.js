import request from "./init"

export function list(url) {
    return request({
        url: url,
        method: 'get',
    })
}

export function store(url, data) {
    return request({
        url: url,
        method: 'post',
        data
    })
}


