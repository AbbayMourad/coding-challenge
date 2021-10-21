<template>
  <div>
    <form class="form" ref="product-form">
      <label for="name">Product Name</label>
      <input
        type="text"
        required
        maxlength="50"
        id="name"
        v-model="product.name"
      />
      <p class="error">{{errors.name}}</p>

      <label for="description">Product Description</label>
      <textarea
        cols="50"
        rows="10"
        maxlength="255"
        id="description"
        v-model="product.description"
      ></textarea>
      <p class="error">{{errors.description}}</p>


      <label for="price">Product Price</label>
      <input type="number" min="0" required v-model="product.price" />
      <p class="error">{{errors.price}}</p>

      <!-- image -->
      <label for="image">Product Image</label>
      <input type="file" id="image" accept="image/*" @change="selectFile" />
      <p class="error">{{errors.image}}</p>

      <label for="categories">Product Categories</label>
      <div class="categories">
        <div class="checkboxes">
          <vs-checkbox
            v-model="product.categories"
            :vs-value="categorie.name"
            v-for="categorie in categories"
            :key="categorie.name"
          >
            {{ categorie.name }}
          </vs-checkbox>
        </div>
        <!-- new categories -->
        <div>
          <p>New Categories</p>
          <vs-chips color="rgb(145, 32, 159)" v-model="newCategories">
            <vs-chip
              :key="newCategorie"
              @click="remove(newCategorie)"
              v-for="newCategorie in newCategories"
              closable
              class="chip"
            >
              {{ newCategorie }}
            </vs-chip>
          </vs-chips>
        </div>
      </div>

      <button class="send-butn" type="button" @click="onClick">
        Create Product
      </button>
    </form>
  </div>
</template>

<script>
import { validateObj } from "../core/validation"
export default {
  props: {
    categories: { type: Array, required: true },
  },
  data: () => ({
    product: { categories: [], image: undefined },
    newCategories: [],
    productSchema: {
      name: { required: true, maxLength: 50 },
      description: { optional: true, maxLength: 255 },
      price: { required: true, number: true, min: 0 },
      image: { required: true }
    },
    errors: {}
  }),
  computed: {
    isProductValid() {
      return Object.keys(this.errors).length == 0
    },
    productData() {
      const data = {...this.product}
      data.categories = [...data.categories]
      data.categories.push(...this.newCategories)
      return data
    }
  },
  methods: {
    selectFile(e) {
      this.product.image = e.target.files[0]
    },
    remove(item) {
      this.newCategories.splice(this.newCategories.indexOf(item), 1);
    },
    onClick() {
      this.errors = validateObj({ obj: this.product, schema: this.productSchema })
      if (!this.isProductValid) return
      this.$emit('product-create', this.productData)
    }
  }
};
</script>

<style scoped>
.form {
  display: grid;
  grid-template-columns: 150px 1fr;
  row-gap: 20px;
  justify-content: start;
}
.send-butn {
  grid-column: 2;
}
input,
textarea {
  padding-top: 5px;
  padding-bottom: 5px;
  padding-left: 5px;
}
.error {
  grid-column: 2;
  color: red;
}
.checkboxes {
  /* display: flex;
  flex-wrap: wrap; */
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr) );
  justify-items: start;
}
.chip {
  font-size: 1em;
}
.categories {
  display: grid;
  row-gap: 10px;
}
</style>