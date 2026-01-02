import Vue from 'vue';
import ValuationEstimator from './components/ValuationEstimator.vue';
export function createApp(initialState = {}) {
  const app = new Vue({
    data() { return { initialState }; },
    render: h => h(ValuationEstimator, { props: { initialState } })
  });
  return { app };
}
