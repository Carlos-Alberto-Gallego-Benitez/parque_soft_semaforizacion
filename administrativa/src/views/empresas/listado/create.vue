<template>
    <main>
        <h1 class="app-page-title"><img alt="logo"  src="../../../assets/images/img-modulos/formulario.png" width="32"> Listado de Empresas</h1>
        <div class="card">
            <div class="card-body">
                <div class="col-12 alert alert-warning" v-if="!empresas.length"><i class="fa fa-exclamation-circle fa -fw"></i> No se han creado formularios...</div>
                <div class="table-responsive" v-else>
                    <table class="table table-striped table-bordered " id="datatable" style="width:100%">
                        <thead><br>
                           <tr class="table-success">
                                <th>Nombre Empresa</th>
                                <th>Nit</th>
                                <th>Representante legal</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in empresas" :key="item.id">
                                <td>{{item.nombre}}</td>
                               <td>{{item.nit}}</td>
                               <td>{{item.representante}}</td>
                                <td >
                                    <div class="row g-3">
                                        <div class="col-auto">
                                            <router-link  
                                                :to="{ name: 'empresas.formularios', params: { 'id': item.id_usuario } }"
                                                class="btn app-btn-primary "
                                                >
                                                <i class="fas fa-eye fa-fw"></i>  Formularios 
                                            </router-link>
                                        </div>
                                    </div>
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
import empresaService from '../../../services/empresaService';
import 'jquery/dist/jquery.min.js';
import "datatables.net-dt/js/dataTables.dataTables"
import "datatables.net-dt/css/jquery.dataTables.min.css"
import $ from 'jquery'; 
export default {
    data(){
        return{
            empresas:[],
        }
    },
    methods: {
        async cargarEmpresas(){
            const res = await empresaService.index();
            this.empresas=res.data;
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
    async  created(){
        await this.cargarEmpresas();
        this.datatable();
    }
}
</script>
