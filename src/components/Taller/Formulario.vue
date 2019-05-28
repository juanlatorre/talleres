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
      <b-input v-model="telefono" type="number" name="telefono" v-validate="'required'"/>
    </b-field>

    <button class="button is-primary" type="submit">Enviar</button>
  </form>
</template>

<script>
import firebase, { db } from "@/helpers/firebaseInit.js";
import * as emailjs from "emailjs-com";

export default {
  props: {
    id: {
      type: String,
      required: true
    },
    nombreTaller: {
      type: String,
      required: true
    }
  },
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
          db.collection("talleres")
            .doc(this.id)
            .update({
              inscritos: firebase.firestore.FieldValue.arrayUnion({
                nombre: this.nombre,
                correo: this.correo,
                telefono: this.telefono,
                pagado: false
              })
            })
            .then(() => {
              emailjs.send(
                "smtp_server",
                "template_PS32idzL",
                {
                  nombre: this.nombre,
                  to_email: this.correo
                },
                "user_RLFjtWwa9BM99xCAsydHs"
              );

              emailjs.send(
                "smtp_server",
                "aviso_de_inscrito",
                {
                  nombreTaller: this.nombreTaller,
                  nombre: this.nombre,
                  correo: this.correo,
                  telefono: this.telefono
                },
                "user_RLFjtWwa9BM99xCAsydHs"
              );
              this.nombre = null;
              this.correo = null;
              this.telefono = null;
              this.$snackbar.open({
                duration: 5000,
                message:
                  "Gracias por tu interés en nuestro taller, pronto recibirás en tu correo la información de pago.",
                type: "is-success",
                position: "is-bottom-right",
                actionText: "Ok",
                queue: false
              });
            }) // eslint-disable-next-line
            .catch(error => {
              this.$snackbar.open({
                duration: 5000,
                message: "Hubo un error al inscribirte en el taller.",
                type: "is-warning",
                position: "is-bottom-right",
                actionText: "Ok",
                queue: false
              });
            });
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
