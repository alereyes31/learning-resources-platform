<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';

let categories = ref([]);
let title = ref('');
let description = ref('');
let link = ref('');

onMounted(() => {
    axios.get('api/categories').then((response) => {
        categories = response.data;
    });
});

function createResource() {
    console.log("Creando Recurso", title.value, description.value, link.value);
    axios.post('api/resources', {
        title: title.value,
        description: description.value,
        link: link.value
    }).then((response) => {
        console.log(response);
    });
}

</script>    

<template>
    <div class="m-8">
      <div class="row mb-3">
        <div class="col-md-3">
          <label for="title">Título:</label>
        </div>
        <div class="col-md-9">
          <p>{{ title }}</p>
          <input type="text" v-model="title" id="title" class="form-control" />
        </div>
      </div>
  
      <div class="row mb-3">
        <div class="col-md-3">
          <label for="description">Descripción:</label>
        </div>
        <div class="col-md-9">
          <input type="text" v-model="description" id="description" class="form-control" />
        </div>
      </div>
  
      <div class="row mb-3">
        <div class="col-md-3">
          <label for="link">Enlace:</label>
        </div>
        <div class="col-md-9">
          <input type="text" v-model="link" id="link" class="form-control" />
        </div>
      </div>
  
      <div class="row">
        <div class="col-md-9 offset-md-3">
          <button @click="createResource" class="btn btn-primary mt-3" style="padding: 8px 20px; background-color: gray; color: white; border: none; border-radius: 4px; cursor: pointer;">Crear Recurso</button>
        </div>
      </div>
    </div>
  </template>
  