import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store.js";
import Buefy from "buefy";
import "buefy/dist/buefy.css";
import "@fortawesome/fontawesome-free/css/all.css";

Vue.config.productionTip = false;
Vue.use(Buefy);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
