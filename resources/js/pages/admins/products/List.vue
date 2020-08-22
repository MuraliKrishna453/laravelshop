<template>
  <v-card flat>
    <v-card-title>
      Products
      <v-spacer />
      <v-btn color="primary" to="/admin/products/save" depressed tile>New product</v-btn>

    </v-card-title>
    <v-divider />
    <v-card-text>
      <v-data-table
        show-select
        :loading="productLoading"
        loading-text="Please wait..."
        :headers="headers"
        :items="productLoading ? [] : allproducts.data"
        :server-items-length="allproducts.total"
        :options.sync="options"
        :search="search"
        class="elevation-0"
      >
        <template v-slot:item.image="{ item }">
          <img :src="item.image" width="50" height="50" />
        </template>
         <template v-slot:item.description="{ item }">
             <span
      class="d-inline-block text-truncate"
      style="max-width: 150px;"
    >
      {{item.description}}
    </span>
        </template>
        <template v-slot:item.action="{ item }">
          <v-btn small :to="'/admin/products/save/' + item.id">
          Edit
          </v-btn>
          <v-btn small @click="deleteProduct(item.id)" color="secondary">
          Delete
          </v-btn>
          <v-btn small
          @click="updateStatus(item.id)"
          :color="item.status=='enable' ? 'warning':'primary'">
          {{item.status=='enable' ? 'Disable':'Enable'}}
          </v-btn>


        </template>
      </v-data-table>
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
      itemsPerPage: 15
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
    deleteProduct(id){
        let formData = new FormData();
        formData.append('_method', 'DELETE');
        this.productDelete({formData,id});
    },
    updateStatus(id){
        let formData = new FormData();
        formData.append('_method', 'PATCH');
        this.productStatus({formData,id});

    },
    ...mapActions("products", ["getProducts","productDelete","productStatus"])
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

