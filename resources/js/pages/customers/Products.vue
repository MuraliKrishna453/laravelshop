<template>
  <v-card flat :loading="productLoading">
    <v-card-title>
      Products
    </v-card-title>
    <v-divider />
    <v-card-text>
         <v-row v-if="!!allproducts">
            <v-col
            cols="12"
            xl="3"
            lg="3"
            md="4"
            v-for="(product, key) in allproducts.data"
            :key="key"
            >
            <v-card
                class="mx-auto"
                max-width="400"
            >
                <v-img
                class="white--text align-end"
                height="200px"
                :src="product.image"
                >
                <v-card-title>{{product.name}}</v-card-title>
                </v-img>

                <v-card-subtitle class="pb-0">Price: {{product.price}}</v-card-subtitle>
                <v-card-subtitle class="pb-0">Discount: {{product.discount}}</v-card-subtitle>

                <v-card-text class="text--primary">
                <div>{{product.description}}</div>
                </v-card-text>
            </v-card>
            </v-col>
         </v-row>

      <div class="text-center" v-if="!!allproducts && allproducts.total>options.itemsPerPage">
        <v-pagination v-model="options.page" :length="allproducts.last_page"   :total-visible="7" circle></v-pagination>
      </div>
    </v-card-text>
    <v-divider />
    <v-card-actions class="pa-3"></v-card-actions>
  </v-card>
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
  data: () => ({
    search:"",
    options: {
      page: 1,
      itemsPerPage: 5
    },
    headers: [
      {
        text: "Image",
        align: "start",
        sortable: false,
        value: "image"
      },
      { text: "Name", value: "name" },
      { text: "Description", value: "description" },
      { text: "Price", value: "price" },
      { text: "Discount", value: "discount" },
      { text: "Action", value: "action" }
    ]
  }),
  computed: {
    ...mapState("global", ["loading", "errors"]),
    ...mapState("products", ["allproducts","productLoading"])
  },
created(){
        this.getData()
    },
  methods: {
    getData(){
       let urlParams = [];
        Object.keys(this.options).forEach(key => {
          urlParams.push(key + "=" + this.options[key]);
        });
        urlParams.push("search="+this.search)
        urlParams = urlParams.join("&");
        this.getProducts(urlParams);
    },
    ...mapActions("products", ["getProducts"])
  },

  mounted() {},
  watch: {
    options: {
      handler() {
       this.getData()
      },
      deep: true
    }
  }
};
</script>

<style></style>

