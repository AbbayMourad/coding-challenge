<template>
  <div>
    <h2>Create a Product</h2>
    <product-form
      @product-create="createProduct"
      :categories="categories"
    ></product-form>
    <p :class="status.class" id="status">{{ status.text }}</p>
  </div>
</template>

<script>
import ProductForm from "../components/ProductForm.vue";

export default {
  components: {
    ProductForm,
  },
  data: () => ({
    categories: [],
    status: { text: "", class: "" },
    // to track create product status
    productStatus: { text: undefined, errMess: undefined },
  }),
  watch: {
    productStatus: {
      handler(_, value) {
        console.log("--watcher", value);
        const { text } = value;
        if (text == "error") {
          this.status.text = value.errMess;
          this.status.class = "cl-red";
          return;
        }
        this.status.class = "cl-green";
        if (text == "creating") this.status.text = "creating product...";
        else if (text == "created") this.status.text = "product created";
      },
      deep: true,
    },
  },
  created() {
    this.getCategories();
  },
  methods: {
    getCategories() {
      this.$axios.get("/categories").then((res) => {
        const body = res.data;
        this.categories = body.data;
      });
    },
    async createProduct(product) {
      const productData = { ...product }
      const { categories } = productData
      delete productData.categories
      productData.image = await this.toBase64(productData.image)
      this.productStatus.text = "creating"
      try {
        const body = { product: productData, categories }
        console.log("--body", body)
        const response = await this.$axios.post("/products", body)
        this.productStatus.text = "created"
        console.log("--create-prod-succ", response)
      } catch (err) {
        const { response } = err;
        this.productStatus.text = "error"
        this.productStatus.errMess = response
          ? response.data.message
          : "unable to reach the server"
        console.log("--create-prod-err", response)
      }
    },
    toBase64(file) {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onloadend = () => resolve(reader.result);
      });
    },
  },
};
</script>

<style scoped>
.cl-red {
  color: red;
}
.cl-green {
  color: green;
}
#status {
  text-align: center;
  margin-top: 20px;
}
</style>