<template>
  <div class="simple-paginator">
    <button
      v-for="(option, i) in options"
      :key="i"
      :disabled="!!option.disabled"
      @click="onClick(option)"
    >
      {{ option.label }}
    </button>
  </div>
</template>

<script>
export default {
  props: {
    // [..., { label: String, disabled: Boolean, ... }, ...]
    options: { type: Array, default: () => [] },
  },
  methods: {
    onClick(option) {
      this.$emit('pagination', option)
    }
  }
};
</script>

<style scoped>
.simple-paginator {
  display: flex;
  justify-content: center;
}
.simple-paginator > * {
  margin-right: 20px;
}
</style>