<template>
    <div class="root">
        <b-row>
            <b-col>
                <b-form-group label="You want to Choose or Create Random?">
                    <b-form-radio-group v-model="selected">
                        <b-form-radio :value="true">Choose the Question</b-form-radio>
                        <b-form-radio :value="false">Random</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
            </b-col>
            <b-col align="right">
                <b-button v-on:click="createExam">create</b-button>
            </b-col>
        </b-row>
        <hr>
        <section v-if="selected">
           <listening-test
               :check-question="true"
               @getList="listListening = $event"
           />
            {{ listReading }}
            <list-group-questions
                :check-question="true"
                @getList="listReading = $event"
            />
        </section>
    </div>
</template>

<script>
    import ListGroupQuestions from "../questions/ListGroupQuestions";
    import ListeningTest from "../Listen/ListeningTest";

    export default {
        name: "CreateSynthetic",
        components: {
            ListGroupQuestions,
            ListeningTest
        },
        props: {
            value: {
                type: Boolean
            }
        },
        data() {
            return {
                showModal: false,
                selected: true,
                numberQuestion: 0,
                listReading: [],
                listListening: [],
            }
        },
        mounted() {
            this.showModal = this.value;
        },
        watch: {
            showModal: function (val) {
                if (val === false) {
                    this.$emit('input', val);
                }
            },
            listQuestions: function (val) {
                this.numberQuestion = val.length;
            },
            selected: function () {
                this.listQuestions = [];
            }
        },
        computed: {
            formData: function () {
                return {
                    reading: JSON.stringify(this.listReading),
                    listening: JSON.stringify(this.listListening),
                }
            }
        },
        methods: {
            createExam() {
                console.log('abc')
                axios.post('synthetic/store', this.formData).then(response => {
                    this.showModal = false;
                    this.$emit('created');
                }).catch(err => {
                    const {data} = err.response;
                    if (typeof data.errors === 'object') {
                        $.each(data.errors, (key, value) => {
                            alertify.error(value[0]);
                        });
                    } else {
                        alertify.error(data.message);
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
