<template>
    <div class="root">
        <b-modal v-model="isShow" size="lg">
            <section>
                <h4 v-if="answers.name">{{ answers.name }}</h4>
                <p v-if="answers.describe" v-html="answers.describe"></p>
                <audio controls v-if="answers.audio">
                    <source :src="answers.audio" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            </section>
            <div v-for="(item, index) in answers.detail" :key="index">
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
