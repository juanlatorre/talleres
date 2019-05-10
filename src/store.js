import Vue from "vue";
import Vuex from "vuex";
import firebase from "@/helpers/firebaseInit.js";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    user: null
  },
  mutations: {
    setUser(state, value) {
      state.user = value;
    },
    login(state, payload) {
      firebase
        .auth()
        .signInWithEmailAndPassword(payload.email, payload.pass)
        .then(response => {
          state.user = response.user;
        })
        .catch(error => {
          console.error(error.message);
        });
    }
  }
});
