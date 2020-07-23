<template>
    <div>
        <b-container class="bv-example-row">
            <b-row>
                <b-col sm="12" md="12">
                    <b-form inline>
                        <label>{{numberQuestion}}: {{ questionDetail.question }}</label>
                    </b-form>
                    <br>
                </b-col>
                <b-col sm="12" md="12" v-if="questionDetail.image">
                    <img :src="questionDetail.image" width="50%" alt="">
                </b-col>

                <b-col v-for="(item, index) in questionDetail.answers" :key="index" sm="12" md="6">
                    <b-form inline disabled>
                        <b-form-radio
                            name="answer"
                            v-model="chooseAnswer"
                            :value="index"
                            :disabled="explain == true"
                        >
                            {{ item.chooseAnswer}}
                            <span v-if="questionDetail.image">({{ label[index]}})</span>
                            <span v-if="!questionDetail.image">{{ item.answer }}</span>
                        </b-form-radio>
                        <div v-if="chooseAnswer == index && explain">
                            <i class="fa fa-check text-success" v-if="checkAnswer == true"></i>
                            <i class="fa fa-times text-danger" v-if="checkAnswer == false"></i>
                        </div>
                    </b-form>
                </b-col>
                <b-col sm="12" md="12" v-if="explain">
                    <b-alert :variant="status" show>
                        <span>Giải thích:</span>&ensp
                        <label>{{ questionDetail.explain }}</label>
                    </b-alert>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

<script>
    const question_label = ['A', 'B', 'C', 'D'];
    export default {
        name: "QuestionComponent",
        props: {
            questionDetail: {
                type: Object,
                require: true,
            },
            numberQuestion: {
                type: Number,
                require: true,
            },
            explain: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                chooseAnswer: null,
                chooseRight: null,
                disableAnswer: false,
                checkAnswer: null,
                label: [...question_label],
                status: null,
            }
        },
        watch: {
            chooseAnswer: function (val) {
                let obj = this.questionDetail.answers[val];
                this.checkAnswer = obj.status;
                this.$emit('chooseAnswer', obj);
            },
        },
        mounted() {
            this.questionDetail.answers.forEach((item, index) => {
                if (item.chosen == 1) {
                    this.chooseAnswer = index;
                }
            })
            this.status = (this.questionDetail.status == 1) ? 'success': 'danger';
        }
    }
</script>

<style scoped>

</style>
