<template>
    <div class="root">
        <b-progress show-progress :max="numberQuestion" class="mb-3" v-if="numberQuestion >1">
            <b-progress-bar variant="primary" :value="step" :label="label"></b-progress-bar>
        </b-progress>
        <hr>
        <b-form-group
            label="Tên:"
            label-for="input-1"
            description=""
            v-if="step === 1"
        >
            <b-form-input v-model="formData.name"></b-form-input>
        </b-form-group>
        <b-form-group
            label="Level:"
            label-for="input-1"
            description=""
            v-if="step === 1"
        >
            <b-form-select v-model="formData.level" size="sm" class="mt-3">
                <b-form-select-option v-for="(item, index) in level" :key="index" :value="item.id">{{ item.name }}
                </b-form-select-option>
            </b-form-select>
        </b-form-group>
        <b-form-group
            label="Mô tả:"
            label-for="input-1"
            description=""
            v-if="step === 1"
        >
            <tinymce id="d1" v-model="formData.describe"></tinymce>
        </b-form-group>
        <b-col sm="12" md="12" v-if="step === 1" class="text-center">
            <hr>
            <b-button v-on:click="createGroup">Submit</b-button>
        </b-col>
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
                formData: {
                    name: null,
                    describe: null,
                    level: null,
                },
                group_id: null,
            }
        },
        created() {
            this.getLevel();
        },
        computed: {
            label: function () {
                let la = (this.step / this.numberQuestion) * 100;
                return la + '%';
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
                axios.post('question/createGroupQuestions', this.formData).then(response => {
                    /!*console.log(response);*!/
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
