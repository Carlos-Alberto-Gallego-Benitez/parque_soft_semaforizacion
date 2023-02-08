<template>
    <main>
        <section id="about" class="about">
            <div class="container-fluid">
                <div class="card ">
                    <div class="card-header bg-light text-success">
                        Perfil de la Empresa 
                    </div>
                    <div class="card-body">
                        <div class="row content">
                            <div class="col-md-4" data-aos="fade-right">
                                <img src="../../assets/img/dashboard/perfil1.png" class="img-fluid" alt="">
                            </div>
                            <div class="col-md-8 pt-4" data-aos="fade-left">
                                <form class="row g-3">
                                    <div class="card-header text-orange">Datos de la Empresa</div>
                                    <div class="col-md-6">
                                        <label class="form-label">Sector <span class="text-danger">(*)</span> </label>
                                        <select  v-model="id_sector"    class="form-control"  >
                                            <option :value="sector.id" v-for="sector in sectores" :key="sector.id">
                                                {{ sector.nombre }}
                                            </option >
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Cantidad de trabajadores <span class="text-danger">(*)</span> </label>
                                        <select  v-model="id_cantidad_trabajadores"    class="form-control"  >
                                            <option :value="item.id" v-for="item in cant_trabajadores" :key="item.id">
                                                {{ item.descripcion }}
                                            </option >
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label  class="form-label">Nombre de la Empresa <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control" v-model="nombre_empresa">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nit <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control" v-model="nit" >
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Dirección <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control" v-model="direccion">
                                    </div>
                                    <div class="col-6">
                                        <label  class="form-label">Telefono <span class="text-danger">(*)</span></label>
                                        <input type="number" class="form-control" v-model="telefono">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Email <span class="text-danger">(*)</span></label>
                                        <input type="email" class="form-control" v-model="email" required>
                                    </div>
                                    <div class="card-header text-orange">Datos del Representante legal</div>
                                    <div class="col-md-12">
                                        <label  class="form-label">Nombre Completo <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control" v-model="nombre_representante">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">CC <span class="text-danger">(*)</span></label>
                                        <input type="number" class="form-control" v-model="cc">
                                    </div>
                                     <div class="col-12">
                                    <button type="button" @click="guardar();" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Guardar</button>
                                </div>
                                </form>
                               
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
import sectorEmpresaService from '../../services/sectorEmpresaService';
import empresaService from '../../services/empresaService';
import {isEmpty} from 'lodash';
import cantidadTrabajadoresService from '../../services/cantidadTrabajadoresService';
import {useVuelidate} from '@vuelidate/core';
import {required} from '@vuelidate/validators';
export default {
    data(){
        return{
            v$:useVuelidate(),
            id_empresa:'',
            id_usuario:'',
            id_sector:'', 
            id_cantidad_trabajadores:'',
            nombre_empresa:'',
            nit:'',
            direccion:'',
            telefono:'',
            email:'',
            nombre_representante:'',
            cc:'',  
            sectores:{},    
            cant_trabajadores:{},    
        }
    },
     validations(){
        return{
            id_sector:{required},
            id_cantidad_trabajadores:{required},
            nombre_empresa:{required},
            nit:{required},
            direccion:{required},
            telefono:{required},
            email:{required},
            nombre_representante:{required},
            cc:{required},
        }
    },
    methods: {   
        async cargarSectores(){
            const response = await sectorEmpresaService.index();
            this.sectores=response.data;
        },
        async cargarCantTrabajadores(){
            const response = await cantidadTrabajadoresService.index();
            this.cant_trabajadores=response.data;
        },
        async guardar(){ 
            try{
                this.v$.$validate();

                if(this.v$.$error){
                    Swal.fire('Hay campos vacios','', 'error');
                }else{ 
                    let empresa={
                        id_sector:this.id_sector,
                        nombre_empresa:this.nombre_empresa,
                        nit:this.nit,
                        direccion:this.direccion,
                        telefono:this.telefono,
                        email:this.email,
                        nombre_representante:this.nombre_representante,
                        cc:this.cc,
                        id_cantidad_trabajadores:this.id_cantidad_trabajadores,
                    }

                    this.$store.dispatch('showSpinner');
                    if(this.id_empresa!==''){
                        empresa.id=this.id_empresa;
                        await empresaService.update(empresa);
                    }else{
                        await empresaService.store(empresa);
                    }
                    this.$store.dispatch('hideSpinner');
                    Swal.fire('Datos guardados con exito','', 'success');
                }
            }catch (e) {
                console.error(e);
                Swal.fire({
                    icon : "error",
                    title : 'Ups!',
                    text : 'Ha ocurrido un error al procesar la solicitud'
                });
            }              
        },       
    },
    async created(){
        this.cargarSectores();
        this.cargarCantTrabajadores();
        this.id_usuario=this.user.id;
        this.$store.dispatch('showSpinner');
        const response=await empresaService.showByIdUser(this.user.id);
        this.$store.dispatch('hideSpinner');
        if(!isEmpty(response.data)){
            this.id_sector=response.data.id_sector;
            this.nombre_empresa=response.data.nombre;
            this.id_empresa=response.data.id;
            this.nit=response.data.nit;
            this.direccion=response.data.direccion;
            this.telefono=response.data.telefono;
            this.email=response.data.email;
            this.nombre_representante=response.data.representante;
            this.cc=response.data.cc_representante;
            this.id_cantidad_trabajadores=response.data.id_cantidad_trabajadores;

        }
    },
     computed : mapState(['is_logged', 'user'])
}
</script>
