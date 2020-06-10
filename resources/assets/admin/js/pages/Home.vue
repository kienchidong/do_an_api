<template>
    <div class="root">
        <h1>Home</h1>
        <b-button v-b-modal.modal-1>Launch demo modal</b-button>

        <b-modal id="modal-1" title="BootstrapVue">
            <p class="my-4">Hello from modal!</p>
        </b-modal>
    </div>
</template>
<script>
    export default {
        name: "Home",
        created() {
            console.log(this.$route);
        }
    }
</script>

<style scoped>

</style>
