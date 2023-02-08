<template>
    <main>
        <h1 class="app-page-title"><img alt="logo"  src="../../assets/images/user.png" width="32"> Usuarios</h1>
        <div class="card">
            <div class="card-body">
                <div class="col-12 d-flex justify-content-end py-4"> 
                    <button @click="modificar=false; abrirModal();" type="button" class="btn app-btn-primary ">
                        Crear Usuario&nbsp;<i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{tituloModal}}</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form >
                                    <div class="form-group mb-3">
                                        <label class="form-label">Nombre <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control" v-model="name"  >
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Email<span class="text-danger">(*)</span></label>
                                        <input type="email" class="form-control" v-model="email" >
                                    </div> 
                                     <div class="form-group mb-3">
                                        <label class="form-label">Contraseña<span class="text-danger">(*)</span></label>
                                        <input type="email" class="form-control" v-model="password" >
                                    </div>   
                                     <div class="form-group mb-3">
                                        <label class="form-label">Tipo de Usuario</label>
                                        <select  v-model="tipo"    class="form-control"  >
                                            <option value="1">SuperAdmin</option>
                                            <option value="2">Admin</option>
                                            <option value="3">Estandar</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn app-btn-primary" @click="guardar()">
                                    Guardar<i class="fas fa-save fa-fw"></i>
                                </button>
                                <button type="button" class="btn app-btn-danger" data-bs-dismiss="modal">Cerrar<i class="fas fa-times-circle fa-fw"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                 <div v-if="!usuarios.length" class="col-12 alert alert-warning" ><i class="fa fa-exclamation-circle fa -fw"></i> No se han creado usuarios...</div>
                <div class="table-responsive" v-else>
                    <table class="table table-striped table-bordered " id="datatable" style="width:100%">
                        <thead><br>
                           <tr class="table-success">
                                <th>name</th>
                                <th>Email</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="ususario in usuarios" :key="ususario.id">
                                <td>{{ususario.name}}</td>
                                <td>{{ususario.email}}</td>
                                <td>
                                    <button @click="modificar=true; abrirModal(ususario);" class="btn app-btn-secondary" >
                                        <i class="fa fa-edit"></i>&nbsp;Editar
                                    </button>  
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
import usuarioService from '../../services/usuarioService';
import {Modal} from 'bootstrap';
import Swal from 'sweetalert2';
import useVuelidate from '@vuelidate/core';
import {required} from '@vuelidate/validators';

import 'jquery/dist/jquery.min.js';
import "datatables.net-dt/js/dataTables.dataTables"
import "datatables.net-dt/css/jquery.dataTables.min.css"
import $ from 'jquery'; 

export default {
    data(){
        return{
            v$:useVuelidate(),
            modificar:true,
            tituloModal:'',
            name:'',
            email:'',
            password:'',
            id_usuario:'',
            tipo:'',
            id:'',
            usuarios:{},
        }
    },
     validations(){
        return{
            name:{required},
            email:{required},
            password:{required},
            tipo:{required},
        }
    },
    methods: {
        async abrirModal(data={}){
            
            this.modalShow();

            if(this.modificar){
                this.id_usuario=data.id;
                this.tituloModal="Modificar usuario";
                this.name=data.name;
                this.email=data.email;
                this.password=data.password;
                this.tipo=data.tipo;
            }else{
                this.id=0;
                this.tituloModal="Crear usuario";
                this.name='';
                this.email='';
                this.password='';
                this.tipo=3;

            }
        },
        async cargarUsuarios(){
            const response = await usuarioService.index();
            this.usuarios=response.data;
        },
        async guardar(){  

            this.v$.$validate();

            if(this.v$.$error){
                Swal.fire('Hay campos vacios','', 'error');
            }else{

                let usuario={
                    name:this.name,
                    email:this.email,
                    password:this.password,
                    tipo:this.tipo
                }  
                this.$store.dispatch('showSpinner');        
                if(this.modificar){
                    usuario.id=this.id_usuario;
                    await usuarioService.update(usuario);
                    this.modalHide();
                   
                    this.$nextTick(()=>{$('#datatable').DataTable().destroy();})
                    await this.cargarUsuarios();
                    this.datatable();
                    
                }else{
                    await usuarioService.store(usuario);
                   
                    this.modalHide();
                    this.$nextTick(()=>{$('#datatable').DataTable().destroy();})
                    await this.cargarUsuarios();
                    this.datatable();
                }
                this.$store.dispatch('hideSpinner');
                 Swal.fire('Datos guardados con exito','', 'success');
            }
        },
        modalShow(){
            var myModal = new Modal(document.getElementById('modalUsuario'));
            myModal.show();
        },
        modalHide(){
           let myModal = document.getElementById('modalUsuario');
            let m = Modal.getInstance(myModal)
            m.hide();
        },
        datatable(){
            this.$nextTick(()=>{
            //$('#datatable').DataTable();
            $('#datatable').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Datos No encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                        }
                    },
                });
            })
        }
       
    },
    async created(){
       await this.cargarUsuarios();
       this.datatable();

    }
}
</script>
