<template>
  <div>
    <form>
      <div>
        <label for="category">Category</label>
        <input type="text" id="category" v-model="data.category" />
      </div>
      <button @click="onSearch" type="button">Search</button>
    </form>
  </div>
</template>

<script>
export default {
  data: () => ({
    data: {},
  }),
  methods: {
    onSearch() {
      this.$emit("product-search", this.data);
    },
  },
};
</script>

<style scoped>
form {
  display: flex;
  justify-content: center;
}

button {
  margin-left: 10px;
}
input {
  padding: 5px;
  margin-left: 5px;
}
</style>