<template>
    <NavBar />
    <main class="d-flex flex-column align-items-center justify-content-center">
        <div class="col-lg-10 col-11">
            <h2 class="mt-3">Üdv!</h2>
            <div class="row">
                <DashCard v-for="card in DashCardItems" :card-data="card.data" :modal-i-d="card.modalID" />
            </div>
        </div>
        <Inventory/>
        <Add/>
    </main>
</template>
<style>

</style>
<script lang="ts">
import NavBar from '@/views/NavBar.vue';
import Inventory from '@/components/Inventory.vue';
import DashCard from '@/components/DashCard.vue';
import Add from '@/views/Add.vue';
import { DashCardItem } from '@/classes/DashCardItem';
export default {
    data() {
        return {
            DashCardItems: [
                {
                    data: new DashCardItem("Új tétel felvétele", "plus-lg", ["#00A62C", "#005416"]),
                    modalID: "addModal"
                },
                {
                    data: new DashCardItem("Tételek megtekintése", "eye", ["#85E0D4", "#C7AABE"]),
                    modalID: "inventoryModal"
                },
            ],
        }
    },
    components: { NavBar, DashCard, Inventory, Add}
}
</script>