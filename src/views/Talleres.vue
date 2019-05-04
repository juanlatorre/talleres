<template>
  <div>
    <p>Lista de Talleres</p>
    <a @click="logout">Cerrar sesión</a>
  </div>
</template>

<script>
import database from "@/services/database";

export default {
  name: "talleres",
  methods: {
    async logout() {
      await database.logout();
    }
  }
};
</script>