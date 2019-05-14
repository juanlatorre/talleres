<template>
  <div v-if="!isEmpty(taller)">
    <Header/>
    <Container v-if="this.accion == 'ver'">
      <Information
        :nombre="taller.nombre"
        :fecha="taller.fecha"
        :hora="taller.hora"
        :descripcion="taller.descripcion"
        :imagen="taller.imagen"
      />
      <hr>
      <Formulario :id="taller.id"/>
    </Container>
    <Container v-else>
      <Editar
        :id="docID"
        :nombre="taller.nombre"
        :fechaRaw="taller.fecha"
        :hora="taller.hora"
        :descripcion="taller.descripcion"
        :imagen="taller.imagen"
        :disponible="taller.disponible"
        :cupos="taller.cupos"
        @repollo="repollito"
      />
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
      taller: {},
      docID: null
    };
  },
  methods: {
    isEmpty(obj) {
      for (var key in obj) {
        if (obj.hasOwnProperty(key)) return false;
      }
      return true;
    },
    repollito() {
      console.log("REPOLLO");
    }
  },
  mounted: function() {
    db.collection("talleres")
      .where("id", "==", Number(this.$route.params.id))
      .get()
      .then(querySnapshot => {
        querySnapshot.forEach(doc => {
          this.taller = doc.data();
          this.docID = doc.id;
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

<style scoped>
</style>
