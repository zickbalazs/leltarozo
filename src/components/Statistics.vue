<template>
    <NavBar />
    <main>
    </main>
</template>
<style>
</style>
<script lang="ts">
    import NavBar from '@/views/NavBar.vue';
    import Chart from '@/views/Chart.vue';
    import { db } from '@/services/dbService';
    import type { AxiosResponse } from 'axios';
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
        methods: {
            GetDataForChart():AxiosResponse<Array<number>>{
                return db.GetAll('http://localhost/2-14-SZFT')
            }
        },
        components:{
            NavBar,
            Chart
        }
    }
</script>