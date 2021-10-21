<template>
  <div id="products-list">
    <product :product="product" v-for="product in products" :key="product.id" />
  </div>
</template>

<script>
import Product from './Product.vue'
export default {
  components: { Product },
  props: {
    products: { type: Array, default: () => [] }
  }
}
</script>

<style scoped>
#products-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr) );
  justify-items: center;
  row-gap: 50px;
  padding-top: 20px;
}
</style>