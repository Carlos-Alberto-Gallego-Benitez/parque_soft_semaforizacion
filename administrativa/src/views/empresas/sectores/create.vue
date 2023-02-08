<template>
    <main>
        <h1 class="app-page-title"><img alt="logo"  src="../../../assets/images/img-modulos/empresa.png" width="32"> Sectores Empresas</h1>
        <div class="card">
            <div class="card-body">
                <div class="col-12 d-flex justify-content-end py-4"> 
                    <button @click="modificar=false; abrirModal();" type="button" class="btn app-btn-primary ">
                        Crear Sector&nbsp;<i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="modal fade" id="modalSector" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <input type="text" class="form-control" v-model="nombre" placeholder="Nombre del sector..." >
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
                <div v-if="!sectores.length" class="col-12 alert alert-warning" ><i class="fa fa-exclamation-circle fa -fw"></i> No se han creado sectores...</div>
                <div class="table-responsive" v-else>
                    <table class="table table-striped table-bordered " id="datatable" style="width:100%">
                        <thead><br>
                           <tr class="table-success">
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="sector in sectores" :key="sector.id">
                                <td>{{sector.nombre}}</td>
                                <td >
                                    <span v-if="sector.activo==='S'" class="badge bg-primary"><i class="fa fa-check fa-fw"></i>Activo</span>
                                    <span v-else class="badge bg-danger"><i class="fa fa-times-circle fa-fw"></i>Inactivo</span>
                                </td>
                                <td>
                                    <button @click="modificar=true; abrirModal(sector);" class="btn app-btn-secondary" >
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
import sectorEmpresaService from '../../../services/sectorEmpresaService';
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
            nombre:'',
            id_sector:'',
            id:'',
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
                this.id_sector=data.id;
                this.tituloModal="Modificar Sector";
                this.nombre=data.nombre;
            }else{
                this.id=0;
                this.tituloModal="Crear Sector";
                this.nombre='';
            }
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
                let sector={
                    nombre:this.nombre
                }          
                if(this.modificar){
                    sector.id=this.id_sector;
                    await sectorEmpresaService.update(sector);
                    this.modalHide();
                    Swal.fire('Datos actualizados con exito','', 'success');
                    this.$nextTick(()=>{$('#datatable').DataTable().destroy();})
                    await this.cargarSectores();
                    this.datatable();
                    
                }else{
                    await sectorEmpresaService.store(sector);
                    Swal.fire('Datos guardados con exito','', 'success');
                    this.modalHide();
                   this.$nextTick(()=>{$('#datatable').DataTable().destroy();})
                    await this.cargarSectores();
                    this.datatable();
                }
            }
        },
        modalShow(){
            let myModal = new Modal(document.getElementById('modalSector'));
            myModal.show();
        },
        modalHide(){
           let myModal = document.getElementById('modalSector');
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
        await this.cargarSectores();
        this.datatable();
    }
}
</script>
