<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Leltározó</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item" v-for="link in links">
                        <router-link class="nav-link" :to="link.path">{{ link.name }}</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<style>
</style>
<script lang="ts">
    import router from '../router/index'
    export default {
        data(){
            return {
                links: router.getRoutes()
            }
        },
        created(){
            this.links.shift();
        }
    }
</script>