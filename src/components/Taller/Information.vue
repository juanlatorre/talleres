<template>
  <div>
    <h1 class="title is-2">{{nombre}}</h1>
    <p>{{fechaParsed}}</p>
    <p>{{descripcion}}</p>
    <img :src="imagen">
  </div>
</template>

<script>
export default {
  props: {
    nombre: {
      type: String,
      required: true
    },
    fecha: {
      type: Object,
      required: true
    },
    descripcion: {
      type: String,
      required: true
    },
    imagen: {
      type: String,
      required: true
    }
  },
  computed: {
    fechaParsed() {
      let dt = new Date(this.fecha.seconds * 1000);
      let mes = dt.getMonth() + 1;
      let dia = dt.getDate();
      let ano = dt.getFullYear();
      let horas = dt.getHours();
      let minutos = ("0" + dt.getMinutes()).slice(-2);
      return dia + "/" + mes + "/" + ano + " a las " + horas + ":" + minutos;
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
