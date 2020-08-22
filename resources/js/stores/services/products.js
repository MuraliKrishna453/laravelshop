/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

import axios from "axios";

export default {
    create(data) {
        return axios.post("/api/products", data, {headers: {'Content-Type': 'multipart/form-data'}});
    },
    get(options) {
        return axios.get("/api/products?" + options);
    },
    product(id) {
        return axios.get("/api/products/" + id);
    },
    update(data) {
        return axios.post("/api/products/" + data.id, data.formData, {headers: {'Content-Type': 'multipart/form-data'}});
    },
    delete(data) {
        return axios.post("/api/products/" + data.id, data.formData);
    },
    status(data) {
        return axios.post("/api/products/status/" + data.id, data.formData);
    },
}

