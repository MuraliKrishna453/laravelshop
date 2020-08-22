
<template>
  <v-row justify="center" align="center" class="mt-5">
    <v-col cols="12" lg="4" md="8" xl="4">
      <v-form ref="form" :valid="valid" @submit="submitForm($event)">
        <v-card outlined tile>
          <v-card-title class="justify-center headline">Customer Login</v-card-title>
          <v-card-subtitle
            class="text-center"
          >Shop Online</v-card-subtitle>
          <v-divider />
          <v-card-text>
            <v-text-field
              :rules="emailRules"
              v-model="email"
              :error="!!errors.email"
              :error-messages="errors.email"
              required
              outlined
              label="Email"
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
              :loading="loading"
              :disabled="loading"
              color="primary"
              type="submit"
            >Login</v-btn>
          </v-card-actions>
          <v-divider />
        </v-card>
      </v-form>
    </v-col>
  </v-row>
  <!-- </v-img> -->
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
  computed: {
    ...mapState("global", [
      "isAuthenticated",
      "user",
      "loading",
      "errors",
      "emailRules",
      "passwordRules",
      "messageColor"
    ])
  },
  data: () => ({
    valid: true,
    show: false,
    email: "",
    password: ""
  }),
  methods: {
    submitForm(e) {
       e.preventDefault();
      if (this.$refs.form.validate()) {
        let { email, password } = this;
        this.customerLogin({ email, password }).then(response=>{
            if(!!response && !!response.token){
                this.$router.go({
                    path: "/products"
                });
            }
        });
      }
    },

    ...mapActions("customers", ["customerLogin"])
  },
  watch: {

  }
};
</script>

<style>
</style>
