<template>
  <div>
    <h1 class="title is-2">{{parentData.nombre}}</h1>
    <p>{{fecha}}</p>
    <p>{{parentData.descripcion}}</p>
    <img :src="parentData.imagen">
  </div>
</template>

<script>
export default {
  props: {
    parentData: {
      type: Object,
      required: true
    }
  },
  computed: {
    fecha() {
      let dt = new Date(this.parentData.fecha.seconds * 1000);
      return dt.toLocaleDateString("es-CL", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "2-digit",
        hour: "2-digit",
        minute: "2-digit"
      });
    }
  }
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
