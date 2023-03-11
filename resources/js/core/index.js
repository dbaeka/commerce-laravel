import * as Api from "./apis"
import VueLoading from 'vue-loading-overlay';
import Toast from "vue-toastification";

export default app => {
    app.provide('$http', Api);

    app.use(Toast, {
        position: "bottom-right",
        timeout: 5000,
        closeOnClick: true,
        pauseOnFocusLoss: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: true,
        closeButton: "button",
        icon: true,
        rtl: false
    })

    app.use(VueLoading);
}
