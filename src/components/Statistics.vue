<template>
    <NavBar />
    <main>
        <canvas id="chart">

        </canvas>
    </main>
</template>
<style>
    main{
        flex: 1 1 auto;
        display: flex;
        flex-flow:column;
        justify-content: center;
    }
    #chart{
        max-height: 80vh;
    }
</style>
<script lang="ts">
    import NavBar from '@/views/NavBar.vue';
    import { db } from '@/services/dbService';
    import { Chart } from 'chart.js/auto';
import { ChartData } from '@/classes/ChartData';
    export default{
        data(){
            return{
                datas:{
                    name:"Date - Price",
                    ID: "datepriceChart",
                    labels:[] as Array<string>,
                    type:"bar",
                    datasets:[{
                        data:[] as Array<number>,
                        label:"price"
                    }]
                }
            }
        },
        created(){
        },
        mounted(){
            db.GetAll('http://localhost/2-14-SZFT/backend/php/api/api.php', {
                table:'tetelek'
            }).then(result=>{
                this.datas.labels = result.data.map(e=>e.date.toString());
                this.datas.datasets[0].data = result.data.map(e=>e.price==null?0:e.price);
                let chartData = new ChartData(this.datas.name, this.datas.ID, this.datas.type, this.datas.labels, this.datas.datasets);
                new Chart(document.querySelector('#chart') as HTMLCanvasElement, chartData.ChartConfig);
            });
        },
        methods: {
        },
        components:{
            NavBar,
            Chart
        }
    }
</script>