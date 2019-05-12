<template>
  <form @submit.prevent="send">
    <b-field
      label="Nombre"
      :type="{'is-danger': errors.has('nombre')}"
      :message="errors.first('nombre')"
    >
      <b-input v-model="nombre" type="text" name="nombre" v-validate="'required'"/>
    </b-field>

    <b-field
      label="Correo"
      :type="{'is-danger': errors.has('correo')}"
      :message="errors.first('correo')"
    >
      <b-input v-model="correo" type="email" name="correo" v-validate="'required'"/>
    </b-field>

    <b-field
      label="Teléfono"
      :type="{'is-danger': errors.has('telefono')}"
      :message="errors.first('telefono')"
    >
      <b-input
        v-model="telefono"
        type="phone"
        name="telefono"
        v-validate="'required'"
        maxlength="9"
      />
    </b-field>

    <button class="button is-primary" type="submit">Enviar</button>
  </form>
</template>

<script>
export default {
  props: ["id"],
  data: function() {
    return {
      nombre: null,
      correo: null,
      telefono: null
    };
  },
  methods: {
    send() {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.$store.dispatch("inscribirCliente", {
            id: this.id,
            nombre: this.nombre,
            correo: this.correo,
            telefono: this.telefono
          });
          // this.$toast.open({
          //   message: "Inscripción enviada!",
          //   type: "is-success",
          //   position: "is-bottom"
          // });
          return;
        }
      });
    }
  },
  mounted: function() {
    this.$validator.localize("es", {
      messages: {
        required: field => "* Por favor escribe tu " + field
      }
    });
  }
};
</script>

<style>
</style>
