<template>
    <main>
        <h1 class="app-page-title"><img alt="logo"  src="../../../assets/images/img-modulos/formulario.png" width="32"> Listado de Formularios</h1>
        <div class="card">
            <div class="card-body">
                <table  class="table table-striped table-bordered " id="datatable" style="width:100%">
                    <thead><br>
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
                                        class="btn app-btn-primary "
                                        >
                                    <i class="fas fa-eye fa-fw"></i>  Ver resultado 
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>        
    </main>
</template>
<script>
import {mapState} from "vuex";
import empresaService from '../../../services/empresaService';
import sFormularioSectorEmpresaService from '../../../services/sFormularioSectorEmpresaService';
import 'jquery/dist/jquery.min.js';
import "datatables.net-dt/js/dataTables.dataTables"
import "datatables.net-dt/css/jquery.dataTables.min.css"
import $ from 'jquery'; 
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
        this.idUsuario=this.$route.params.id;
        await this.cargarEmpresa();
        await this.cargarFormularioSectorEmpresa();
        this.datatable();
    },
    computed : {
        ...mapState(['is_logged', 'user']),
        
    }
}
</script>
