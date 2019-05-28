import Vue from "vue";
import Vuex from "vuex";
import { auth } from "@/helpers/firebaseInit.js";
import router from "@/router.js";

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    user: false
  },
  getters: {
    user(state) {
      return state.user;
    }
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
    login(state, credentials) {
      auth
        .signInWithEmailAndPassword(credentials.email, credentials.password)
        .then(response => {
          state.user = response.user;
        }) //eslint-disable-next-line
        .catch(error => {});
    },
    logout() {
      // eslint-disable-next-line
      auth.signOut().then(_ => router.replace("login"));
    }
  },
  actions: {
    setUser({ commit }, user) {
      commit("setUser", user);
    },
    login({ commit }, credentials) {
      commit("login", credentials);
    },
    logout({ commit }) {
      commit("logout");
    }
  }
});

export default store;
