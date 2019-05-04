import Vue from "vue";
import Router from "vue-router";
import * as firebase from "firebase";

Vue.use(Router);

let router = new Router({
  mode: "history",
  routes: [
    {
      path: "/login",
      name: "login",
      component: () =>
        import(/* webpackChunkName: "login" */ "./views/Login.vue")
    },
    {
      path: "/talleres",
      name: "talleres",
      component: () =>
        import(/* webpackChunkName: "talleres" */ "./views/Talleres.vue"),
      meta: {
        requiresAuth: true
      }
    }
  ]
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    firebase.auth().onAuthStateChanged(user => {
      if (!user) {
        next({
          path: "/login"
        });
      } else {
        next();
      }
    });
  } else {
    next();
  }
});

export default router;
