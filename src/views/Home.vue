<template>
  <div>
    <button @click="logout" v-if="user !== false">Logout</button>

    <pre>
      {{ user.email }}
    </pre>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  methods: {
    ...mapActions({
      logout: "logout"
    })
  },
  computed: {
    ...mapGetters(["user"])
  }
};
</script>

<style scoped>
</style>

