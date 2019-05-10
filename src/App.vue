<template>
  <div id="app">
    <navbar v-if="user !== false"/>
    <router-view/>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Navbar from "@/components/Navbar";
export default {
  components: {
    Navbar
  },
  computed: {
    ...mapGetters(["user"])
  }
};
</script>
