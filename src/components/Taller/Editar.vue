<template>
  <div>
    <b-tabs position="is-centered" class="block" v-model="activeTab">
      <b-tab-item label="Información">
        <b-field label="Nombre">
          <b-input v-model="name"></b-input>
        </b-field>

        <b-field label="Fecha">
          <b-datepicker
            placeholder="Click para elegir..."
            :min-date="minDate"
            icon="calendar-alt"
            v-model="date"
          ></b-datepicker>
        </b-field>

        <b-field label="Hora">
          <b-clockpicker placeholder="Click para elegir..." icon="clock" v-model="time"></b-clockpicker>
        </b-field>

        <b-field label="Descripción">
          <b-input v-model="description" maxlength="500" type="textarea"></b-input>
        </b-field>

        <b-field label="¿Disponible?">
          <b-switch v-model="available" true-value="Si" false-value="No">{{ available }}</b-switch>
        </b-field>

        <div class="file">
          <label class="file-label">
            <input class="file-input" type="file" name="imagen" @change="changeImage">
            <span class="file-cta">
              <span class="file-icon">
                <i class="fas fa-upload"></i>
              </span>
              <span class="file-label">Cambiar imagen...</span>
            </span>
          </label>
        </div>

        <img :src="image">

        <div class="actualizar has-text-right">
          <b-button @click="actualizarTaller" type="is-primary">Actualizar Taller</b-button>
        </div>
      </b-tab-item>
      <b-tab-item label="Inscripciones">Inscripciones</b-tab-item>
    </b-tabs>
  </div>
</template>

<script>
export default {
  data: function() {
    const today = new Date();
    return {
      activeTab: 0,
      minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
      name: this.nombre,
      date: new Date(this.fechaRaw.seconds * 1000),
      time: new Date(this.fechaRaw.seconds * 1000),
      description: this.descripcion,
      available: this.disponible,
      image: this.imagen
    };
  },
  methods: {
    changeImage(e) {
      let file = e.target.files[0];
      let reader = new FileReader();
      // eslint-disable-next-line
      reader.onload = file => {
        this.image = reader.result;
      };
      reader.readAsDataURL(file);
    },
    actualizarTaller() {
      console.log("taller actualizado");
    }
  },
  props: {
    id: {
      type: String,
      required: true
    },
    nombre: {
      type: String,
      required: true
    },
    fechaRaw: {
      type: Object,
      required: true
    },
    descripcion: {
      type: String,
      required: true
    },
    imagen: {
      type: String,
      required: true
    },
    disponible: {
      type: String,
      required: true
    },
    cupos: {
      type: Number,
      required: true
    }
  }
};
</script>

<style scoped>
.actualizar {
  margin-top: 1em;
}

img {
  margin-top: 0.5em;
}
</style>
