<template>
    <main>
        <h1 class="app-page-title"><img alt="logo"  src="../../../assets/images/img-modulos/etapas.png" width="32"> Configuracion de preguntas</h1>
        <h1 class="app-page-title">Formulario: <span class="text-orange">{{formulario.nombre}}</span></h1>
        <h1 class="app-page-title">Seccion: <span class="text-success">{{seccion.nombre}}</span></h1>
        <div class="card">
            <div class="card-body">
                <div class="col-12 d-flex justify-content-end py-4"> 
                    <button @click="modificar=false; abrirModal();" type="button" class="btn app-btn-primary ">
                        Crear Pregunta&nbsp;<i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="modal fade" id="modalPregunta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <div class="mb-3">
                                        <label class="form-label">Tipo Pregunta</label>
                                        <select  v-model="pregunta.tipo"   class="form-control"  >
                                            <option value="C">Cerrada</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nombre Pregunta<span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control" v-model="pregunta.nombre" placeholder="Nombre de la pregunta..." >
                                    </div>
                                    <div v-if="pregunta.tipo==='C'">
                                    <div  class="card-header bg-light mt-2 "><b>Posibles opciones</b></div>
                                        <div class="card-body">
                                            <div class="mb-3 row" >
                                                <div class="col-4">
                                                    <label class="form-label">Opción</label>
                                                    <input type="text" class="form-control" v-model="opcion_pre.opcion"  >
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label">Puntaje</label>
                                                    <input type="number" class="form-control" v-model="opcion_pre.puntaje"  >
                                                </div>
                                                <div class="col-4 mt-4 py-2"> 
                                                    <button class="btn app-btn-primary " @click.prevent="agregarOpcion();" type="button">Agregar Opciones&nbsp;<i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <table class="table table-striped table-sm ">
                                                    <thead>
                                                        <tr class="table-primary">
                                                            <th>Opción</th>
                                                            <th>Puntaje</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item,i) in pregunta.opciones" :key="i">
                                                            <td>{{item.opcion}}</td>
                                                            <td>{{item.puntaje}}</td>
                                                            <td>
                                                                <button class="btn btn-outline-danger"  @click.prevent="removerOpcion()">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>  
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
                <div v-if="!preguntas.length" class="col-12 alert alert-warning" ><i class="fa fa-exclamation-circle fa -fw"></i> No se han creado preguntas...</div>
                <div class="table-responsive" v-else>
                    <table class="table table-striped table-bordered " id="datatable" style="width:100%">
                        <thead>
                            <br>
                           <tr class="table-success">
                                <th>Nombre</th>
                                <th>Opciones de respuesta</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="ite in preguntas" :key="ite.id">
                                <td class="celda">{{ite.nombre}}</td>
                                <td class="table-success" v-if="ite.tipo_pregunta==='C'"><ul  v-for="opc in ite.opciones" :key="opc.id"><li>{{opc.opcion}}, (Puntaje: {{opc.puntaje}})</li> </ul></td>
                                <td class="table-warning" v-else>Esta Pregunta es abierta</td>
                                <td>
                                    <button @click="modificar=true; abrirModal(ite);" class="btn app-btn-secondary" >
                                        Editar <i class="fa fa-edit fa-fw"></i>
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
import sPreguntasFormularioService from '../../../services/sPreguntasFormularioService';
import {Modal} from 'bootstrap';
import Swal from 'sweetalert2';
import useVuelidate from '@vuelidate/core';
import {required} from '@vuelidate/validators';
import sFormularioService from '../../../services/sFormularioService';
import {isEmpty} from 'lodash';
import 'jquery/dist/jquery.min.js';
import "datatables.net-dt/js/dataTables.dataTables"
import "datatables.net-dt/css/jquery.dataTables.min.css"
import $ from 'jquery'; 
import sOpcionesPreguntasFormularioService from '../../../services/sOpcionesPreguntasFormularioService';
import seccionService from '../../../services/seccionService';

export default {
    data(){
        return{
            v$:useVuelidate(),
            modificar:true,
            tituloModal:'',
            preguntas:{},
            idFormulario:'', 
            idSeccion:'', 
            formulario:{} ,
            seccion:{},
            pregunta:{
                id:'',
                id_seccion:'',
                nombre:'',
                tipo:'C',
                opciones:[],
            },
             opcion_pre:{
                opcion:'',
                puntaje:'',
            },
        }
    },
    validations(){
       return{
            pregunta:{
                nombre:{required},
                tipo:{required},
            },
        }
    },
    methods: {
        async abrirModal(data={}){
            
            this.modalShow();

            if(this.modificar){
                this.tituloModal="Modificar Pregunta";
                this.pregunta.id=data.id;
                this.pregunta.nombre=data.nombre;
                this.pregunta.tipo=data.tipo_pregunta;
                if(this.pregunta.tipo==='C'){
                    const response=await sOpcionesPreguntasFormularioService.showByPre(this.pregunta.id);
                    this.pregunta.opciones = response.data;
                }
            }else{
                this.tituloModal="Crear Pregunta";
                this.pregunta.nombre='';
                this.pregunta.opciones=[];
            }
        },
        async cargarPreguntas(){
            const response = await sPreguntasFormularioService.showByIdSeccion(this.idSeccion);
            this.preguntas=response.data;
        },
        async cargarFormulario(){
            const response = await sFormularioService.show(this.idFormulario);
            this.formulario=response.data;
        },
        async cargarSeccion(){
            const response = await seccionService.show(this.idSeccion);
            this.seccion=response.data;
        },
        agregarOpcion(){
            this.pregunta.opciones.push({...this.opcion_pre});
            this.opcion_pre={};
        },
        removerOpcion(index) {
            this.pregunta.opciones.splice(index, 1);
        },
         modalShow(){
            var myModal = new Modal(document.getElementById('modalPregunta'));
            myModal.show();
        },
        modalHide(){
           let myModal = document.getElementById('modalPregunta');
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
        },
        async guardar(){  
            this.v$.$validate();
            if (isEmpty(this.pregunta.opciones)) {
                Swal.fire({text: "No se han agregado opciones", icon: "error"});
                return;
            }
            if(this.v$.$error){
                Swal.fire('Hay campos vacios','', 'error');
            }else{
                this.pregunta.id_seccion=this.idSeccion;
                if(this.modificar){
                    await sPreguntasFormularioService.update(this.pregunta);
                    this.modalHide();
                    Swal.fire('Datos guardados con exito','', 'success');
                    //this.idFormulario=this.$route.params.id;
                    this.cargarPreguntas();
                    
                }else{
                await sPreguntasFormularioService.store(this.pregunta);
                    this.modalHide();
                    Swal.fire('Datos guardados con exito','', 'success');
                    //this.idFormulario=this.$route.params.id;
                    this.cargarPreguntas();
                }
            }

        },
       
    },
    async created(){
        this.idFormulario=this.$route.params.id_formulario;
        this.idSeccion=this.$route.params.id_seccion;
       await this.cargarFormulario();
       await this.cargarSeccion();
        this.cargarPreguntas(this.idFormulario);
        this.datatable();
    }
}
</script>
