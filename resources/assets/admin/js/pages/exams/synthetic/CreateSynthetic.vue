<template>
    <div class="root">
        <b-modal v-model="showModal" hide-footer size="lg" title="Create Simple Test">
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
            <b-form-group
                label="Level:"
            >
                <b-form-select v-model="level" :options="options"></b-form-select>
            </b-form-group>
           <listening-test
               :check-question="true"
               @getList="listListening = $event"
           />
            <list-group-questions
                :check-question="true"
                @getList="listReading = $event"
            />
        </section>
        </b-modal>
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
                level: null,
                options: [
                    { value: null, text: 'Please select level' },
                    { value: 1, text: 'Beginner(0-250)' },
                    { value: 2, text: 'High Beginner(255-400)' },
                    { value: 3, text: 'Low Intermediate(405-600)' },
                    { value: 4, text: 'Intermediate(605-700)' },
                    { value: 5, text: 'High Intermediate(705-780)' },
                    { value: 6, text: 'Low Advanced(785-900)' },
                    { value: 7, text: 'Advanced(905-990)' },
                ]
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
                    level: this.level,
                    number_question: this.listReading.length + this.listListening.length,
                }
            }
        },
        methods: {
            createExam() {
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
