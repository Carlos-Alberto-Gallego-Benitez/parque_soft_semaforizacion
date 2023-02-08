<template>
    <main>   
        <h5 class="text-orange text-center">{{this.dataGrafica.usuario.empresa.nombre}}</h5>  
        <hr> 
        <canvas :id="idChart" width="500" height="500"></canvas>
        <table class="table table-bordered">
            
            <thead>
                <tr>
                    <td class="table-info">Promedio: {{promedio}}</td>
                    <td v-if="promedio>0 && promedio<=1.95" class="table-danger">NIVEL : BAJO</td>
                    <td v-if="promedio>1.95 && promedio<=2.95" class="table-secondary">NIVEL : BAJO-MEDIO</td>
                    <td v-if="promedio>2.95 && promedio<=3.95" class="table-warning">NIVEL : MEDIO</td>
                    <td v-if="promedio>3.95 && promedio<=4.95" class="table-info">NIVEL : ALTO-MEDIO</td>
                    <td v-if="promedio>4.95 && promedio<=5" class="table-success">NIVEL : ALTO</td>
                </tr>
            </thead>
        </table>
    </main>
</template>
<script>

import Chart from 'chart.js/auto';
export default {
    props:['idChart','dataGrafica','formulario'],
    data(){
        return {
            secciones:{},
            promedio:{},
        }
    },
    methods: {
        radar(){
            var grafico_radar = document.getElementById(this.idChart);
    
            //const nombre_formulario=this.formulario;

            //let empresas=[];
            let label=[];
            let promedios=[];
            let nivel_deseado=[];

            this.dataGrafica.detalles_secciones.forEach((e,i) => {
               label[i]=e.seccion.nombre;
               nivel_deseado[i]=e.seccion.nivel_deseado;
               promedios[i]=e.puntaje_total/e.seccion.numero_preguntas;
            });
            
            //promedio general de cada empresa en todas sus secciones

            var sumaPromedio=0;
            var prom=0;

            for(var i=0 ;i<promedios.length;i++){
                sumaPromedio=parseFloat(promedios[i])+parseFloat(sumaPromedio);
            }

            prom=sumaPromedio/(promedios.length);
            this.promedio=parseFloat(prom = prom.toFixed(2));
            
            console.log(this.promedio);
            //fin de calculo de promedio general de cada empresa en todas sus secciones

            new Chart(grafico_radar, {
                type: 'radar',
                data:  {
                    labels:label,
                    datasets: [
                        // {label: this.dataGrafica.usuario.empresa.nombre},
                        {
                            label: 'Nivel Actual',
                            data:promedios,
                            fill: false,
                            backgroundColor: 'rgba(255, 128, 0, 0.2)',
                            borderColor: 'rgb(255, 128, 0)',
                            pointBackgroundColor: 'rgb(255, 128, 0)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgb(255, 128, 0)',
                            
                        },
                        {
                            label: 'Nivel Deseado',
                            data:nivel_deseado,
                            fill: false,
                            backgroundColor: 'rgba(26, 168, 0, 0.2)',
                            borderColor: 'rgb(26, 168, 0)',
                            pointBackgroundColor: 'rgb(26, 168, 0)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgb(26, 168, 0)',
                            
                        }
                    ],
                },
                options: {
                    elements: {
                        line: {
                            borderWidth: 3
                        }
                    }
                }
            });
            
            
        },
    },
    watch:{
        idChart:function(){
            this.$nextTick(() => this.radar());
        }
    },
    async created(){
       await this.$nextTick(() => this.radar());
    }

}
</script>

