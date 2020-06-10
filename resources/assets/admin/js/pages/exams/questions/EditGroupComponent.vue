<template>
    <div class="root">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">
                            </h3>

                            <div class="box-tools">
                                <b-form inline>

                                </b-form>
                            </div>
                            <hr>
                        </div>
                        <div class="box-body">
                            <b-form-group
                                label="Tên:"
                                label-for="input-1"
                                description=""
                            >
                                <b-form-input v-model="name"></b-form-input>
                            </b-form-group>
                            <b-form-group
                                label="Level:"
                                label-for="input-1"
                                description=""
                            >
                                <b-form-select v-model="levelValue" size="sm" class="mt-3">
                                    <b-form-select-option v-for="(item, index) in level" :key="index" :value="item.id">
                                        {{ item.name }}
                                    </b-form-select-option>
                                </b-form-select>
                            </b-form-group>
                            <b-form-group
                                label="Mô tả:"
                                label-for="input-1"
                                description=""
                            >
                                <tinymce id="d1"
                                         v-model="describe"/>
                            </b-form-group>
                        </div>
                        <b-button variant="primary" v-on:click="addQuestion">thêm mới</b-button>
                        <hr>
                        <b-row>
                            <b-col v-for="(question, indexQuestions) in questions"
                                   :key="indexQuestions" sm="12"
                                   class="question"
                                   md="6" align="left">
                                <b>{{indexQuestions+1}}: {{ question.question}}</b>
                                <a href="#" class="btn-edit" title="edit this question"
                                   v-on:click="editQuestion(indexQuestions)">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="#" class="btn-edit text-danger" title="Delete this question"
                                   v-on:click="deleteQuestion(indexQuestions)">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <b-row>
                                    <b-col v-for="(item, index) in question.answers" :key="index" sm="12"
                                           md="6">
                                        <b-form inline>
                                            <label class="mr-sm-2">
                                                {{ questionLabel[index] }}: {{ item.answer }}
                                            </label><i v-if="item.status"
                                                       class="fa fa-check text-green"></i>
                                        </b-form>
                                    </b-col>
                                </b-row>
                            </b-col>
                        </b-row>
                        <hr>
                        <div class="text-center">
                            <b-button variant="success" v-on:click="editGroup">Submit</b-button>
                        </div>
                    </div>
                    <!--modal-->
                    <b-modal v-model="editModal" hide-footer title="Sửa Câu Hỏi">
                        <simple-question
                            :group_id="id"
                            :editQuestion="editForm"
                            :group_level="levelValue"
                            :action="action"
                            v-on:nextStep="editDone"
                        ></simple-question>
                    </b-modal>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import tinymce from 'vue-tinymce-editor';
    import SimpleQuestion from "./SimpleQuestion";

    const questionLabel = [
        'A',
        'B',
        'C',
        'D'
    ];

    export default {
        name: "EditGroupComponent",
        components: {
            tinymce,
            SimpleQuestion
        },
        data() {
            return {
                id: this.$route.query.id,
                action: null,
                level: [],
                name: null,
                describe: null,
                levelValue: null,
                group: [],
                questions: [],
                questionLabel: [...questionLabel],
                editModal: false,
                editForm: [],
            }
        },
        created() {
            this.getLevel();
            this.getGroup();
        },
        computed: {
            formData: function () {
                let form = {
                    name: this.name,
                    describe: this.describe,
                    level: this.levelValue
                };
                return form;
            },
        },
        methods: {
            getGroup() {
                axios.get('question/group/edit/' + this.id).then(response => {
                    let {data} = response;
                    this.name = data.name;
                    this.describe = data.describe;
                    this.levelValue = data.level;
                    this.questions = data.questions;
                })
            },
            getLevel() {
                axios.get('question/getLevel').then(response => {
                    this.level = response.data;
                })
            },
            editQuestion(index) {
                this.editForm = this.questions[index];
                this.action = false;
                this.editModal = true;
            },
            editDone() {
                this.editModal = false;
                this.getGroup();
            },
            editGroup() {
                axios.put('question/group/edit/' + this.id, this.formData).then(response => {
                    alertify.success('Sửa thành công!');
                    this.$router.push('List-Group-Question');
                }).catch(err => {
                    console.log(err.response)
                })
            },
            deleteQuestion(index) {
                let item = this.questions[index];
                this.$swal({
                    title: 'Are you sure?',
                    text: 'You can\'t revert your action',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes Delete it!',
                    cancelButtonText: 'No, Keep it!',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                    if (result.value) {
                        axios.delete('question/simple/delete/'+ item.id).then(response => {
                            this.getGroup();
                        }).catch(err => {
                            const {data} = err.response;
                            alert(data.message);
                        })
                        this.$swal('Deleted', 'You successfully deleted this file', 'success')
                    } else {
                        this.$swal('Cancelled', 'Your file is still intact', 'info')
                    }
                })
            },
            addQuestion(){
                this.editForm = [];
                this.action = true;
                this.editModal = true;
            }
        }
    }
</script>

<style scoped>
    .question .btn-edit {
        display: none;
    }

    .question:hover .btn-edit {
        display: contents;
    }
</style>
