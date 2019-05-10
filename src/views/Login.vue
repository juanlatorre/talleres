<template>
  <div class="columns is-mobile">
    <div class="column is-6-mobile is-offset-3-mobile is-4-tablet is-offset-4-tablet">
      <div class="card">
        <div class="card-content">
          <div class="content">
            <p class="title is-4">Acceder</p>
            <p class="subtitle is-5">Ir a Talleres</p>
            <form @submit.prevent="login">
              <b-field>
                <b-input
                  v-model="email"
                  type="email"
                  icon-pack="fas"
                  icon="envelope"
                  placeholder="Email"
                ></b-input>
              </b-field>
              <b-field>
                <b-input
                  v-model="password"
                  type="password"
                  icon-pack="fas"
                  icon="lock"
                  placeholder="Clave"
                ></b-input>
              </b-field>
              <b-field class="has-text-right">
                <b-button type="is-primary">Acceder</b-button>
              </b-field>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      email: "",
      password: ""
    };
  },
  methods: {
    login() {
      this.$store.commit("login", {
        email: this.email,
        password: this.password
      });
    }
  },
  computed: {
    ...mapState(["user"])
  }
};
</script>

<style scoped>
.columns {
  margin-top: 8em;
}
</style>
