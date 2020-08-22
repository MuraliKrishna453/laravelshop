import "./bootstrap";
import Vue from "vue";

import App from "@/js/layouts/App";

import vuetify from "@/js/plugins/vuetify";
import router from "./routes";

import store from "./stores";

import Vuex from "vuex";
Vue.use(Vuex);

const app = new Vue({
    el: "#app",
    vuetify,
    router,
    store,
    render: h => h(App)
})

export default app;
