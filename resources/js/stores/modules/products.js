/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

import productService  from "@/js/stores/services/products";
export default {
  namespaced: true,
  state: {
    allproducts:[],
    productLoading:false
  },
  mutations: {
    SET_PRODUCT_LOADING(state) {
      state.productLoading = !state.productLoading;
    },
    SET_PRODUCTS(state, products) {
      state.allproducts = products;
    },
     UPDATE_PRODUCT_STATUS(state, product) {
      state.allproducts.data.forEach(p=>{
        if(p.id == product.id){
           p.status=product.status;
           return;
        }
      })
    },
    DELETE_PRODUCT(state, id) {

        state.allproducts.data = state.allproducts.data.filter(p=>p.id!=id);
      },
  },
  actions: {
    getProducts({ commit,dispatch },options) {
      commit("products/SET_PRODUCT_LOADING", "", { root: true });
      productService.get(options)
        .then(response => {
          commit("products/SET_PRODUCT_LOADING", "", { root: true });
          commit("products/SET_PRODUCTS", response.data, { root: true });
        }).catch(error => {
          commit("products/SET_PRODUCT_LOADING", "", { root: true });
          dispatch("global/setDataException",error, { root: true })
        });
    },
    productCreate({ commit,dispatch }, data) {
      commit("global/SET_ERRORS", "", { root: true });
      productService.create(data)
        .then(response => {
          commit("global/SET_ERRORS", "", { root: true });
          commit("global/setSuccess", {msg:"Product created successfully",color:"success"}, { root: true });
        }).catch(error => {
          dispatch("global/setException",error, { root: true })
        });
    },
    productUpdate({ commit ,dispatch}, data) {
      commit("global/SET_ERRORS", "", { root: true });
      productService.update(data)
        .then(response => {
          commit("global/SET_ERRORS", "", { root: true });
          commit("global/setSuccess", {msg:"Product updated successfully",color:"success"}, { root: true });
        }).catch(error => {
          dispatch("global/setException",error, { root: true })
        });
    },
    productDelete({ commit ,dispatch}, data) {

        commit("global/SET_ERRORS", "", { root: true });
        productService.delete(data)
          .then(response => {
            commit("global/SET_ERRORS", "", { root: true });
            commit("products/DELETE_PRODUCT",data.id, { root: true });
            commit("global/setSuccess", {msg:"Product deleted successfully",color:"success"}, { root: true });
          }).catch(error => {
            dispatch("global/setException",error, { root: true })
          });
      },
      productStatus({ commit ,dispatch}, data) {
        commit("global/SET_ERRORS", "", { root: true });
        productService.status(data)
          .then(response => {
            commit("global/SET_ERRORS", "", { root: true });
            commit("products/UPDATE_PRODUCT_STATUS", {id:data.id,status:response.data}, { root: true });
            commit("global/setSuccess", {msg:"Product status successfully",color:"success"}, { root: true });
          }).catch(error => {
            dispatch("global/setException",error, { root: true })
          });
      },
    getProduct({ commit,dispatch }, id) {
      commit("products/SET_PRODUCT_LOADING", "", { root: true });
      return productService.product(id)
        .then(response => {
          commit("products/SET_PRODUCT_LOADING", "", { root: true });
          return response}).catch(error =>{
            commit("products/SET_PRODUCT_LOADING", "", { root: true });
            dispatch("global/setDataException",error, { root: true })
          });
    }
  }
}
