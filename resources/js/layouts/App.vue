/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

<template>
<v-app>

  <v-app-bar class="border" app color="white" light flat>
    <v-toolbar-title class="headline mr-5">Laravel Shop</v-toolbar-title>
    <v-spacer />
    <v-toolbar-items v-if="!!isAuthenticated">
    <v-btn tile text  v-if="!!user && user.role=='admin'"  to="/admin/products">My Products</v-btn>
    <v-btn tile text  class="mx-3" v-if="!!user && user.role=='customer'" to="/products">Products</v-btn>
    <v-btn tile text  @click="logout()"> <v-icon class="mr-2">mdi-logout</v-icon>Logout</v-btn>

    </v-toolbar-items>
    <v-toolbar-items v-else>
      <v-btn tile text to="/login">Customer Login</v-btn>
      <v-btn tile text to="/register">Customer Register</v-btn>
      <v-btn tile text to="/admin">Admin Login</v-btn>
      <v-btn tile text to="/admin/register">Admin Register</v-btn>
    </v-toolbar-items>
  </v-app-bar>
      <!-- Provides the application the proper gutter -->
      <v-container fluid class="ma-5"  >
           <custom-snackbar />
        <!-- <div v-if="matchedUrls.length > 1">{{matchedUrls}}</div> -->
        <!-- If using vue-router -->
        <router-view></router-view>
      </v-container>
</v-app>
</template>

<script>
import { mapState, mapActions } from "vuex";
import CustomSnackbar from "../components/Snackbar";

export default {
   components: {
    CustomSnackbar
  },
  data: () => ({}),
  computed: {
      ...mapState("global", [
      "isAuthenticated",
      "user"
    ]),
  },
  created() {},
  methods: {
    ...mapActions("global", ["logout"]),
  },
  watch: {
      isAuthenticated(){
      if(!this.isAuthenticated){
        this.$router.go({
                    path: "/"
        });
      }

      }
  }
};
</script>

<style>
</style>
