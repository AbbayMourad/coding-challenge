<template>
  <ul class="nav-bar">
    <li>
      <router-link :to="{ name: 'products' }">Products List</router-link>
    </li>
    <li>
      <router-link :to="{ name: 'products-create' }"
        >Create Product</router-link
      >
    </li>
  </ul>
</template>

<script>
export default {};
</script>

<style>
.nav-bar {
  display: flex;
  justify-content: center;
  padding: 20px;
}
.nav-bar > li {
  margin-right: 20px;
  list-style: none;
}
</style>