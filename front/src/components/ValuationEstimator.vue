<template>
  <section class="valuation">
    <form @submit.prevent="submit">
      <input v-model="form.brand" placeholder="Brand" required />
      <input v-model="form.category" placeholder="Category" required />
      <select v-model="form.condition">
        <option value="new">New</option>
        <option value="good">Good</option>
        <option value="fair">Fair</option>
      </select>
      <button :disabled="loading">Calcular</button>
    </form>
    <div v-if="loading">Calculando...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else-if="result">
      <p>Precio: {{ result.price }}</p>
      <ul>
        <li v-for="(adj, i) in result.adjustments" :key="i">
          {{ adj.rule }}: {{ adj.type }} {{ adj.value }}
        </li>
      </ul>
    </div>
  </section>
</template>

<script>
import axios from 'axios';
export default {
  props: { initialState: { type: Object, default: () => ({}) } },
  data() {
    return {
      form: {
        brand: this.initialState.brand || '',
        category: this.initialState.category || '',
        condition: this.initialState.condition || 'good'
      },
      loading: false,
      error: null,
      result: this.initialState.result || null
    };
  },
  methods: {
    async submit() {
      this.loading = true; this.error = null;
      try {
        const { data } = await axios.post('http://127.0.0.1:8000/api/v1/valuation/estimate', this.form);
        this.result = data;
      } catch (e) {
        this.error = e.response?.data?.message || 'Error';
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
.valuation { max-width: 320px; display: grid; gap: 8px; }
.error { color: red; }
</style>
