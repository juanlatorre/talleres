<template>
  <div class="columns">
    <div class="column is-4 is-offset-4">
      <div class="card">
        <div class="card-content">
          <div class="content">
            <p class="title is-4">Acceder</p>
            <p class="subtitle is-5">Ir a Talleres</p>
            <form @submit.prevent="login">
              <div class="field">
                <p class="control has-icons-left has-icons-right">
                  <input class="input" type="email" v-model="email" placeholder="Email">
                  <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                  </span>
                </p>
              </div>
              <div class="field">
                <p class="control has-icons-left">
                  <input class="input" type="password" v-model="password" placeholder="Contraseña">
                  <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                </p>
              </div>
              <div class="field">
                <p class="control has-text-right">
                  <button class="button is-info">Siguiente</button>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.columns {
  margin-top: 5em;
}
</style>

<script>
import database from "@/services/database";

export default {
  name: "login",
  data() {
    return {
      email: "",
      password: "",
      error: ""
    };
  },
  methods: {
    async login() {
      let result = await database.login(this.email, this.password);
      result.message
        ? (this.error = result.message)
        : console.log("Usuario inició sesión");
    }
  }
};
</script>

