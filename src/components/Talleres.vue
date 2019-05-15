<template>
  <div class="columns is-mobile" v-if="talleres.length > 0">
    <div class="column is-6-mobile is-3-tablet" v-for="(taller, idx) in talleres" :key="idx">
      <div class="card">
        <div class="card-content" @click="abrirTaller(taller.id)">
          <p class="title is-5">{{taller.nombre}}</p>
          <p class="subtitle">{{fecha(taller.fecha.seconds)}}</p>
        </div>
        <footer class="card-footer">
          <p class="card-footer-item">
            <span>
              <a href="javascript:void(0);" @click="editarTaller(taller.id)">
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
            let allDocData = doc.data();
            allDocData.id = doc.id;
            this.talleres.push(allDocData);
          });
        });
    },
    abrirTaller(id) {
      this.$router.push("/taller/ver/" + id);
    },
    editarTaller(id) {
      this.$router.push("/taller/editar/" + id);
    },
    eliminarTaller(id) {
      db.collection("talleres")
        .doc(id)
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
    },
    fecha(date) {
      let dt = new Date(date * 1000);
      return dt.toLocaleDateString("es-CL", {
        year: "numeric",
        month: "short",
        day: "2-digit"
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
