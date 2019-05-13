<template>
  <div class="columns is-mobile" v-if="talleres.length > 0">
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
              <a href="javascript:void(0);" @click="eliminarTaller(taller.id)">
                <i class="fas fa-trash"></i> Eliminar
              </a>
            </span>
          </p>
        </footer>
      </div>
    </div>
  </div>
  <Loader v-else/>
</template>

<script>
import { db } from "@/helpers/firebaseInit.js";
import Loader from "@/components/Loader.vue";

export default {
  components: {
    Loader
  },
  data() {
    return {
      talleres: []
    };
  },
  mounted: function() {
    this.leerDatos();
  },
  methods: {
    leerDatos() {
      this.talleres = [];
      db.collection("talleres")
        .get()
        .then(querySnapshot => {
          querySnapshot.forEach(doc => {
            this.talleres.push(doc.data());
          });
        });
    },
    abrirTaller(id) {
      this.$router.push("/taller/" + id);
    },
    eliminarTaller(id) {
      db.collection("talleres")
        .where("id", "==", id)
        .get()
        .then(querySnapshot => {
          querySnapshot.forEach(doc => {
            db.collection("talleres")
              .doc(doc.id)
              .delete()
              .then(() => {
                this.$snackbar.open({
                  duration: 3000,
                  message: "El taller ha sido eliminado.",
                  type: "is-success",
                  position: "is-bottom-right",
                  actionText: "Ok",
                  queue: false
                });
                this.leerDatos();
              });
          });
        });
    }
  }
};
</script>

<style scoped>
.card {
  cursor: pointer;
}
</style>
