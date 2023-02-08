<template>
    <main>
         <section id="about" class="about">
        <div class="container-fluid">
        <h3 class="app-page-title"> Resultado</h3>
        <h3 class="app-page-title"> Formulario: {{formulario.nombre}}</h3>
        <div class="col-lg-12 col-md-12 col-sm-12 bg-light">
            <canvas id="grafico" width="700" ></canvas>
            <table class="table table-bordered">
                <thead>
                    <tr >
                        <td class="table-info">Promedio: {{promedio}}</td>
                        <td v-if="promedio>0 && promedio<=1.25" class="table-danger">INNOVACION REACTIVA</td>
                        <td v-if="promedio>1.25 && promedio<=2.5" class="table-warning">INNOVACION ESTRATEGICA</td>
                        <td v-if="promedio>2.5 && promedio<=3.75" class="table-primary">INNOVACION SOSTENIBLE</td>
                        <td v-if="promedio>3.75 && promedio<=5" class="table-success">INNOVACION DE VANGUARDIA</td>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col" v-for="det in respuestas_usuario.detalles_etapas" :key="det.id">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="text-danger">{{det.etapa.nombre}}</h5>
                        <h6 >Puntaje Obtenido: {{det.puntaje_total}} puntos, de {{det.etapa.puntaje_maximo}} posibles</h6>
                         <h6 >Total de preguntas: {{det.etapa.numero_preguntas}} </h6>
                        <h6> Promedio : {{decimal((det.puntaje_total)/det.etapa.numero_preguntas)}}</h6>

                       <!--  <h5 class="text-danger">{{det.etapa.nombre}}</h5>
                        <h6 >Puntaje Obtenido: {{det.puntaje_total}} puntos, de {{det.etapa.puntaje_maximo}} posibles</h6>
                        
                        <h6> Porcentaje: {{(det.puntaje_total*100)/det.etapa.puntaje_maximo}}%</h6>
                        
                        <div class="progress mt-2"  v-if="((det.puntaje_total*100)/det.etapa.puntaje_maximo)<=30">
                            <div class="progress-bar bg-danger" role="progressbar" :style="`width :${(det.puntaje_total*100)/det.etapa.puntaje_maximo}%`" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="progress mt-2"  v-if="((det.puntaje_total*100)/det.etapa.puntaje_maximo)>30 && ((det.puntaje_total*100)/det.etapa.puntaje_maximo)<60">
                            <div class="progress-bar bg-warning" role="progressbar" :style="`width :${(det.puntaje_total*100)/det.etapa.puntaje_maximo}%`" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="progress mt-2"  v-if="((det.puntaje_total*100)/det.etapa.puntaje_maximo)>=60">
                            <div class="progress-bar bg-success" role="progressbar" :style="`width :${(det.puntaje_total*100)/det.etapa.puntaje_maximo}%`" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <div class="mt-2" v-for="etapa in respuestas_usuario.detalles_etapas" :key="etapa.id_etapa">
                    <h6 class="text-success">{{etapa.etapa.nombre}}</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Pregunta</th>
                                <th>Respuesta</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr v-for="det in etapa.detalles" :key="det.id">
                            <td>{{det.pregunta.nombre}}</td>
                            <td>{{det.respuesta}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
         </section>
    </main>
</template>
<script>
import respuestasUsuarioService from '../../services/respuestasUsuarioService';
import formularioService from '../../services/formularioService';

import Chart from 'chart.js/auto';
export default {
    data(){
        return{
            id_usuario:'',
            id_formulario:'',
            respuestas_usuario:[],
            formulario:{},
            promedio:''
        }
    },
    methods: {
        async cargarRespuestas(){
            const response = await respuestasUsuarioService.showByIdUser(this.id_usuario,this.id_formulario);
            this.respuestas_usuario=response.data;
            this.respuestas_usuario.detalles_etapas.forEach((e,i) => {
                this.respuestas_usuario.detalles_etapas[i]['detalles'] = 
                this.respuestas_usuario.detalles.filter(x=> parseInt(x.pregunta.etapa.id) === parseInt(e.id_etapa))
            });
        },
        async cargarFormulario(){
            const response = await formularioService.show(this.id_formulario);
            this.formulario=response.data;
        },
        radar(){
            var grafico_radar = document.getElementById('grafico');

            const nombre_formulario=this.formulario.nombre;
            let label=[];
            let promedios=[];

            this.respuestas_usuario.detalles_etapas.forEach((e,i) => {
               label[i]=e.etapa.nombre;
               promedios[i]=e.puntaje_total/e.etapa.numero_preguntas;
            });

            //promedio general de cada empresa en todas sus etapas

            var sumaPromedio=0;
            var prom=0;


            for(var i=0 ;i<promedios.length;i++){
                sumaPromedio=parseFloat(promedios[i])+parseFloat(sumaPromedio);
            }

            prom=sumaPromedio/(promedios.length);
            this.promedio=parseFloat(prom = Number.parseFloat(prom).toFixed(2));


            new Chart(grafico_radar, {
                type: 'radar',
                data:  {
                    labels:label,
                    datasets: [{
                        label: nombre_formulario,
                        data:promedios,
                        fill: false,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgb(255, 99, 132)',
                        pointBackgroundColor: 'rgb(255, 99, 132)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(255, 99, 132)'
                    }],
                },
                options: {
                    elements: {
                        line: {
                            borderWidth: 2
                        }
                    }
                }
            });
            
        },
        decimal(value){
            return Number.parseFloat(value).toFixed(2);
        }
        
    },
    async created(){
        this.id_formulario=this.$route.params.id_formulario;
        this.id_usuario=this.$route.params.id_user;
        await this.cargarRespuestas();
        await this.cargarFormulario();
        this.$nextTick(() => this.radar());
    }
}
</script>
