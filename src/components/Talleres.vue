<template>
  <div class="columns is-mobile">
    <div class="column is-6-mobile is-3-tablet" v-for="(taller, idx) in talleres" :key="idx">
      <div class="card">
        <div class="card-content" @click="abrirTaller(taller.id)">
          <p class="title is-5">{{taller.nombre}}</p>
          <p class="subtitle">{{taller.fecha}}</p>
        </div>
        <footer class="card-footer">
          <p class="card-footer-item">
            <span>
              <a href="#">
                <i class="fas fa-pencil-alt"></i> Editar
              </a>
            </span>
          </p>
          <p class="card-footer-item">
            <span>
              <a href="#">
                <i class="fas fa-trash"></i> Eliminar
              </a>
            </span>
          </p>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
import { db } from "@/helpers/firebaseInit.js";

export default {
  data() {
    return {
      talleres: []
    };
  },
  mounted: function() {
    db.collection("talleres")
      .get()
      .then(querySnapshot => {
        querySnapshot.forEach(doc => {
          this.talleres.push(doc.data());
        });
      });
  },
  methods: {
    abrirTaller(id) {
      this.$router.push("/taller/" + id);
    }
  }
};
</script>

<style scoped>
.card {
  cursor: pointer;
}
</style>
