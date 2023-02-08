<template>
    <main>
        <h1 class="app-page-title">Configuración de preguntas</h1>
        <h1 class="app-page-title">Formulario: {{formularios.nombre}}</h1>
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
                                        <label class="form-label">Etapa</label>
                                        <select  v-model="pregunta.id_etapa"    class="form-control"  >
                                            <option :value="item.id" v-for="item in etapas" :key="item.id">
                                                {{ item.nombre }}
                                            </option >
                                        </select>
                                    </div>
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
                <div class="card mt-4" v-for="item in etapas" :key="item.id">
                    <div class="card-header text-white bg-success "><span >ETAPA DE: </span>{{item.nombre}}</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  table-bordered">
                                <thead>
                                <tr class="table-secondary">
                                        <th>Nombre</th>
                                        <th>Opciones</th>
                                        <th></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!item.preguntas.length"><td colspan="2"><div class="col-12 alert alert-warning" ><i class="fa fa-exclamation-circle fa -fw"></i> No se han agregado preguntas a esta etapa...</div></td></tr>
                                    <tr v-else v-for="ite in item.preguntas" :key="ite.id">
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
               
            </div>
        </div>
    </main>
</template>
<script>
import formularioService from '../../../services/formularioService';
import {Modal} from 'bootstrap';
import Swal from 'sweetalert2';
import etapaService from '../../../services/etapaService';
import preguntasFormularioService from '../../../services/preguntasFormularioService';
import opcionesPreguntasFormularioService from '../../../services/opcionesPreguntasFormularioService';
import useVuelidate from '@vuelidate/core';
import {required} from '@vuelidate/validators';
import {isEmpty} from "lodash";
export default {
    data(){
        return{
            v$:useVuelidate(),
            modificar:true,
            tituloModal:'',
            pregunta:{
                 id:'',
                id_etapa:'',
                nombre:'',
                tipo:'C',
                id_formulario:'',
                opciones:[],
            },
            idFormulario:'',
            formularios:{},
            preguntas:{},
            etapas:[],
            opcion_pre:{
                opcion:'',
                puntaje:'',
            },
        }
    },
    validations(){
        return{
            pregunta:{
                id_etapa:{required},
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
                this.pregunta.id_formulario=data.id_formulario;
                this.pregunta.nombre=data.nombre;
                this.pregunta.id_etapa=data.id_etapa;
                this.pregunta.tipo=data.tipo_pregunta;
                if(this.pregunta.tipo==='C'){
                    const response=await opcionesPreguntasFormularioService.showByPre(this.pregunta.id);
                    this.pregunta.opciones = response.data;
                }
            }else{
                this.tituloModal="Crear Pregunta";
                this.pregunta.nombre='';
                this.pregunta.id_etapa='';
                this.pregunta.opciones=[];
            }
        },
        async cargarFormularios(id){
            const res = await formularioService.show(id);
            this.formularios=res.data;
        },
         async cargarPreguntas(id){
            const response = await preguntasFormularioService.showByForm(id);
            this.preguntas = response.data.map(x=>{
                return {
                    ...x,
                    nombre:x.etapa.nombre,
                    //opcion:x.opciones.opcion,
                }
            });
           
        },
        async cargarEtapas(){
            const response = await etapaService.index({id_formulario:this.idFormulario});
             this.etapas = response.data.map(x=>{
                return {
                    ...x,
                    pregunta:x.preguntas.nombre,
                    tipo_pregunta:x.preguntas.tipo_pregunta,
                    id_formulario:x.preguntas.id_formulario,
                }
            });
        },
        agregarOpcion(){
            this.pregunta.opciones.push({...this.opcion_pre});
            this.opcion_pre={};
        },
        removerOpcion(index) {
            this.pregunta.opciones.splice(index, 1);
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
                this.pregunta.id_formulario=this.idFormulario;
                if(this.modificar){
                    await preguntasFormularioService.update(this.pregunta);
                    this.modalHide();
                    Swal.fire('Datos guardados con exito','', 'success');
                    this.idFormulario=this.$route.params.id;
                    this.cargarEtapas();
                    
                }else{
                await preguntasFormularioService.store(this.pregunta);
                    this.modalHide();
                    Swal.fire('Datos guardados con exito','', 'success');
                    this.idFormulario=this.$route.params.id;
                    this.cargarEtapas();
                }
            }

        },
        modalShow(){
            var myModal = new Modal(document.getElementById('modalPregunta'));
            myModal.show();
        },
        modalHide(){
           let myModal = document.getElementById('modalPregunta');
            let m = Modal.getInstance(myModal)
            m.hide();
        }
       
    },
    async created(){
        this.idFormulario=this.$route.params.id;
        this.cargarFormularios(this.idFormulario);        
        this.cargarPreguntas(this.idFormulario);
        this.cargarEtapas();
    }
}
</script>
<style scoped>
.celda{
height: auto;
width: 600px;
}
</style>