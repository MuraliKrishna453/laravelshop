<template>
  <v-row justify="center" align="center" class="mt-5">
    <v-col cols="12" lg="4" md="8" xl="4">
      <v-form ref="form" :valid="valid" @submit="submitForm($event)">
        <v-card outlined tile>
          <v-card-title class="justify-center headline">Create An Admin Account</v-card-title>
          <v-divider />
          <v-card-text>
            <v-text-field
              :rules="nameRules"
              v-model="name"
              required
              outlined
              label="Name"
              :error="!!errors.name"
              :error-messages="errors.name"
            />
            <v-text-field
              :rules="emailRules"
              v-model="email"
              required
              outlined
              label="Email"
              :error="!!errors.email"
              :error-messages="errors.email"
            />
            <v-text-field
              v-model="password"
              :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
              @click:append="show = !show"
              :rules="passwordRules"
              :type="show?'text':'password'"
              outlined
              label="Password"
            />
          </v-card-text>
          <v-divider />
          <v-card-actions class="pa-3">
            <v-btn
              type="submit"
              :loading="loading"
              :disabled="loading"
              color="primary"
            >Register</v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-col>
  </v-row>
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
  computed: {
    ...mapState("global", [
      "loading",
      "errors",
      "nameRules",
      "emailRules",
      "passwordRules",
      "isAuthenticated","user","messageColor"
    ])
  },
  data: () => ({
    valid: true,
    show: false,
    name: "",
    email:"",
    password: ""
  }),
  methods: {
    submitForm(e) {
      e.preventDefault();

      if (this.$refs.form.validate()) {
        const { name,email, password } = this;
        this.adminCreate({ name,email, password }).then(response=>{
            if(!!response && !!response.token){
                this.$router.go({
                    path: "/admin/products"
                });
            }
        });
      }
    },
    ...mapActions("admins", ["adminCreate"])
  },
  watch: {}
};
</script>

<style>
</style>

