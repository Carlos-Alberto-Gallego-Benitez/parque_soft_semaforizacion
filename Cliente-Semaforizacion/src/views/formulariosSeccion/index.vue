<template>
    <main>
        <section id="about" class="about">
            <div class="container-fluid">
                <div class="card border-success">
                    <div class="card-header bg-light text-orange">
                        Formularios
                    </div>
                    <div class="card-body">
                        <div class="row content">
                            <div class="col-md-4" data-aos="fade-right">
                                <img src="../../assets/img/dashboard/formulario.png" class="img-fluid" alt="">
                            </div>
                            <div class="col-md-8 pt-4" data-aos="fade-left">
                                <div class="card border-warning">
                                    <div class="card-body">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr class="table-success">
                                                    <th>Nombre Formulario</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in formulario_s" :key="item.id">
                                                    <td>{{item.formulario.nombre}}</td>
                                                    <td>
                                                        <router-link  
                                                            :to="{ name: 's.resultados.formularios.empresa', params: { 'id_formulario': item.id_formulario ,'id_user':this.idUsuario} }"
                                                                class="btn btn-warning mx-2"
                                                                >
                                                            <i class="fas fa-eye fa-fw"></i>  Ver resultado 
                                                        </router-link>
                                                        <router-link  
                                                            :to="{ name: 'formularios.empresa.s', params: { 'id': item.id_formulario } }"
                                                                class="btn btn-success "
                                                                >
                                                            <i class="fas fa-plus fa-fw"></i>  Resolver 
                                                        </router-link>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
import {mapState} from "vuex";
import empresaService from '../../services/empresaService';
//import {isEmpty} from 'lodash';
import sFormularioSectorEmpresaService from '../../services/sFormularioSectorEmpresaService';
export default {
    data(){
        return{
            idUsuario:'',
            idSector:'',
            etapas:[],
            actual:0,
            empresa:[],
            formulario_s:{}
        }
    },
    methods: {   
        async cargarEmpresa(){
            const response = await empresaService.showByIdUser(this.idUsuario);
            this.empresa = response.data;
            this.idSector = response.data.id_sector;
        },
        async cargarFormularioSectorEmpresa(){
            const response = await sFormularioSectorEmpresaService.showByIdSector(this.idSector);
            this.formulario_s = response.data;
        },
            
    },
   
    async created(){
        this.idUsuario=this.user.id;
        await this.cargarEmpresa();
        
        this.cargarFormularioSectorEmpresa();
    },
    computed : {
        ...mapState(['is_logged', 'user']),
        
    }
}
</script>
