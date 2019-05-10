<template>
  <div>
    <form @submit.prevent="login">
      <input v-model="email" type="email" placeholder="Correo">
      <input v-model="pass" type="password" placeholder="Contraseña">
      <input type="submit" value="Acceder">
    </form>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      email: "",
      pass: ""
    };
  },
  methods: {
    login() {
      this.$store.commit("login", { email: this.email, pass: this.pass });
    }
  },
  computed: {
    ...mapState(["user"])
  }
};
</script>

<style scoped>
div {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

form > * {
  display: block;
}
</style>
