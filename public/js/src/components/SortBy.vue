<template>
  <div>
    <vs-select label="Sort By" v-model="selectedSort">
      <vs-select-item
        :key="index"
        :value="option.value"
        :text="option.text"
        v-for="(option, index) in sortOptions"
      />
    </vs-select>
  </div>
</template>

<script>
export default {
  props: {
    sortOptions: { type: Array, required: true }
  },
  data: () => ({
    selectedSort: undefined
  }),
  watch: {
    selectedSort() {
      this.$emit('sort', this.selectedSort)
    }
  }
};
</script>

<style>
</style>