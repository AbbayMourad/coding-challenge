<template>
  <div class="product">
    <figure>
      <img :src="product.image" :alt="`${product.name} image`" />
    </figure>
    <p>{{product.name}}</p>
    <p>{{product.price}}</p>
  </div>
</template>

<script>
export default {
  props: {
    product: { type: Object, default: () => {} }
  }
}
</script>

<style scoped>
img {
  max-height: 100%;
  max-width: 100%;
}
figure {
  height: 150px;
  width: 200px;
}
.product > p {
  margin-bottom: 10px;
  text-align: center;
}
.product {
  border: 1px solid black;
}
</style>