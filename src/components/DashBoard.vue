<template>
    <NavBar />
    <main class="d-flex flex-column align-items-center justify-content-center">
        <div class="col-lg-10 col-11">
            <h2 class="mt-3">Üdv!</h2>
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
import DashCard from '@/components/DashCard.vue';
import { DashCardItem } from '@/classes/DashCardItem';
export default {
    data() {
        return {
            DashCardItems: [
                new DashCardItem("Új tétel felvétele", "plus-lg", ["#00A62C", "#005416"]),
                new DashCardItem("Tételek megtekintése", "eye", ["#85E0D4", "#C7AABE"]),
                new DashCardItem("Tételek szerkesztése", "wrench", ["#FFBF7A", "#8C894C"]),
                new DashCardItem("Tételek törlése", "trash2", ["#C11E38", "#220B34"]),
            ],
        }
    },
    components: { NavBar, DashCard }
}
</script>