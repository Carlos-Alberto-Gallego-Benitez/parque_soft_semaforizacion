<template>
    <main>
        <h1 class="app-page-title"><img alt="logo"  src="../../../assets/images/img-modulos/etapas.png" width="32"> Secciones</h1>
        <h1 class="app-page-title">Formulario: <span class="text-orange">{{formulario.nombre}}</span></h1>
        <div class="card">
            <div class="card-body">
                <div class="col-12 d-flex justify-content-end py-4"> 
                    <button @click="modificar=false; abrirModal();" type="button" class="btn app-btn-primary ">
                        Crear Seccion&nbsp;<i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="modal fade" id="modalEtapa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <input type="text" class="form-control" v-model="nombre" placeholder="Nombre de la seccion..." >
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Numero de Preguntas <span class="text-danger">(*)</span></label>
                                        <input type="number" class="form-control" v-model="numero_preguntas" placeholder="numero preguntas..." >
                                    </div> 
                                    <div class="form-group">
                                        <label class="form-label">Puntaje M??ximo <span class="text-danger">(*)</span></label>
                                        <input type="number" class="form-control" v-model="puntaje_maximo" placeholder="puntaje maximo..." >
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
                 <div v-if="!etapas.length" class="col-12 alert alert-warning" ><i class="fa fa-exclamation-circle fa -fw"></i> No se han creado secciones...</div>
                <div class="table-responsive" v-else>
                    <table class="table table-striped table-bordered " id="datatable" style="width:100%">
                        <thead>
                            <br>
                           <tr class="table-success">
                                <th>Nombre</th>
                                <th>No. Preguntas</th>
                                <th>Puntaje M??ximo</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="etapa in etapas" :key="etapa.id">
                                <td>{{etapa.nombre}}</td>
                                <td>{{etapa.numero_preguntas}}</td>
                                <td>{{etapa.puntaje_maximo}}</td>
                                <td >
                                    <span v-if="etapa.activo==='S'" class="badge bg-primary"><i class="fa fa-check fa-fw"></i>Activo</span>
                                    <span v-else class="badge bg-danger"><i class="fa fa-close fa-fw"></i>Inactivo</span>
                                </td>
                                <td>
                                    <button @click="modificar=true; abrirModal(etapa);" class="btn app-btn-secondary mx-1 mb-2" >
                                        <i class="fa fa-edit"></i>&nbsp;Editar
                                    </button> 
                                   <!--  <button  @click="estado(etapa.id);" class="btn btn-success" >
                                        <i class="fa fa-edit"></i>&nbsp;Estado
                                    </button> 
                                    <button  @click="eliminar(etapa.id);" class="btn btn-danger" >
                                        <i class="fa fa-edit"></i>&nbsp;Eliminar
                                    </button> --> 
                                     <router-link  
                                        :to="{ name: 'config.preguntas.formularios', params: { 'id_seccion': etapa.id,'id_formulario':etapa.id_formulario } }"
                                        class="btn app-btn-primary "
                                        >
                                        <i class="fas fa-plus fa-fw"></i>  Preguntas 
                                    </router-link> 
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
import seccionService from '../../../services/seccionService';
import {Modal} from 'bootstrap';
import Swal from 'sweetalert2';
import useVuelidate from '@vuelidate/core';
import {required} from '@vuelidate/validators';
import sFormularioService from '../../../services/sFormularioService';

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
            puntaje_maximo:'',
            numero_preguntas:'',
            id_etapa:'',
            id:'',
            etapas:{},
            idFormulario:'',  
            formulario:{}  
        }
    },
    validations(){
        return{
            nombre:{required},
            puntaje_maximo:{required},
            numero_preguntas:{required},
        }
    },
    methods: {
        async abrirModal(data={}){
            
            this.modalShow();

            if(this.modificar){
                this.id_etapa=data.id;
                this.tituloModal="Modificar Seccion";
                this.nombre=data.nombre;
                this.puntaje_maximo=data.puntaje_maximo;
                this.numero_preguntas=data.numero_preguntas;
            }else{
                this.id=0;
                this.tituloModal="Crear Seccion";
                this.nombre='';
                this.puntaje_maximo='';
                this.numero_preguntas='';
            }
        },
        async cargarSecciones(){
            const response = await seccionService.showByIdFormulario(this.idFormulario);
            this.etapas=response.data;
        },
        async cargarFormulario(){
            const response = await sFormularioService.show(this.idFormulario);
            this.formulario=response.data;
        },
        async guardar(){  
            this.v$.$validate();
            if(this.v$.$error){
                Swal.fire('Hay campos vacios','', 'error');
            }else{
                let etapa={
                    id_formulario:this.idFormulario,
                    nombre:this.nombre,
                    puntaje_maximo:this.puntaje_maximo,
                    numero_preguntas:this.numero_preguntas
                }          
                if(this.modificar){
                    etapa.id=this.id_etapa;
                    await seccionService.update(etapa);
                    this.modalHide();
                    Swal.fire('Datos actualizados con exito','', 'success');
                    this.$nextTick(()=>{$('#datatable').DataTable().destroy();})
                    await this.cargarSecciones();
                    this.datatable();
                    
                }else{
                    await seccionService.store(etapa);
                    Swal.fire('Datos guardados con exito','', 'success');
                    this.modalHide();
                    this.$nextTick(()=>{$('#datatable').DataTable().destroy();})
                    await this.cargarSecciones();
                    this.datatable();
                }
            }
            
        },
        modalShow(){
            var myModal = new Modal(document.getElementById('modalEtapa'));
            myModal.show();
        },
        modalHide(){
           let myModal = document.getElementById('modalEtapa');
            let m = Modal.getInstance(myModal)
            m.hide();
        },
        async estado(id){
            await seccionService.estado(id);
            this.$nextTick(()=>{$('#datatable').DataTable().destroy();})
            await this.cargarSecciones();
            this.datatable();
        },
        async eliminar(id){
            await seccionService.delete(id);
            this.$nextTick(()=>{$('#datatable').DataTable().destroy();})
            await this.cargarSecciones();
            this.datatable();
        },
        datatable(){
            this.$nextTick(()=>{
            //$('#datatable').DataTable();
            $('#datatable').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay informaci??n",
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
        this.idFormulario=this.$route.params.id;
       await this.cargarFormulario();
        await this.cargarSecciones();
        this.datatable();
    }
}
</script>
