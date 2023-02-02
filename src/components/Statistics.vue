<template>
    <NavBar />
    <main>
        <Chart />
    </main>
</template>
<style>
</style>
<script lang="ts">
    import NavBar from '@/views/NavBar.vue';
    import Chart from '@/views/Chart.vue';
    export default{
        data(){
            return{
                data:{
                    asd:"asd"
                }
            }
        },
        methods: {

        },
        components:{
            NavBar,
            Chart
        }
    }
</script>