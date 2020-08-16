<template>
    <div class="root">
        <b-modal v-model="showModal" hide-footer size="lg" title="Create Simple Test">
            <b-row>
                <b-col>
                    <b-form-group label="You want to Choose or Create Random?">
                        <b-form-radio-group v-model="selected">
                            <b-form-radio :value="false">Random</b-form-radio>
                            <b-form-radio :value="true">Choose the Question</b-form-radio>
                        </b-form-radio-group>
                    </b-form-group>
                </b-col>
                <b-col align="right">
                    <b-button v-on:click="createExam">create</b-button>
                </b-col>
            </b-row>
            <hr>
            <section>
                <b-form-group
                    label="Number Questions:"
                >
                    <b-form-input :readonly="selected" type="number" v-model="numberQuestion"></b-form-input>
                </b-form-group>
                <span v-if="numberQuestion > 0">Time: {{ numberQuestion +' '+ $t('system.mininute') }}</span>
            </section>
            <section v-if="selected">
                <list-simple
                    :check-question="true"
                    @getList="listQuestions = $event"
                />
            </section>
        </b-modal>
    </div>
</template>

<script>
    import ListSimple from "./questions/simple/ListSimple";

    export default {
        name: "CreateExams",
        components: {
            ListSimple
        },
        props: {
            value: {
                type: Boolean
            }
        },
        data() {
            return {
                showModal: false,
                selected: false,
                numberQuestion: 0,
                listQuestions: [],
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
                    number: this.numberQuestion,
                    list_question: JSON.stringify(this.listQuestions),
                }
            }
        },
        methods: {
            createExam() {
                axios.post('exams/store', this.formData).then(response => {
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
