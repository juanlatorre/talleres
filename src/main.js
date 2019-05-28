import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store.js";
import Buefy from "buefy";
import VeeValidate from "vee-validate";
import "buefy/dist/buefy.css";
import "@fortawesome/fontawesome-free/css/all.css";

Vue.config.productionTip = false;
Vue.use(Buefy, {
  defaultIconPack: "fas",
  defaultDayNames: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
  defaultMonthNames: [
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre"
  ],
  defaultFirstDayOfWeek: 1
});
Vue.use(VeeValidate, {
  events: ""
});

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
