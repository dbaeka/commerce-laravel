require('./bootstrap')

import { createApp } from 'vue'
import { createStore } from 'vuex'

import Checkout from './components/Checkout'

const store = createStore({})

const app = createApp({})

app.use(store)

app.component('checkout', Checkout)

app.mount('#app')
