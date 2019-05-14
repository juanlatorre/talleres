<template>
  <div v-if="!isEmpty(parentData)">
    <Header/>
    <Container v-if="this.accion == 'ver'">
      <Information
        :nombre="parentData.nombre"
        :fecha="parentData.fecha"
        :hora="parentData.hora"
        :descripcion="parentData.descripcion"
        :imagen="parentData.imagen"
      />
      <hr>
      <Formulario :id="parentData.id"/>
    </Container>
    <Container v-else>
      <Editar :parentData="parentData" @communication="handleDataBack"/>
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
    handleDataBack(event) {
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
            type: "is-warning",
            position: "is-bottom-right",
            actionText: "Ok",
            queue: false
          });
        });
    }
  },
  mounted: function() {
    db.collection("talleres")
      .where("id", "==", Number(this.$route.params.id))
      .get()
      .then(querySnapshot => {
        querySnapshot.forEach(doc => {
          this.parentData = {
            id: doc.id,
            nombre: doc.data().nombre,
            fecha: doc.data().fecha,
            hora: doc.data().hora,
            descripcion: doc.data().descripcion,
            imagen: doc.data().imagen,
            disponible: doc.data().disponible,
            cupos: doc.data().cupos
          };
        });
      });
  },
  components: {
    Header,
    Container,
    Information,
    Loader,
    Formulario,
    Editar
  },
  beforeCreate() {
    if (
      this.$route.params.accion !== "ver" &&
      this.$route.params.accion !== "editar"
    ) {
      this.$router.replace("/");
    }
  }
};
</script>