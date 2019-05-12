<template>
  <div v-if="!isEmpty(taller)">
    <Header/>
    <Container>
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
  </div>
  <Loader v-else/>
</template>

<script>
import Loader from "@/components/Loader.vue";
import Header from "@/components/Taller/Header.vue";
import Container from "@/components/Taller/Container.vue";
import Information from "@/components/Taller/Information.vue";
import Formulario from "@/components/Taller/Formulario.vue";
import { db } from "@/helpers/firebaseInit.js";

export default {
  data() {
    return {
      taller: {}
    };
  },
  methods: {
    isEmpty(obj) {
      for (var key in obj) {
        if (obj.hasOwnProperty(key)) return false;
      }
      return true;
    }
  },
  mounted: function() {
    db.collection("talleres")
      .where("id", "==", Number(this.$route.params.id))
      .get()
      .then(querySnapshot => {
        querySnapshot.forEach(doc => {
          this.taller = doc.data();
        });
      });
  },
  components: {
    Header,
    Container,
    Information,
    Loader,
    Formulario
  }
};
</script>

<style scoped>
</style>
