<template>
  <div>
    <h1 class="title is-2">{{nombre}}</h1>
    <p>{{fecha}} | {{hora}}</p>
    <p>{{descripcion}}</p>
    <img :src="'data:image/png;base64,' + imagen">
  </div>
</template>

<script>
export default {
  props: ["nombre", "fecha", "hora", "descripcion", "imagen"]
};
</script>

<style scoped>
img {
  margin-top: 1em;
  width: 100%;
  height: 150px;
  object-fit: cover;
}
</style>
