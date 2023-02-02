<template>
    <header class="bg-primary bg-gradient">
        <h1>{{title}}</h1>
    </header>
    <main class="d-flex justify-content-center align-items-center">
        <router-link to="/dash"><button id="Gya" class="btn-lg btn btn-outline-success">Kezdés <i class="bi bi-arrow-right"></i></button></router-link>
    </main>
</template>
<style>
header{
    min-height: 50vh;
    display:flex;
    justify-content: center;
    align-items: center;
    color: var(--bs-light);
}
main{
    flex: 1 1 auto;
}
#Gya{
    border-radius: 0;
    border-width: 0.2rem;
    font-weight: bold;
    transition:border-radius 0.2s, background-color 0.2s
}
#Gya:hover{
    border-radius: var(--bs-border-radius);
}
</style>
<script lang="ts">
export default{
    data(){
        return{
            title: "Leltározó"
        }
    }
}
</script>