<template>
  <v-row justify="center" align="center" class="mt-5">
    <v-col cols="12" lg="4" md="8" xl="4">
      <v-form ref="form" :valid="valid" @submit="submitForm($event)">
        <v-card outlined tile>
          <v-card-title class="justify-center headline">Create An Customer Account</v-card-title>
          <v-divider />
          <v-card-text>
            <v-text-field
              :rules="firstnameRules"
              v-model="firstname"
              required
              outlined
              label="First Name"
              :error="!!errors.firstname"
              :error-messages="errors.firstname"
            />
            <v-text-field
              :rules="lastnameRules"
              v-model="lastname"
              required
              outlined
              label="Last Name"
              :error="!!errors.lastname"
              :error-messages="errors.lastname"
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
              :rules="mobileRules"
              v-model="mobile"
              required
              outlined
              label="Mobile number"
              :error="!!errors.mobile"
              :error-messages="errors.mobile"
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
      "firstnameRules",
      "lastnameRules",
      "emailRules",
      "mobileRules",
      "passwordRules",
      "isAuthenticated","user","messageColor"
    ])
  },
  data: () => ({
    valid: true,
    show: false,
    firstname:"",
    lastname:"",
    email:"",
    mobile: "",
    password: ""
  }),
  methods: {
    submitForm(e) {
      e.preventDefault();

      if (this.$refs.form.validate()) {
        const { firstname,lastname,email,mobile, password } = this;
        this.customerCreate({ firstname,lastname,email,mobile, password }).then(response=>{
            if(!!response && !!response.token){
                this.$router.go({
                    path: "/products"
                });
            }
        });;
      }
    },
    ...mapActions("customers", ["customerCreate"])
  },
  watch: {}
};
</script>

<style>
</style>

