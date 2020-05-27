<template>
  <div class="table-responsive">
    <form @submit.prevent="editarAsesor(asesor)" v-if="modoEditar">
      <h3>Editar Asesor</h3>
        <input type="text" class="form-control mb-2" 
            placeholder="Nombre" v-model="asesor.nombre">
        <input type="number" class="form-control mb-2" 
        placeholder="Cedula" v-model="asesor.cedula">
        <input type="number" class="form-control mb-2" 
        placeholder="Telefono" v-model="asesor.telefono">
        <input type="datetime-local" v-model="asesor.edad" 
          ><label>               Ingrese la fecha de nacimiento</label>
        <select class="custom-select"  placeholder="Genero" id="inputGroupSelect02" v-model="asesor.genero">
            <option selected>Seleccione Genero...</option>
            <option value="1">masculino</option>
            <option value="2">femenino</option>
         </select>

        <input type="text" class="form-control mb-2" 
        placeholder="Cliente" v-model="asesor.cliente">
         <select class="custom-select" v-model="asesor.sede">
            <option selected>Seleccione Sede...</option>
            <option value="1">Ruta_N</option>
            <option value="2">Puertto_Seco</option>
            <option value="3">Buro</option>
        </select>
      <button class="btn btn-success" type="submit">Guardar</button>
      <button class="btn btn-danger" type="submit" 
        @click="cancelarEdicion">Cancelar</button>
    </form>

    <!-- agregar asesores -->
    <form @submit.prevent="agregar" v-else>
      <h3>Agregar Asesor</h3>
      <input type="text" class="form-control mb-2" 
            placeholder="Nombre" v-model="asesor.nombre">
        <input type="number" class="form-control mb-2" 
        placeholder="Cedula" v-model="asesor.cedula">
        <input type="number" class="form-control mb-2" 
        placeholder="Telefono" v-model="asesor.telefono">
          <input type="datetime-local" v-model="asesor.edad" 
          ><label>               Ingrese la fecha de nacimiento</label>
        <select class="custom-select" v-model="asesor.genero" >
            <option selected>Seleccione Genero...</option>
            <option value="1">masculino</option>
            <option value="2">femenino</option>
         </select>
        <input type="text" class="form-control mb-2" 
        placeholder="Cliente" v-model="asesor.cliente">
        <select class="custom-select" v-model="asesor.sede">
            <option selected>Seleccione Sede...</option>
            <option value="1">Ruta_N</option>
            <option value="2">Puertto_Seco</option>
            <option value="3">Buro</option>
        </select>
      <button class="btn btn-primary" type="submit">Agregar</button>
    </form>
  
    <!-- lista de asesores -->
    <hr>
    <h3>Lista de Asesores:</h3>
        <table class="table sm table-hover table-condensed" >
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
                    <td>{{item.year}}   </td>
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
      asesor: {nombre: '', cedula: '',telefono: '', edad: '', year:'',genero: '', cliente: '',sede: ''}
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
      this.asesor.telefono.trim() === '' ||  this.asesor.edad.trim() === ''||
      this.asesor.genero.trim() === '' || this.asesor.cliente.trim() === ''||
      this.asesor.sede.trim() === ''){
        alert('Debes completar todos los campos antes de guardar');
        return;
      }
      const asesorNueva = this.asesor;
      this.asesor = {nombre: '', cedula: '',telefono: '', edad: '', year:'',genero: '', cliente: '',sede: ''};    
      axios.post('/asesors', asesorNueva)
        .then((res) =>{
          const asesorServidor = res.data;
          this.asesors.push(asesorServidor);
        })
    },
    editarFormulario(item){
        this.asesor.nombre=item.nombre;
        this.asesor.cedula=item.cedula;
        this.asesor.telefono=item.telefono;
        this.asesor.edad=item.edad;
        this.asesor.genero=item.genero;
        this.asesor.cliente=item.cliente;
        this.asesor.sede=item.sede;
        this.asesor.id=item.id;
        this.modoEditar = true;
                    
    },
    editarAsesor(asesor){
      const params = {nombre: asesor.nombre, cedula: asesor.cedula,telefono: asesor.telefono, edad: asesor.edad,genero: asesor.genero, cliente: asesor.cliente,sede: asesor.sede};
      axios.put(`/asesors/${asesor.id}`, params)
        .then(res=>{
          this.modoEditar = false;
          const index = this.asesors.findIndex(item => item.id === asesor.id);
          this.asesors[index] = res.data;
          axios.get('/asesors').then(res=>{
            this.asesors = res.data;
          })
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
      this.asesor = {nombre: '', cedula: '',telefono: '', edad: '', year:'',genero: '', cliente: '',sede: ''};
    }
  }
}
</script>