<template>
  <main>
      <div class="row" v-if="promedio_g.detalles_etapas.length">
        <div class="col-md-6 col-lg-6 col-sm-8 offset-sm-2 offset-md-0 col-xs-12" >
            <div class="card" >
                <div class="card-body">
                        <graficoGeneral :formulario="formulario.nombre" :dataGrafica="promedio_g" idChart="general" key="general"
                        ></graficoGeneral>
                </div>
            </div>
        </div>
        </div>
      <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-8 offset-sm-2 offset-md-0 col-xs-12" v-for="item in respuestas" :key="item.id">
            <div class="card" >
                <div class="card-body" >
                        <graficoGeneral :formulario="formulario.nombre" :dataGrafica="item" :idChart="item.id_usuario" 
                        ></graficoGeneral>
                </div>
            </div>
        </div>
        </div>
  </main>
</template>
<script>
import sFormularioService from '../../services/sFormularioService';
import sRespuestasUsuarioService from '../../services/sRespuestasUsuarioService';
import graficoGeneral from './graficoGeneral';
export default {
    components: {graficoGeneral},
    data(){
        return{
            formulario: {},
            idFormulario:'',
            respuestas:[],
            promedio_g: {
                detalles_etapas:[],
            },
        }
    },
    methods:{
        async cargarFormulario(){
            const response = await sFormularioService.show(this.idFormulario);
            this.formulario=response.data;
        },
        async cargarRespuestas(){
            const response = await sRespuestasUsuarioService.showByIdForm(this.idFormulario);
          
           
            /* let promedio_general={};

            response.data.forEach((e,i) => {
                if(i===0){
                    promedio_general={...e};
                }else{
                    promedio_general.detalles_etapas.forEach((x,y) => {
                        let index = e.detalles_etapas.findIndex(q=>q.etapa.id===x.etapa.id);
                        promedio_general.detalles_etapas[y].puntaje_total=e.detalles_etapas[index].puntaje_total+promedio_general.detalles_etapas[y].puntaje_total;
                    });
                    console.log('ppp')
                }
    console.log(i);
            });

            promedio_general.detalles_etapas.forEach((e,i) => {
                promedio_general.detalles_etapas[i].puntaje_total=promedio_general.detalles_etapas[i].puntaje_total/response.data.length;
            }) 

                console.log(response.data);
                this.promedio_g=promedio_general; */
            this.respuestas=response.data;
        },
    },
   async  created () {
        this.idFormulario=this.$route.params.id;
        await this.cargarFormulario();
        await this.cargarRespuestas();
    }
}
</script>

