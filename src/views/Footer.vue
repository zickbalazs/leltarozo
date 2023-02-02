<template>
    <footer>{{ dev }} - {{ year }}</footer>
</template>
<style>
footer {
    text-align: center;
    background-color: var(--bs-dark);
    color: var(--bs-light);
}

</style>
<script lang="ts">
export default {
    data() {
        return {
            dev: 'ZB',
            year: new Date().getFullYear()
        }
    }
}
</script>