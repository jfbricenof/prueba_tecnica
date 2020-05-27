<template>
  <div>
    <form @submit.prevent="editarAsesor(asesor)" v-if="modoEditar">
      <h3>Editar Asesor</h3>
        <input type="text" class="form-control mb-2" 
            placeholder="Nombre" v-model="asesor.nombre">
        <input type="number" class="form-control mb-2" 
        placeholder="Cedula" v-model="asesor.cedula">
        <input type="number" class="form-control mb-2" 
        placeholder="Telefono" v-model="asesor.telefono">
        <input type="datetime" class="form-control mb-2" 
        placeholder="Edad" v-model="asesor.edad">
        <input type="text" class="form-control mb-2" 
        placeholder="Genero" v-model="asesor.genero">
        <!-- <select class="custom-select" v-model="asesor.genero">
            <option selected>Choose...</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select> -->

        <input type="text" class="form-control mb-2" 
        placeholder="Cliente" v-model="asesor.cliente">
        <input type="text" class="form-control mb-2" 
        placeholder="Sede" v-model="asesor.sede">

        <!-- <select class="custom-select" v-model="asesor.sede">
            <option selected>Choose...</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
         -->
      <button class="btn btn-warning" type="submit">Editar</button>
      <button class="btn btn-danger" type="submit" 
        @click="cancelarEdicion">Cancelar</button>
    </form>
    <!-- insertar asesores -->
    <form @submit.prevent="agregar" v-else>
      <h3>Agregar Asesor</h3>
      <input type="text" class="form-control mb-2" 
            placeholder="Nombre" v-model="asesor.nombre">
        <input type="number" class="form-control mb-2" 
        placeholder="Cedula" v-model="asesor.cedula">
        <input type="number" class="form-control mb-2" 
        placeholder="Telefono" v-model="asesor.telefono">
        <input type="datetime" class="form-control mb-2" 
        placeholder="Edad" v-model="asesor.edad">
        <input type="text" class="form-control mb-2" 
        placeholder="Genero" v-model="asesor.genero">
        <!-- <select class="custom-select" v-model="asesor.genero">
            <option selected>Choose...</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select> -->

        <input type="text" class="form-control mb-2" 
        placeholder="Cliente" v-model="asesor.cliente">
        <input type="text" class="form-control mb-2" 
        placeholder="Sede" v-model="asesor.sede">

        <!-- <select class="custom-select" v-model="asesor.sede">
            <option selected>Choose...</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select> -->

     
      <button class="btn btn-primary" type="submit">Agregar</button>
    </form>

    <!-- lista de asesores -->
    <hr>
    <h3>Lista de Asesores:</h3>
        <table class="table table-hover" >
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Cedula</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Genero</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Sede</th>
                    <th scope="col">Usuario_Reg</th>
                    <th scope="col">Creado</th>
                    <th scope="col">Accion</th>
                </tr>
            </thead>
            <tbody>
                    <tr v-for="(item, index) in asesors" :key="index">
                    <th scope="row">{{index+1}}</th>
                    <td>{{item.nombre}}</td>
                    <td>{{item.cedula}}</td>
                    <td>{{item.telefono}}</td>
                    <td>{{item.edad}}</td>
                    <td>{{item.genero}}</td>
                    <td>{{item.cliente}}</td>
                    <td>{{item.sede}}</td>
                    <td>{{item.user_id}}</td>
                    <td>{{item.created_at}}</td>
                    <td ><button class="btn btn-warning btn-sm" 
                @click="editarFormulario(item)">Editar</button>
            <button class="btn btn-danger btn-sm" 
                @click="eliminarAsesor(item, index)">Eliminar</button></td>
                    </tr>
            </tbody>
        </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      asesors: [],
      modoEditar: false,
      asesor: {nombre: '', cedula: '',telefono: '', edad: '',genero: '', cliente: '',sede: ''}
    }
  },
  created(){
    axios.get('/asesors').then(res=>{
      this.asesors = res.data;
    })
  },
  methods:{
    agregar(){
      if(this.asesor.nombre.trim() === '' || this.asesor.cedula.trim() === ''||
      this.asesor.telefono.trim() === '' || this.asesor.edad.trim() === ''||
      this.asesor.genero.trim() === '' || this.asesor.cliente.trim() === ''||
      this.asesor.sede.trim() === ''){
        alert('Debes completar todos los campos antes de guardar');
        return;
      }
      const asesorNueva = this.asesor;
      this.asesor = {nombre: '', cedula: '',telefono: '', edad: '',genero: '', cliente: '',sede: ''};    
      axios.post('/asesors', asesorNueva)
        .then((res) =>{
          const asesorServidor = res.data;
          this.asesors.push(asesorServidor);
        })
    },
    editarFormulario(item){
      this.asesor.nombre = item.nombre;
      this.asesor.descripcion = item.descripcion;
      this.asesor.id = item.id;
      this.modoEditar = true;
    },
    editarAsesor(asesor){
      const params = {nombre: asesor.nombre, cedula: asesor.cedula,telefono: asesor.telefono, edad: asesor.edad,genero: asesor.genero, cliente: asesor.cliente,sede: asesor.sede};
      axios.put(`/asesors/${asesor.id}`, params)
        .then(res=>{
          this.modoEditar = false;
          const index = this.asesors.findIndex(item => item.id === asesor.id);
          this.asesors[index] = res.data;
        })
    },
    eliminarAsesor(asesor, index){
      const confirmacion = confirm(`Eliminar asesor ${asesor.nombre}`);
      if(confirmacion){
        axios.delete(`/asesors/${asesor.id}`)
          .then(()=>{
            this.asesors.splice(index, 1);
          })
      }
    },
    cancelarEdicion(){
      this.modoEditar = false;
      this.asesor = {nombre: '', cedula: '',telefono: '', edad: '',genero: '', cliente: '',sede: ''};
    }
  }
}
</script>