<template>
    <div class="root">
        <b-progress show-progress :max="numberQuestion" class="mb-3" v-if="numberQuestion >1">
            <b-progress-bar variant="primary" :value="step" :label="label"></b-progress-bar>
        </b-progress>
        <hr>
        <section v-if="step === 1">
            <b-form-group
                label="Tên:"
                description=""
            >
                <b-form-input v-model="name"></b-form-input>
            </b-form-group>
            <b-form-group
                label="Level:"
                description=""
            >
                <b-form-select v-model="levelChoose" size="sm" class="mt-3">
                    <b-form-select-option v-for="(item, index) in level" :key="index" :value="item.id">{{ item.name }}
                    </b-form-select-option>
                </b-form-select>
            </b-form-group>
            <b-form-group
                label="Mô tả:"
                description=""
            >
                <tinymce id="d1" v-model="describe"></tinymce>
            </b-form-group>
            <b-form-group
                label="Loại câu hỏi:"
                description=""
            >
                <b-form-select v-model="type" class="mb-3">
                    <b-form-select-option value="0">Đọc</b-form-select-option>
                    <b-form-select-option value="1">Nghe</b-form-select-option>
                    <b-form-select-option value="2">Viết</b-form-select-option>
                </b-form-select>
            </b-form-group>
            <b-form-group
                label="file:"
                description=""
                v-if="type == 1"
            >
                <b-form-file v-model="audio" class="mt-3" plain></b-form-file>
            </b-form-group>

            <b-col sm="12" md="12" class="text-center">
                <hr>
                <b-button v-on:click="createGroup">Submit</b-button>
            </b-col>
        </section>

        <simple-question v-if="step>1"
                         :group_id="group_id"
                         :group_step="step"
                         :group_level="formData.level"
                         :action="true"
                         v-on:nextStep="step = $event"></simple-question>
    </div>
</template>

<script>
    import SimpleQuestion from "./SimpleQuestion";
    import tinymce from 'vue-tinymce-editor'

    export default {
        name: "GroupQuestions",
        components: {
            SimpleQuestion,
            tinymce
        },
        data() {
            return {
                numberQuestion: 1,
                level: [],
                step: 1,
                name: null,
                describe: null,
                levelChoose: null,
                group_id: null,
                type: null,
                audio: null,
            }
        },
        created() {
            this.getLevel();
        },
        computed: {
            label: function () {
                let la = (this.step / this.numberQuestion) * 100;
                return la + '%';
            },
            formData: function () {
                let form = new FormData();
                form.append('name', this.name);
                form.append('describe', this.describe);
                form.append('level', this.levelChoose);
                form.append('type', this.type);
                form.append('file', this.audio);
                return form;
            }
        },
        methods: {
            getLevel() {
                axios.get('question/getLevel').then(response => {
                    this.level = response.data;
                })
            },
            nextStep() {
                alert('abc')
            },
            createGroup() {

                axios.post('/question/createGroupQuestions', this.formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                ).then(response => {
                    console.log(response);
                    if(response.data.data.type !=2) {
                        let {data} = response.data;
                        this.group_id = data.id;
                        this.$swal({
                            title: 'Bao nhiêu câu?',
                            input: 'number',
                            inputPlaceholder: 'number questions',
                            showCloseButton: true,
                        }).then((result) => {
                            if (result.value) {
                                this.numberQuestion = result.value;
                            }
                        });
                        this.step = this.step + 1;
                    } else {
                        this.$router.push('/List-Group-Question');
                    }
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
