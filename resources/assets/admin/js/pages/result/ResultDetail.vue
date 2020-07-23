<template>
    <div class="root">
        <b-modal v-model="isShow" size="lg">
            <div v-for="(item, index) in answers" :key="index">
                <question-component
                    :question-detail="item"
                    :number-question="index+1"
                    :explain="true"
                ></question-component>
                <hr>
            </div>
            <template v-slot:modal-footer class="text-center">
                <hr>
                <b-button variant="primary" v-on:click="isShow = !isShow">Got it</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import QuestionComponent from "./QuestionComponent";
    export default {
        name: "ResultDetail",
        components: {
            QuestionComponent
        },
        props: ['answers'],
        data() {
            return {
                isShow: false,
            }
        },
        mounted() {
            this.isShow = true;
        },
        watch: {
            isShow: function (val) {
                if (val == false) {
                    this.$emit('closeModal', val)
                }
            }
        }
    }
</script>

<style scoped>

</style>
