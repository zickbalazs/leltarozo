<template>
    <div id="chart">
        <canvas :id="chartdt.chartId"></canvas>
        <button @click="update">refresh</button>
    </div>
</template>
<style>
    canvas{
        max-height: 80vh;
    }
</style>
<script lang="ts">
import { ChartData } from '@/classes/ChartData';
import  Chart  from 'chart.js/auto';
import type { ChartItem } from 'chart.js';
export default {
    props:["data"],
    data(){
        return{
            chartdt: new ChartData(this.data.name, this.data.ID, this.data.type, this.data.labels, this.data.datasets),
            ch:{}
        }
    },
    watch:{
        'chartdt.datasets'(){
            console.log('Bruh')
        }
    },
    methods:{
    },
    mounted(){
        this.ch = new Chart((document.querySelector(`#${this.data.ID}`) as ChartItem), this.chartdt.ChartConfig);
    }
}
</script>