<template>
    <div class="root">
        <b-container class="bv-example-row">
            <b-row>
                <b-col>
                    <b-form-group
                        label="Level:"
                        label-for="input-1"
                        description=""
                        v-if="!Boolean(group_level)"
                    >
                        <b-form-select v-model="formData.level" size="sm" class="mt-3">
                            <b-form-select-option v-for="(item, index) in level" :key="index" :value="item.id">{{
                                item.name }}
                            </b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <b-form-group
                        id="input-group-1"
                        label="Question:"
                    >
                        <b-form-input
                            v-model="formData.question"
                            type="email"
                            required
                            placeholder="Enter question"
                        ></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col sm="12" md="6">
                    <b-form inline>
                        <label class="mr-sm-2">A:</label>
                        <b-input
                            class="mb-2 mr-sm-2 mb-sm-0"
                            placeholder="Answer A"
                            v-model="answer1"
                        ></b-input>
                        <b-form-radio v-model="rightAnswer" :state="rightAnswer != null"
                                      name="some-radios" value="0">
                            <span v-if="rightAnswer == 0">This Right</span>
                        </b-form-radio>
                    </b-form>
                </b-col>
                <b-col sm="12" md="6">
                    <b-form inline>
                        <label class="mr-sm-2">B:</label>
                        <b-input
                            class="mb-2 mr-sm-2 mb-sm-0"
                            placeholder="Answer B"
                            v-model="answer2"
                        ></b-input>
                        <b-form-radio v-model="rightAnswer" :state="rightAnswer != null"
                                      name="some-radios" value="1">
                            <span v-if="rightAnswer == 1">This Right</span>
                        </b-form-radio>
                    </b-form>
                </b-col>
                <b-col sm="12" md="6">
                    <b-form inline>
                        <label class="mr-sm-2">C:</label>
                        <b-input
                            class="mb-2 mr-sm-2 mb-sm-0"
                            placeholder="Answer C"
                            v-model="answer3"
                        ></b-input>
                        <b-form-radio v-model="rightAnswer" :state="rightAnswer != null"
                                      name="some-radios" value="2">
                            <span v-if="rightAnswer == 2">This Right</span>
                        </b-form-radio>
                    </b-form>
                </b-col>
                <b-col sm="12" md="6">
                    <b-form inline>
                        <label class="mr-sm-2">D:</label>
                        <b-input
                            class="mb-2 mr-sm-2 mb-sm-0"
                            placeholder="Answer D"
                            v-model="answer4"
                        ></b-input>
                        <b-form-radio v-model="rightAnswer" :state="rightAnswer != null"
                                      name="some-radios" value="3">
                            <span v-if="rightAnswer == 3">This Right</span>
                        </b-form-radio>
                    </b-form>
                </b-col>
                <b-col>
                    <b-form-group
                        id="input-group-1"
                        label="Explain:"
                    >
                        <b-form-input
                            v-model="formData.explain"
                            type="email"
                            required
                            placeholder="Enter question"
                        ></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col cols="12">
                    <b-form-group
                        label="Image:"
                    >
                        <b-form-file
                            placeholder="Choose a file or drop it here..."
                            drop-placeholder="Drop file here..."
                            v-on:change="uploadFile"
                        ></b-form-file>
                        <img :src="currentImage" width="50%" alt="">
                    </b-form-group>
                </b-col>
                <b-col sm="12" md="12" class="text-center">
                    <hr>
                    <b-button v-on:click="SubmitFrom">Submit</b-button>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

<script>
    export default {
        name: "SimpleQuestion",
        props: ['group_id', 'group_step', 'group_level', 'editQuestion', 'action'],
        data() {
            return {
                level: [],
                answer1: null,
                answer2: null,
                answer3: null,
                answer4: null,
                rightAnswer: null,
                formData: {
                    group_id: null,
                    question: null,
                    answers: [],
                    level: null,
                    explain: '',
                    image: null
                },
                currentImage: null,
            }
        },
        watch: {
            group_step: function (val) {
                this.formData.question = null;
                this.answer1 = null;
                this.answer2 = null;
                this.answer3 = null;
                this.answer4 = null;
                this.rightAnswer = null;
            },
        },
        created() {

            this.formData.level = (this.group_level) ? this.group_level : null;
            if (this.editQuestion && this.editQuestion.question) {
                this.formData.question = this.editQuestion.question;
                this.formData.explain = this.editQuestion.explain;
                this.currentImage = this.editQuestion.image;
                this.answer1 = this.editQuestion.answers[0].answer;
                this.answer2 = this.editQuestion.answers[1].answer;
                this.answer3 = (this.editQuestion.answers[2]) ? this.editQuestion.answers[2].answer : null;
                this.answer4 = (this.editQuestion.answers[3]) ? this.editQuestion.answers[3].answer : null;
                this.editQuestion.answers.forEach((item, index) => {
                    if (item.status) {
                        this.rightAnswer = index;
                    }
                });
                console.log(this.formData)
            }
            this.getLevel();
        },
        computed: {
            answer: function () {
                let kq = [];
                kq.push({value: this.answer1, status: false});
                kq.push({value: this.answer2, status: false});
                kq.push({value: this.answer3, status: false});
                kq.push({value: this.answer4, status: false});
                if (this.rightAnswer !== null) {
                    kq[this.rightAnswer].status = true;
                }
                this.$emit('getQuestionValue', kq);
                return kq;
            }
        },
        methods: {
            getLevel() {
                axios.get('question/getLevel').then(response => {
                    this.level = response.data;
                })
            },
            uploadFile(e) {
                let files = e.target.files || e.dataTransfer.files;
                let arrayType = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!arrayType.includes(files[0].type)) {
                    e.target.value = '';
                } else {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.formData.image = e.target.result;
                        this.currentImage = e.target.result;
                    }
                    reader.readAsDataURL(files[0]);
                }
            },
            SubmitFrom() {
                let type = '';
                let message = '';
                if (this.action) {
                    type = 'question/createQuestions';
                    message = 'Tạo thành công!';
                } else {
                    type = 'question/updateQuestions/' + this.editQuestion.id;
                    message = 'Sửa thành công!';
                }
                this.formData.answers = this.answer;
                this.formData.group_id = this.group_id;
                axios.post(type, this.formData).then(response => {
                    alertify.success(message);
                    this.$emit('nextStep', this.group_step + 1);
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
