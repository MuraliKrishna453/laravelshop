<template>
  <v-snackbar v-model="csnackbar" :color="messageColor" :right="true" :bottom="true" :vertical="true">
    {{ message }}
    <v-btn dark text @click="closeBar">Close</v-btn>
  </v-snackbar>
</template>
<script>
import { mapState, mapMutations } from "vuex";
export default {
  data: () => ({
    timout: 6000,
    csnackbar: false
  }),
  computed: {
    ...mapState("global", ["message", "messageColor"])
  },
  // created() {
  //     this.csnackbar=this.snackbar;

  // },
  methods: {
    ...mapMutations("global", ["setSuccess"]),
    closeBar() {
      this.csnackbar = false;
      this.setSuccess({ msg: "", color: "" });
    }
  },
  watch: {
    message() {
      if (this.message) {
        this.csnackbar = true;
      }
    },
    csnackbar() {
      if (!this.csnackbar) {
        this.closeBar();
      }
    }
  }
};
</script>