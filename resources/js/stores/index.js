/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

import Vue from "vue";
import Vuex from "vuex";

import global from "@/js/stores/modules/global";
import customers from "@/js/stores/modules/customers";
import admins from "@/js/stores/modules/admins";
import products from "@/js/stores/modules/products";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        global,
        customers,
        admins,
        products
    }
})


