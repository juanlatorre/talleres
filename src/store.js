import Vue from "vue";
import Vuex from "vuex";
import firebase from "@/helpers/firebaseInit.js";
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
      firebase
        .auth()
        .signInWithEmailAndPassword(credentials.email, credentials.password)
        .then(response => {
          state.user = response.user;
        })
        .catch(error => {
          console.error(error.message);
        });
    },
    logout() {
      firebase
        .auth()
        .signOut() // eslint-disable-next-line
        .then(_ => router.replace("login"));
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
