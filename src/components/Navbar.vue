<template>
  <nav class="navbar is-light" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <a class="navbar-item" href="https://bulma.io">
        <h2 class="title is-4 has-text-primary">Talleres</h2>
      </a>

      <a
        role="button"
        class="navbar-burger"
        :class="{ 'is-active': showMobileMenu }"
        aria-label="menu"
        aria-expanded="false"
        @click="showMobileMenu = !showMobileMenu"
      >
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div class="navbar-menu" :class="{ 'is-active': showMobileMenu }" id="navMenu">
      <div class="navbar-start">
        <!-- Searchbox here -->
      </div>

      <div class="navbar-end">
        <div class="navbar-item">
          <b-dropdown aria-role="list" class="is-bottom-left">
            <a class="navbar-item is-primary button" slot="trigger" role="button">
              <span>Menú</span>
              <b-icon icon="caret-down"></b-icon>
            </a>

            <b-dropdown-item @click="nuevoTaller" aria-role="listitem">Crear Taller</b-dropdown-item>
            <b-dropdown-item @click="logout" aria-role="listitem">Cerrar Sesión</b-dropdown-item>
          </b-dropdown>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      showMobileMenu: false
    };
  },
  methods: {
    nuevoTaller() {
      this.$router.push("/taller/nuevo/0");
    },
    ...mapActions({
      logout: "logout"
    })
  }
};
</script>

<style>
</style>
