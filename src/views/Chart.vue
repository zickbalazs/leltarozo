<template>
    <canvas :id="chart1.chartId"></canvas>
</template>
<script lang="ts">
import { ChartData } from '@/classes/ChartData';
import  Chart  from 'chart.js/auto';
export default {
    data(){
        return{
            chart1: new ChartData("Example", "exampleid", "bar", ["1"], [{
                labels: ['1', '2', '3'],
                data:[1, 2, 3],
                backgroundColors: ['red', 'blue', 'green']
            }])
        }
    },
    mounted(){
        const ctx:HTMLCanvasElement = document.getElementById(this.chart1.chartId) as HTMLCanvasElement;
        new Chart(ctx, this.chart1.ChartConfig);
    }
}
</script>