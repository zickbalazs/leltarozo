<template>
    <div class="container-fluid px-0" id="mainSite">
        
        <RouterView/>
        <Footer />
    </div>
</template>
<script lang="ts">
import { RouterView } from 'vue-router';
import Footer from '@/views/Footer.vue';
export default{
    data(){
        return{}
    },
    components:{
        Footer,
    }
}
</script>
<style>
#mainSite{
    display:flex;
    min-height: 100vh;
    flex-flow: column;
}
</style>