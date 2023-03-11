import {createApp} from 'vue'
import store from "./stores"
import core from "./core"
import pages from "./views/pages"
import components from "./components";

require('./bootstrap')

const app = createApp({})

app.use(store)

core(app)

pages(app)

components(app)
app.mount('#app')
