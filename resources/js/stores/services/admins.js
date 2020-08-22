/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

import axios from "axios";

export default {
    create(data) {
        return axios.post("/api/admins", data);
    },
   login(data) {
        return axios.post("/api/login" ,data);
    },
}

