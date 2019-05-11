<template>
  <div>
    <pre>
      {{taller}}
    </pre>
  </div>
</template>

<script>
import { db } from "@/helpers/firebaseInit.js";
export default {
  data() {
    return {
      taller: {}
    };
  },
  mounted: function() {
    db.collection("talleres")
      .where("id", "==", Number(this.$route.params.id))
      .get()
      .then(querySnapshot => {
        querySnapshot.forEach(doc => (this.taller = doc.data()));
      });
  }
};
</script>

<style>
</style>
