<template>
    <main>
        <h1 class="app-page-title">Configuración de Sectores</h1>
        <h1 class="app-page-title">Formulario: <span class="text-orange">{{formulario.nombre}}</span></h1>
        <div class="card">
            <div class="card-body">
                <div class="col-12 d-flex justify-content-end py-4"> 
                    <button @click="modificar=false; abrirModal();" type="button" class="btn app-btn-primary ">
                        Agregar Sector&nbsp;<i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="modal fade" id="modalSectorFormulario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <label class="form-label">Sector</label>
                                        <select  v-model="id_sector"    class="form-control"  >
                                            <option :value="sector.id" v-for="sector in sectores" :key="sector.id">
                                                {{ sector.nombre }}
                                            </option >
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
                <div class="col-12 alert alert-warning" v-if="!formulario_sector.length"><i class="fa fa-exclamation-circle fa -fw"></i> No se han agregado sectores a este formulario...</div>
                <div  v-else>
                            
                            <table class="table  table-bordered" >
                                <thead>
                                    <tr class="table-success">
                                        <th>Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in formulario_sector" :key="item.id">
                                        <td>{{item.sector.nombre}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            
    </main>
</template>
<script>

import {Modal} from 'bootstrap';
import Swal from 'sweetalert2';
import sFormularioSectorEmpresaService from '../../../services/sFormularioSectorEmpresaService';
import sectorEmpresaService from '../../../services/sectorEmpresaService';
import sFormularioService from '../../../services/sFormularioService';
import useVuelidate from '@vuelidate/core';
import {required} from '@vuelidate/validators';

export default {
    data(){
        return{
             v$:useVuelidate(),
            modificar:true,
            tituloModal:'',   
            idFormulario:'',
            id_sector:'', 
            formulario_sector:{},  
            sectores:{}, 
            formulario:{}   
        }
    },
    validations(){
        return{
            id_sector:{required},
        }
    },
    methods: {
        async abrirModal(){
            this.modalShow();
            this.tituloModal="Agregar Sector";
            this.id_sector='';
        },
        
        async cargarSectoresFormulario(){
            const response = await sFormularioSectorEmpresaService.showByIdFormulario(this.idFormulario);
            this.formulario_sector = response.data;
        },
        async cargarSectores(){
            const response = await sectorEmpresaService.index();
            this.sectores=response.data;
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
                let formulario={
                    id_sector:this.id_sector,
                    id_formulario:this.idFormulario,
                }
                
                await sFormularioSectorEmpresaService.store(formulario);
                //this.modalHide();
                Swal.fire('Datos guardados con exito','', 'success');
                this.idFormulario=this.$route.params.id;
                this.cargarSectoresFormulario();
            }
        
        },
        modalShow(){
            var myModal = new Modal(document.getElementById('modalSectorFormulario'));
            myModal.show();
        },
        modalHide(){
           let myModal = document.getElementById('modalSectorFormulario');
            let m = Modal.getInstance(myModal)
            m.hide();
        }
       
    },
    async created(){
        this.idFormulario=this.$route.params.id;
       this.cargarSectores();
       this.cargarSectoresFormulario();
       this.cargarFormulario();
    }
}
</script>
