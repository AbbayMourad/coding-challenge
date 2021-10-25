<template>
  <div>
    <h1>Products List</h1>
     <!-- form -->
    <div id="search-form">
      <product-search-form @product-search="onSearch" />
    </div>
    <div v-if="isProductsExists">
      <div class="sort-by">
        <sort-by :sortOptions="sortOptions" @sort="onSort" />
      </div>
      <products-list :products="products" />
    </div>
    <p v-else class="not-found-mess">No Product Found !</p>
    <div class="paginator" v-show="isProductsExists">
      <simple-paginator :options="paginatorOptions" @pagination="onPaginate" />
    </div>
  </div>
</template>

<script>
import ProductsList from "../components/ProductsList.vue";
import SimplePaginator from "../components/SimplePaginator.vue";
import ProductSearchForm from "../components/ProductSearchForm.vue";
import SortBy from "../components/SortBy.vue";
export default {
  components: { ProductsList, SimplePaginator, ProductSearchForm, SortBy },
  data: () => ({
    products: [],
    links: {},
    params: { page: 1, category: undefined, sort: {}},
    sortOptions: [
      { text: "Price: Low to High", value: { price: "asc" } },
      { text: "Price: High to Low", value: { price: "desc" } },
      { text: "Name: A-Z", value: { name: "asc" } },
      { text: "Name: Z-A", value: { name: "desc" } },
    ],
  }),
  computed: {
    isProductsExists() {
      return this.products.length > 0;
    },
    paginatorOptions() {
      const { links } = this;
      const options = [];
      for (const link in links) {
        const option = { label: link, disabled: !links[link] };
        options.push(option);
      }
      const optionsOrder = { first: 1, prev: 2, next: 3, last: 4 };
      options.sort((a, b) => optionsOrder[a.label] - optionsOrder[b.label]);
      return options;
    },
  },
  watch: {
    params: {
      handler() {
        this.getProducts(this.params);
      },
      deep: true,
    },
  },
  created() {
    this.getProducts({ page: 1 });
  },
  methods: {
    async getProducts(params = {}) {
      try {
        const { data: body } = await this.$axios.get("/products", { params });
        this.products = body.data;
        this.links = body.links;
        console.log("--get-products-succ", body);
      } catch (err) {
        console.log("--get-products-err", err.response);
      }
    },
    onPaginate({ label, disabled }) {
      if (disabled) return;
      const page = this.links[label].match(/page=(\d+)/)[1];
      this.params.page = page;
    },
    onSearch(searchData) {
      console.log("--search-data", searchData);
      this.params.category = searchData.category;
    },
    onSort(selectedSort) {
      console.log("--selected-sort", selectedSort);
      this.params.sort = selectedSort;
    },
  },
};
</script>

<style scoped>
.paginator {
  margin-top: 20px;
}
.not-found-mess {
  margin-top: 50px;
  font-size: 1.5em;
}
.sort-by {
  display: flex;
  justify-content: end;
  margin-right: 30px;
}
#search-form {
  display: flex;
  justify-content: start;
}
</style>