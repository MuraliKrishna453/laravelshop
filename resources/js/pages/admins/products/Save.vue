<template>
  <v-row class="mt-4" justify="center" align="center" >
    <v-col  cols="12"  lg="4" md="4" xl="4">

      <v-form ref="form" :valid="valid" @submit="save($event)">
        <v-card outlined tile :loading="productLoading">
          <v-card-title>{{ id ? "Edit" : "Create" }} Product</v-card-title>
          <v-divider />
          <v-card-text>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  :rules="nameRules"
                  v-model="name"
                  required
                  outlined
                  dense
                  class="mb-1"
                  label="Name"
                  :error="!!errors.name"
                  :error-messages="errors.name"
                />
              </v-col>
              <v-col cols="12">
                <v-textarea
                  :rules="descriptionRules"
                  v-model="description"
                  required
                  outlined
                  dense
                  class="mb-1"
                  label="Description"
                  :error="!!errors.description"
                  :error-messages="errors.description"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  :rules="priceRules"
                  v-model="price"
                  required
                  outlined
                  dense
                  type="number"
                  class="mb-1"
                  label="Price"
                  min="1"
                  :error="!!errors.price"
                  :error-messages="errors.price"
                />
              </v-col>
              <v-col cols="12">
            <v-text-field
              :rules="discount ? discountRules:[]"
              v-model="discount"
              outlined
              dense
              min="0"
              max="99"
              type="number"
              class="mb-1"
              label="Discount"
              :error="!!errors.discount"
              :error-messages="errors.discount"
            />
              </v-col>
        <v-col cols="12" lg="12">
            <v-file-input
              v-model="image"
              :rules="!oldImage ? imageRules: []"
              required
              outlined
              dense
              type="file"
              class="mb-1"
              label="Image"
              accept=".jpeg, .jpg, .png"
              @change="onImageChange"
              ref="imageRef"
              input
              :error="!!errors.image"
              :error-messages="errors.image"
            />
             <v-img v-if="oldImage" :src="oldImage"
            aspect-ratio="1.4"
            contain />
            </v-col>

          </v-row>
          </v-card-text>
          <v-divider />
          <v-card-actions class="pa-3">
            <v-btn
              :loading="loading"
              :disabled="loading"
              color="primary"
              type="submit"
            >{{ id ? "Update" : "Create" }}</v-btn>
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
      id(){
          return this.$route.params.id;
      },
    ...mapState("products", ['productLoading']),
    ...mapState("global", [
      "loading",
      "errors",
      "nameRules",
      "descriptionRules",
      "priceRules",
      "discountRules",
      "imageRules",
      "isAuthenticated",
      "messageColor"
    ])
  },
  data: () => ({
    valid: true,
    show: false,
    name: "",
    price: "",
    description: "",
    discount: "",
    image: null,
    oldImage:null,
    imageChange: false,
  }),
  mounted() {
      if(!!this.id){
        this.getProduct(this.id).then(response=>{
        let data = response.data;
        this.name = data.name;
        this.description = data.description;
        this.price = data.price;
        this.discount = data.discount;
        this.oldImage = data.image;
      });

      }
  },
  methods: {
    onImageChange(files) {
      this.imageChange = true;
      this.image = files;
    },
    save(e) {
      e.preventDefault();

      if (this.$refs.form.validate()) {
        const {
          id,
          name,
          price,
          description,
          discount,
          image,
          imageChange
        } = this;
        let formData = new FormData();
        formData.append("name", name);
        formData.append("description", description);
        formData.append("price", price);
        formData.append("discount", discount);
        formData.append("image", image);
        if(!!id){
             formData.append('_method', 'PUT');
             formData.append("imageChange", imageChange);
             this.productUpdate({formData,id});
        }else{
            this.productCreate(formData);
        }

      }
    },
    ...mapActions("products", ["productCreate", "productUpdate","getProduct"]),
    ...mapActions("categories", ["getCategories"]),

  },
  watch: {
    loading() {
      if (this.errors.length == 0 && !this.loading  &&
        this.messageColor == "success") {
        this.$router.push("/admin/products");
      }
    }
  }
};
</script>

<style></style>

