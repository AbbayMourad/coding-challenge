<template>
  <div>
    <h1>Products List</h1>
    <div>
      <products-list :products="products" />
      <simple-paginator :options="paginatorOptions" />
    </div>
  </div>
</template>

<script>
import ProductsList from "../components/ProductsList.vue";
import SimplePaginator from '../components/SimplePaginator.vue';
export default {
  components: { ProductsList, SimplePaginator },
  data: () => ({
    products: [],
    links: [],
  }),
  computed: {
    paginatorOptions() {
      const { links } = this
      const options = []
      for (const link in links) {
        const option = { label: link, disabled: !links[link] }
        options.push(option)
      }
      return options
    },
  },
  created() {
    this.getProducts()
  },
  methods: {
    async getProducts() {
      try {
        const { data: body } = await this.$axios.get("/products")
        this.products = body.data
        this.links = body.links
        console.log("--get-products-succ", body)
      } catch (err) {
        console.log("--get-products-err", err.response)
      }
    },
  },
};
</script>

<style>
</style>