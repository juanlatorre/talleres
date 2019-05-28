<template>
  <div>
    <navbar/>
    <section class="container">
      <div class="header">
        <p class="title is-5">Listado de Talleres</p>
        <p class="title is-5 clickable is-underline">A/Z</p>
      </div>
      <div>
        <talleres/>
      </div>
    </section>
  </div>
</template>

<script>
import Talleres from "@/components/Talleres.vue";
import Navbar from "@/components/Navbar";

export default {
  components: {
    Navbar,
    Talleres
  }
};
</script>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  padding-top: 1em;
}
</style>

