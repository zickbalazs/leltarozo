<template>
    <NavBar />
    <main class="d-flex flex-column align-items-center justify-content-center">
        <div class="col-lg-10 col-11">
            <h2 class="mb-5">Üdv!</h2>
            <div class="row">
                <DashCard v-for="card in DashCardItems" :card-data="card" />
            </div>
        </div>
    </main>
</template>
<style>

</style>
<script lang="ts">
import NavBar from '@/views/NavBar.vue';
import DashCard from './DashCard.vue';
import { DashCardItem } from '../classes/DashCardItem';
import { InventoryItem } from '../classes/InventoryItem';
import axios from 'axios';
export default {
    data() {
        return {
            DashCardItems: [
                new DashCardItem("Új tétel felvétele", "plus", ["#00a62c", "#005416"]),
                new DashCardItem("Tételek megtekintése", "eye", ["#00a62c", "#005416"]),
                new DashCardItem("Tételek szerkesztése", "wrench", ["#00a62c", "#005416"]),
                new DashCardItem("Tételek törlése", "trash2", ["#00a62c", "#005416"]),
            ],
            Inventory: []
        }
    },
    created() {
        axios.get('http://localhost/2-14-SZFT/Backend/PhP/api/database.php', {
            params: {
                "table": "tetelek"
            },
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(res => {
            this.Inventory = res.data;
            console.log(res.data);
        }).catch(err => {
            console.log(err.data);
        })
    },
    components: { NavBar, DashCard },
}
</script>