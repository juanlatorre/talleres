import Vue from "vue";
import Router from "vue-router";
import { auth } from "@/helpers/firebaseInit.js";
import store from "./store.js";

Vue.use(Router);

const router = new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [
    {
      path: "/",
      name: "home",
      component: () =>
        import(/* webpackChunkName: "home" */ "./views/Home.vue"),
      meta: {
        requireLogin: true
      }
    },
    {
      path: "/login",
      name: "login",
      component: () =>
        import(/* webpackChunkName: "login" */ "./views/Login.vue")
    },
    {
      path: "/taller/:accion/:id",
      component: () =>
        import(/* webpackChunkName: "taller" */ "./views/Taller.vue"),
      meta: {
        requireLogin: true
      }
    }
  ]
});

router.beforeEach((to, from, next) => {
  auth.onAuthStateChanged(user => {
    store.dispatch("setUser", user || false);
    let permiso = to.matched.some(record => record.meta.requireLogin);

    if (permiso && !user) {
      router.replace("login");
    } else if (!permiso && user) {
      router.replace("/");
    } else {
      next();
    }
  });
});

export default router;
