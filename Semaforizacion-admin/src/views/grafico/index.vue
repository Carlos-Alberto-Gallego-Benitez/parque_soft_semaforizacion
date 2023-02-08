<template>
    <main>
        <h1 class="app-page-title"><img alt="logo"  src="../../assets/images/img-modulos/formulario.png" width="32"> Listado de Formularios</h1>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered " id="datatable" style="width:100%">
                    <thead><br>
                        <tr class="table-success">
                            <th>Nombre Formulario</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in formularios" :key="item.id">
                            <td>{{item.nombre}}</td>
                            <td>
                                <router-link  
                                    :to="{ name: 'grafico.general.formulario', params: { 'id': item.id} }"
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
//import {isEmpty} from 'lodash';
import sFormularioService from '../../services/sFormularioService';
import 'jquery/dist/jquery.min.js';
import "datatables.net-dt/js/dataTables.dataTables"
import "datatables.net-dt/css/jquery.dataTables.min.css"
import $ from 'jquery'; 
export default {
    data(){
        return{
            formularios:{}
        }
    },
    methods: {   
        async cargarFormulario(){
            const response = await sFormularioService.index();
            this.formularios = response.data;
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
       await  this.cargarFormulario();
       this.datatable();
    },
    computed : {
        ...mapState(['is_logged', 'user']),
        
    }
}
</script>
