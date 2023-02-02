<template>
    <div class="col-lg-6 col-12">
        <div class="dashboard-card p-2 mb-3" :style="`--fromcolor: ${gradient[0]}; --tocolor: ${gradient[1]}`">
            <h3 class="fs-1">{{ title }}</h3>
            <i :class="`bi bi-${icon} display-1`"></i>
        </div>
    </div>
</template>
<style>
    .dashboard-card{
        display:flex;
        height: 200px;
        width: 100%;
        cursor:pointer;
        background: linear-gradient(160deg, var(--fromcolor), var(--tocolor));
        justify-content: space-between;
        color:white;
        border-radius:0.5rem;
    }
    .dashboard-card>h3{
        align-self: flex-start;
    }
    .dashboard-card>i{
        align-self: flex-end;
    }
</style>
<script lang="ts">
export default {
    props: [
        "cardData"
    ],
    data() {
        return {
            title: this.cardData.title,
            icon: this.cardData.icon,
            gradient: this.cardData.gradient
        }
    },
    methods: {

    }
}
</script>