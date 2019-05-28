<template>
  <div class="columns is-mobile">
    <div class="column is-6-mobile is-offset-3-mobile is-4-tablet is-offset-4-tablet">
      <div class="card">
        <div class="card-content">
          <div class="content">
            <p class="title is-4">Acceder</p>
            <p class="subtitle is-5">Ir a Talleres</p>
            <section>
              <b-field>
                <b-input v-model="email" type="email" icon="envelope" placeholder="Email"></b-input>
              </b-field>
              <b-field>
                <b-input
                  v-model="password"
                  type="password"
                  icon="lock"
                  placeholder="Clave"
                  password-reveal
                ></b-input>
              </b-field>
              <b-field class="has-text-right">
                <b-button @click.native="login" type="is-primary">Acceder</b-button>
              </b-field>
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: ""
    };
  },
  methods: {
    login() {
      this.$store.dispatch("login", {
        email: this.email,
        password: this.password
      });
    }
  }
};
</script>

<style scoped>
.columns {
  margin-top: 6em;
}
</style>
