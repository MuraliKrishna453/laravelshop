/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

import adminService  from "@/js/stores/services/admins";
export default {
    namespaced: true,
    state: {
        allproducts: [],
        productLoading: false
    },
    mutations: {
    },
    actions: {
        adminLogin( { commit, dispatch }, data) {
            commit("global/SET_ERRORS", "", {root: true});
            return adminService.login(data)
                    .then(response => {
                        commit("global/SET_TOKEN", response.data.token, {root: true});
                        commit("global/SET_USER", response.data.admin, {root: true});
                        commit("global/SET_ERRORS", "", {root: true});
                        return response.data;
                    }).catch(error => {
                        commit("global/SET_ERRORS", "", {root: true});
                        dispatch("global/setDataException", error, {root: true})
            });
        },
        adminCreate( { commit, dispatch }, data) {
            commit("global/SET_ERRORS", "", {root: true});
            return adminService.create(data)
                    .then(response => {
                        commit("global/SET_TOKEN", response.data.token, {root: true});
                        commit("global/SET_USER", response.data.admin, {root: true});
                        commit("global/SET_ERRORS", "", {root: true});
                        return response.data;
                    }).catch(error => {
                dispatch("global/setException", error, {root: true})
            });
        },
    }
}
