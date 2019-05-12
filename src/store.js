import Vue from "vue";
import Vuex from "vuex";
import firebase, { auth, db } from "@/helpers/firebaseInit.js";
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
        })
        .catch(error => {
          console.error(error.message);
        });
    },
    logout() {
      // eslint-disable-next-line
      auth.signOut().then(_ => router.replace("login"));
    },
    inscribirCliente(state, datos) {
      db.collection("talleres")
        .where("id", "==", Number(datos.id))
        .get()
        .then(querySnapshot => {
          querySnapshot.forEach(doc => {
            db.collection("talleres")
              .doc(doc.id)
              .update({
                inscritos: firebase.firestore.FieldValue.arrayUnion({
                  nombre: datos.nombre,
                  correo: datos.correo,
                  telefono: datos.telefono,
                  pagado: false
                })
              });
          });
        });
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
    },
    inscribirCliente({ commit }, datos) {
      // eslint-disable-next-line
      return new Promise((resolve, reject) => {
        commit("inscribirCliente", datos);
        resolve();
      });
    }
  }
});

export default store;
