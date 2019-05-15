<template>
  <div>
    <b-field label="Nombre">
      <b-input v-model="childData.nombre"></b-input>
    </b-field>

    <b-field label="Fecha">
      <b-datepicker
        placeholder="Click para elegir..."
        :min-date="minDate"
        icon="calendar-alt"
        v-model="childData.fecha"
      ></b-datepicker>
    </b-field>

    <b-field label="Hora">
      <b-clockpicker placeholder="Click para elegir..." icon="clock" v-model="childData.fecha"></b-clockpicker>
    </b-field>

    <b-field label="Descripción">
      <b-input v-model="childData.descripcion" maxlength="500" type="textarea"></b-input>
    </b-field>

    <div class="columns is-mobile">
      <div class="column is-6">
        <b-field label="¿Disponible?">
          <b-switch
            v-model="childData.disponible"
            true-value="Si"
            false-value="No"
          >{{ childData.disponible }}</b-switch>
        </b-field>
      </div>
      <div class="column is-6">
        <b-field label="Cupos">
          <b-numberinput v-model="childData.cupos"></b-numberinput>
        </b-field>
      </div>
    </div>

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

    <img :src="childData.imagen">

    <div class="actualizar has-text-right">
      <b-button @click="$emit('communication', childData)" type="is-primary">Crear Taller</b-button>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    const today = new Date();
    return {
      minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
      childData: {
        nombre: "",
        fecha: today,
        descripcion: "",
        disponible: "Si",
        cupos: 0,
        imagen: ""
      }
    };
  },
  methods: {
    changeImage(e) {
      let file = e.target.files[0];
      let reader = new FileReader();
      // eslint-disable-next-line
      reader.onload = file => {
        this.childData.imagen = reader.result;
      };
      reader.readAsDataURL(file);
    }
  }
};
</script>

<style scoped>
.file {
  margin-top: 2em;
}
.actualizar {
  margin-top: 1em;
}

img {
  margin-top: 0.5em;
}
</style>
