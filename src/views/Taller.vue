<template>
  <div v-if="!isEmpty(parentData)">
    <Header/>
    <Container v-if="this.accion == 'ver'">
      <Information :parentData="parentData"/>
      <hr>
      <Formulario :id="parentData.id"/>
    </Container>
    <Container v-else-if="this.accion == 'editar'">
      <Editar :parentData="parentData" @communication="handleEditarBack"/>
    </Container>
    <Container v-else>
      <Nuevo @communication="handleNuevoBack"/>
    </Container>
  </div>
  <Loader v-else/>
</template>

<script>
import Loader from "@/components/Loader.vue";
import Header from "@/components/Taller/Header.vue";
import Container from "@/components/Taller/Container.vue";
import Information from "@/components/Taller/Information.vue";
import Formulario from "@/components/Taller/Formulario.vue";
import Editar from "@/components/Taller/Editar.vue";
import Nuevo from "@/components/Taller/Nuevo.vue";
import { db } from "@/helpers/firebaseInit.js";

export default {
  data() {
    return {
      accion: this.$route.params.accion,
      parentData: {}
    };
  },
  methods: {
    isEmpty(obj) {
      for (var key in obj) {
        if (obj.hasOwnProperty(key)) return false;
      }
      return true;
    },
    handleEditarBack(event) {
      db.collection("talleres")
        .doc(this.parentData.id)
        .update(event)
        .then(() => {
          this.$snackbar.open({
            duration: 5000,
            message: "El taller fue actualizado exitosamente.",
            type: "is-success",
            position: "is-bottom-right",
            actionText: "Ok",
            queue: false
          });
        }) // eslint-disable-next-line
        .catch(error => {
          this.$snackbar.open({
            duration: 5000,
            message: "Hubo un error al actualizar el taller.",
            type: "is-danger",
            position: "is-bottom-right",
            actionText: "Ok",
            queue: false
          });
        });
    },
    handleNuevoBack(event) {
      if (
        event.descripcion !== "" &&
        event.imagen !== "" &&
        event.nombre !== ""
      ) {
        db.collection("talleres")
          .doc(this.parentData.id)
          .update(event)
          .then(() => {
            this.$snackbar.open({
              duration: 5000,
              message: "El taller fue actualizado exitosamente.",
              type: "is-success",
              position: "is-bottom-right",
              actionText: "Ok",
              queue: false
            });
          }) // eslint-disable-next-line
          .catch(error => {
            this.$snackbar.open({
              duration: 5000,
              message: "Hubo un error al actualizar el taller.",
              type: "is-danger",
              position: "is-bottom-right",
              actionText: "Ok",
              queue: false
            });
          });
      } else {
        this.$snackbar.open({
          duration: 5000,
          message: "Por favor llena todos los campos.",
          type: "is-warning",
          position: "is-bottom-right",
          actionText: "Ok",
          queue: false
        });
      }
    }
  },
  mounted: function() {
    if (this.$route.params.accion == "nuevo") {
      console.log("nuevo");
    } else {
      db.collection("talleres")
        .doc(this.$route.params.id)
        .get()
        .then(taller => {
          if (taller.exists) {
            this.parentData = {
              id: taller.id,
              nombre: taller.data().nombre,
              fecha: taller.data().fecha,
              hora: taller.data().hora,
              descripcion: taller.data().descripcion,
              imagen: taller.data().imagen,
              disponible: taller.data().disponible,
              cupos: taller.data().cupos
            };
          } else {
            this.$router.replace("/");
          }
        });
    }
  },
  components: {
    Header,
    Container,
    Information,
    Loader,
    Formulario,
    Editar,
    Nuevo
  },
  beforeCreate() {
    if (
      this.$route.params.accion !== "ver" &&
      this.$route.params.accion !== "editar" &&
      this.$route.params.accion !== "nuevo"
    ) {
      this.$router.replace("/");
    }
  }
};
</script>