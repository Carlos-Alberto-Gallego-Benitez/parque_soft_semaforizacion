<template>
    <main>
        <section id="about" class="about">
            <div class="container-fluid">
                <div class="card ">
                    <div class="card-header bg-light">
                        Nombre de Formulario: <span class="text-success">{{formulario.nombre}}</span> 
                    </div>
                    <div class="card-body">
                        <div >
                            
                            <div class="col-md-12 pt-4" data-aos="fade-left">
                                 <div  class="alert alert-info" v-if="formulario_lleno.length">
                                    ya ha realizado este formulario...
                                </div>
                                
                            <div class="card" v-else>
                               <div class="card-header">
                                    <ul class="nav nav-tabs card-header-tabs" id="etapas">
                                        <li  v-for="(etapa, i) in etapas" :key="etapa.id" class="nav-item">
                                            <button
                                                class="nav-link "
                                                :class="{ active: i === 0 }"
                                                :id="`nav_${etapa.id}`"
                                                data-bs-toggle="tab"
                                                :data-bs-target="`#tab_${etapa.id}`"
                                                role="tab"
                                                aria-controls="nav-home"
                                                aria-selected="true"
                                                >{{ etapa.nombre }}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="nav-tabContent">
                                        <div
                                        v-for="(etapa, i) in etapas"
                                        :key="etapa.id"
                                        class="tab-pane fade pt-2"
                                        :class="{ 'show active': i === 0 }"
                                        :id="`tab_${etapa.id}`"
                                        role="tabpanel"
                                        aria-labelledby="nav-home-tab"
                                        >
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 form-group mt-2"
                                                v-for="pregunta in etapa.preguntas"
                                                :key="pregunta.id"
                                                >
                                                <label class="form-label">{{
                                                    pregunta.nombre
                                                }}</label>
                                                <select name="" id="" class="form-select" v-model="pregunta.respuesta">
                                                    <option :value="opc.opcion" v-for="opc in pregunta.opciones" :key="opc.id">{{opc.opcion}}</option>
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                            </div>
                             
                                
                            <div class="card-footer">
                                <div class="text-center">
                                    <button v-if="actual>0" type="button" class="btn btn-info mx-2" @click="atras()" >Atras</button>
                                <button v-if="!(actual===tabs.length-1)" type="button" class="btn btn-primary" @click="siguiente()">siguiente</button>
                                <button type="button" v-else class="btn btn-primary" @click="guardar();" >Guardar</button>
                                </div>
                            </div>
                                </div>
                               
                            </div>
                           
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </section>
    </main>
</template>
<script>
import {mapState} from "vuex"
import Swal from 'sweetalert2';
import etapaService from '../../services/etapaService';
import formularioService from '../../services/formularioService';
//import {isEmpty} from 'lodash';
import {Tab} from 'bootstrap';
import respuestasUsuarioService from '../../services/respuestasUsuarioService';
export default {
    data(){
        return{
            id_usuario:'',
            id_sector:'',
            idFormulario:'',
            etapas:[],
            actual:0,
            formulario_lleno:[],
            formulario:{}
        }
    },
    methods: {   
        async cargarEtapas(){
            const response = await etapaService.index({id_formulario:this.idFormulario});
            this.etapas=response.data.map(x=>{
                return {
                    id:x.id,
                    nombre:x.nombre,
                    preguntas:x.preguntas.map(y=>{
                        return {
                            ...y,
                            respuesta:'',
                        }
                    })
                }
            });
            this.$nextTick(()=>{
                var triggerTabList = [].slice.call(document.querySelectorAll('#etapas button.nav-link'))
                triggerTabList.forEach(function (triggerEl) {
                var tabTrigger = new Tab(triggerEl)

                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
                })
            })
        },
        async guardar() {
            try{
                let respuestas=[];
                let puntaje_etapa = [];

                this.etapas.forEach(x=>{

                    let puntaje = x.preguntas.reduce((t,c) => {
                        let opcion = c.opciones.find(opc=>opc.opcion===c.respuesta);
                        return Number(t) + Number(opcion!==undefined?opcion.puntaje:0);
                    },0);

                    puntaje_etapa.push({
                        id_etapa: x.id,
                        puntaje : puntaje
                    });

                    let respuestas_etapas=x.preguntas.map(y=>{
                        let opcion = y.opciones.find(opc=>opc.opcion===y.respuesta);
                        return {
                            id_pregunta:y.id,
                            respuesta:y.respuesta,
                            puntaje:opcion!==undefined?opcion.puntaje:'',
                        }
                    })

                    respuestas.push(...respuestas_etapas);
                });


                let respuestas_usuario={
                    id_formulario:this.idFormulario,
                    puntaje_etapa: puntaje_etapa,
                    respuestas:respuestas
                }

                console.log(respuestas_usuario);
        
                this.$store.dispatch('showSpinner');
                await respuestasUsuarioService.store(respuestas_usuario); 
                this.$store.dispatch('hideSpinner');
                Swal.fire('Datos guardados con exito','', 'success');
                this.$router.push({name:'formularios'});
            }catch (e) {
                console.error(e);
                this.$store.dispatch('hideSpinner');
                Swal.fire({
                    icon : "error",
                    title : 'Ups!',
                    text : 'Ha ocurrido un error al procesar la solicitud, verifique que no existan campos vacios'
                });
            }  
        },  
        siguiente(){
            this.actual+=1;
            let tab = document.querySelector(`#${this.tabs[this.actual]}`);
            Tab.getInstance(tab).show();
        } ,
        atras(){
            this.actual-=1;
            let tab = document.querySelector(`#${this.tabs[this.actual]}`);
            Tab.getInstance(tab).show();
        },
        async formularioRealizado(){
            const response = await respuestasUsuarioService.showByIdFormulario(this.idFormulario);
            this.formulario_lleno = response.data;
        },
        async cargarFormulario(){
            const response = await formularioService.show(this.idFormulario);
            this.formulario=response.data;
        },   
    },
    
    async created(){
        this.idFormulario=this.$route.params.id;
         this.cargarEtapas();
        this.id_usuario=this.user.id;
         this.formularioRealizado();
         this.cargarFormulario();
        
    },
    computed : {
        ...mapState(['is_logged', 'user']),

        tabs : function (){
            return this.etapas.map(x=>{
                return `nav_${x.id}`
            })
        }
        
    }
}
</script>
