<template>
    <main>
        <h1 class="app-page-title"><img alt="logo"  src="../../../assets/images/img-modulos/formulario.png" width="32"> Formularios Empresas</h1>
        <div class="card">
            <div class="card-body">
                <div class="col-12 d-flex justify-content-end py-4"> 
                    <button @click="modificar=false; abrirModal();" type="button" class="btn app-btn-primary ">
                        Crear Formulario&nbsp;<i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="modal fade" id="modalFormulario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <div class="form-group">
                                        <label class="form-label">Nombre <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control" v-model="nombre" placeholder="Nombre del formulario..." >
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
                <div class="col-12 alert alert-warning" v-if="!formularios.length"><i class="fa fa-exclamation-circle fa -fw"></i> No se han creado formularios...</div>
                <div class="table-responsive" v-else>
                    <table class="table table-striped table-bordered " id="datatable" style="width:100%">
                        <thead>
                            <br>
                           <tr class="table-success">
                                <th>Nombre</th>
                                <th>Sector(es)</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in formularios" :key="item.id">
                                <td>{{item.nombre}}</td>
                                <td class="table-warning" v-if="item.formulario_sector.length">
                                    <ul v-for="formulario_sector in item.formulario_sector" :key="`${formulario_sector.id}_f`">
                                        <li>{{formulario_sector.sector.nombre}}</li>
                                    </ul>
                                </td>
                                <td v-else class="table-danger">Sin sectores</td>
                                <td >
                                    <span v-if="item.activo==='S'" class="badge bg-primary"><i class="fa fa-check fa-fw"></i>Activo</span>
                                    <span v-else class="badge bg-danger"><i class="fa fa-close fa-fw"></i>Inactivo</span>
                                </td>
                                <td class="celda">
                                    <div class="row g-3">
                                   <div class="col-auto">
                                       
                                    <button @click="modificar=true; abrirModal(item);" class="btn app-btn-secondary" >
                                        <i class="fa fa-edit"></i>&nbsp;Editar
                                    </button>  
                                   </div>
                                   <div class="col-auto">
                                    <router-link  
                                                :to="{ name: 'sectores.formularios', params: { 'id': item.id } }"
                                                class="btn btn-info "
                                                >
                                               <i class="fas fa-plus fa-fw"></i>  Sectores 
                                    </router-link>
                                   </div>
                                   <div class="col-auto">
                                    <router-link  
                                                :to="{ name: 'preguntas.formularios', params: { 'id': item.id } }"
                                                class="btn app-btn-primary "
                                                >
                                               <i class="fas fa-plus fa-fw"></i>  Preguntas 
                                    </router-link>
                                    </div>
                                </div>
                                            
                                
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
import formularioService from '../../../services/formularioService';
import {Modal} from 'bootstrap';
import Swal from 'sweetalert2';
import sectorEmpresaService from '../../../services/sectorEmpresaService';

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
            nombre:'',
            id_formulario:'',
            id:'',
            formularios:[],
            sectores:{},
        }
    },
    validations(){
        return{
            nombre:{required},
        }
    },
    methods: {
        async abrirModal(data={}){
            
            this.modalShow();

            if(this.modificar){
                this.id_formulario=data.id;
                this.tituloModal="Modificar Formulario";
                this.nombre=data.nombre;
            }else{
                this.id=0;
                this.tituloModal="Crear Formulario";
                this.nombre='';
            }
        },
        async cargarFormularios(){
            const res = await formularioService.index();
            this.formularios=res.data;
        },
        async cargarSectores(){
            const response = await sectorEmpresaService.index();
            this.sectores=response.data;
        },
        async guardar(){  
            this.v$.$validate();
            if(this.v$.$error){
                Swal.fire('Hay campos vacios','', 'error');
            }else{
                let formulario={
                    nombre:this.nombre
                }          
                if(this.modificar){
                    formulario.id=this.id_formulario;
                    await formularioService.update(formulario);
                    this.modalHide();
                    Swal.fire('Datos actualizados con exito','', 'success');
                    this.$nextTick(()=>{$('#datatable').DataTable().destroy();})
                    await this.cargarFormularios();
                    this.datatable();
                    
                }else{
                    await formularioService.store(formulario);
                    Swal.fire('Datos guardados con exito','', 'success');
                    this.modalHide();
                    this.$nextTick(()=>{$('#datatable').DataTable().destroy();})
                    await this.cargarFormularios();
                    this.datatable();
                }
            }
        },
        modalShow(){
            var myModal = new Modal(document.getElementById('modalFormulario'));
            myModal.show();
        },
        modalHide(){
           let myModal = document.getElementById('modalFormulario');
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
        await this.cargarFormularios();
        await this.cargarSectores();
        this.datatable();
    }
}
</script>
<style scoped>
.celda{
height: auto;
width: 400px;
}
</style>