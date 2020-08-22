/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

import customerService  from "@/js/stores/services/customers";
export default {
    namespaced: true,
    state: {
        allproducts: [],
        productLoading: false
    },
    mutations: {
    },
    actions: {
        customerLogin( { commit, dispatch }, data) {
            commit("global/SET_ERRORS", "", {root: true});
            return  customerService.login(data)
                    .then(response => {
                        commit("global/SET_ERRORS", "", {root: true});
                        commit("global/SET_TOKEN", response.data.token, {root: true});
                        commit("global/SET_USER", response.data.user, {root: true});
                        return  response.data
                    }).catch(error => {
                        commit("global/SET_ERRORS", "", {root: true});
                dispatch("global/setDataException", error, {root: true})
            });
        },
        customerCreate( { commit, dispatch }, data) {
            commit("global/SET_ERRORS", "", {root: true});
            return  customerService.create(data)
                    .then(response => {
                        commit("global/SET_ERRORS", "", {root: true});
                        commit("global/SET_TOKEN", response.data.token, {root: true});
                        commit("global/SET_USER", response.data.customer, {root: true});
                        return response.data
                    }).catch(error => {
                dispatch("global/setException", error, {root: true})
            });
        },
    }
}

