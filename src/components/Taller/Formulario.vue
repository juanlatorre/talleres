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
              var templateParams = {
                nombre: this.nombre,
                to_email: this.correo
              };

              emailjs
                .send(
                  "smtp_server",
                  "template_PS32idzL",
                  templateParams,
                  "user_RLFjtWwa9BM99xCAsydHs"
                )
                .then(
                  function(response) {
                    console.log("SUCCESS!", response.status, response.text);
                  },
                  function(err) {
                    console.log("FAILED...", err);
                  }
                );
              // enviar correo a inscrito con información de pago
              // Email.send({
              //   SecureToken: "01235337-f34d-4a6f-aff5-5917a538abe1",
              //   To: "juanlatorreharcha@gmail.com",
              //   From: "noreply@talleresdecocina.cl",
              //   Subject: "Información de pago Talleres Cabo Blanco",
              //   Body: "<h1>And this is the body</h1><br><br><p>Hola amigo</p>"
              // })
              // enviar correo a karime informando que alguien se inscribió
              // Email.send({
              //   SecureToken: "01235337-f34d-4a6f-aff5-5917a538abe1",
              //   To: "them@website.com",
              //   From: "you@isp.com",
              //   Subject: "This is the subject",
              //   Body: "And this is the body"
              // });
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
