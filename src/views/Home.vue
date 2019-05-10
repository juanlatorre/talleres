<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png">
    <div class="hello">
      <h1>wena</h1>
      <p>
        For a guide and recipes on how to configure / customize this project,
        <br>check out the
        <a
          href="https://cli.vuejs.org"
          target="_blank"
          rel="noopener"
        >vue-cli documentation</a>.
      </p>

      <button @click="logout" v-if="user !== null">Logout</button>

      <pre>
        {{ user.email }}
      </pre>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import firebase from "@/helpers/firebaseInit.js";

export default {
  methods: {
    logout() {
      firebase
        .auth()
        .signOut()
        .then(_ => this.$router.replace("login"));
    }
  },
  computed: {
    ...mapState(["user"])
  }
};
</script>

<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>

