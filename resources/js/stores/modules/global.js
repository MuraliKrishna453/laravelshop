/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
import axios from 'axios';
export default {
    namespaced: true,
    state: {
        loading: false,
        errors: [],
        isAuthenticated: !!localStorage.getItem("token"),
        isAdminAuthenticated: !!localStorage.getItem("token"),
        user:
                !!localStorage.getItem("user") &&
                JSON.parse(localStorage.getItem("user")),
        nameRules: [(v) => !!v || "Name is required"],
        firstnameRules: [(v) => !!v || "Firstname is required"],
        lastnameRules: [(v) => !!v || "Lastname is required"],
        emailRules: [
            (v) => !!v || "Email is required",
            (v) => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || "Invalid email format"
        ],
        priceRules: [
            (v) => !!v || "Price is required",
            (v) =>
                /^(?=.*[1-9])[0-9]*[.]?[0-9]{1,2}$/.test(v) ||
                        "Price must be valid number with 1 or 2 decimals",
        ],
        discountRules: [
            (v) => !!v || "Discount is required",
            (v) =>
                /^([1-9]\d?|0)(\.\d{1,2})?$/.test(v) ||
                        "Discount valid number with 1 or 2 decimals",
        ],
        imageRules: [(v) => !!v || "Image is required"],
        mobileRules: [
            (v) => !!v || "Mobile is required",
            (v) => /^[0-9]{10}$/.test(v) || "Mobile must be 10 digits valid number",
        ],
        passwordRules: [
            (v) => !!v || "Password is required"
        ],
        imagesExt: ".png, .jpeg, .jpg",
        descriptionRules: [v => v.length <= 250 || 'Max 250 characters'],
        message: "",
        messageColor: ""
    },
    getters: {
        isAdmin: (state) =>
            state.isAuthenticated &&
                    state.user && state.user.role == 'admin',
        isCustomer: (state) =>
            state.isAuthenticated &&
                    state.user && (state.user.role == 'customer' && !state.user.role),
    },
    mutations: {
        setSuccess(state, data) {
            state.message = data.msg;
            state.messageColor = data.color
        },
        SET_ERRORS(state, errors) {
            state.errors = errors;
            state.loading = !state.loading;
        },
        SET_USER(state, user) {
            state.user = user;
            localStorage.setItem("user", JSON.stringify(user));
        },
        SET_TOKEN(state, token) {
            localStorage.setItem("token", token);
            if (token) {
                state.isAuthenticated = true;
            } else {
                state.isAuthenticated = false;
            }
        },
    },
    actions: {
        setDataException( { commit }, error) {
            commit("global/SET_ERRORS", "", {root: true});
            let data = error.response.data
            if (data.errors) {
                commit("global/SET_ERRORS", data.errors, {root: true});
            } else {
                commit("global/SET_ERRORS", "", {root: true});
                commit("global/setSuccess", {msg: data.message, color: "error"}, {root: true});
        }
        },
        setException( { commit }, error) {
            let data = error.response.data
            if (data.errors) {
                commit("global/SET_ERRORS", data.errors, {root: true});
            } else {
                commit("global/SET_ERRORS", "", {root: true});
                commit("global/setSuccess", {msg: data.message, color: "error"}, {root: true});
        }
        },
        logout({ commit,dispatch }, data) {
            commit("global/SET_ERRORS", "", { root: true });
             axios.post("/api/logout").then(async(response) => {
              await localStorage.removeItem("user");
              await localStorage.removeItem("token");
              commit("global/SET_TOKEN", "", { root: true });
              commit("global/SET_USER", "", { root: true });
              commit("global/setSuccess", {msg:"LoggedOut successfully",color:"success"}, { root: true });
              commit("global/SET_ERRORS", "", { root: true });
            }).catch(error => {
              commit("global/SET_ERRORS", "", { root: true });
              dispatch("global/setException",error, { root: true })
            });
          },
    }
};

