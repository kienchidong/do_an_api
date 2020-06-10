<template>
    <div class="root">
        <section class="content">

            <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
                <div class="box-header with-border">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <b-form-group
                        id="input-group-1"
                        :label="$t('form.news.title')+':'"
                        label-for="input-1"
                        description=""
                    >
                        <b-form-input
                            id="input-1"
                            v-model="formData.title"
                            :state="errors.titleSate"
                            type="email"
                            required
                        ></b-form-input>
                        <b-form-invalid-feedback>
                            {{ errors.titleMessage}}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <!--category-->
                    <b-form-group
                        id="input-group-1"
                        :label="$t('form.news.cate')+':'"
                        label-for="input-1"
                        description=""
                    >
                        <b-form-input type="text" :state="errors.cateSate" id="txt_ide" list="ide" v-model="valueCate"></b-form-input>
                        <b-form-datalist id="ide" :options="listCate"></b-form-datalist>
                        <b-form-invalid-feedback>
                            {{ errors.cateMessage}}
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <!--summary-->
                    <b-form-group
                        id="input-group-1"
                        v-model="formData.summary"
                        :label="$t('form.news.summary')+':'"

                        label-for="input-1"
                        description=""
                    >
                        <b-form-textarea
                            :state="errors.summarySate"
                            v-model="formData.summary"
                        ></b-form-textarea>
                        <b-form-invalid-feedback>
                            {{ errors.summaryMessage}}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <!--content-->
                    <b-form-group
                        id="input-group-1"
                        v-model="formData.content"
                        :label="$t('form.news.content')+':'"
                        label-for="input-1"
                        description=""
                    >
                        <tinymce id="d1" v-model="formData.content"></tinymce>
                        <b-form-invalid-feedback>
                            {{ errors.contentMessage}}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-1"
                        :label="$t('form.news.image')+':'"
                        label-for="input-1"
                        description=""
                    >
                        <b-form-file
                            placeholder="Choose a file or drop it here..."
                            drop-placeholder="Drop file here..."
                            v-on:change="uploadFile"
                        ></b-form-file>
                        <img :src="formData.image" width="50%" alt="">
                        <b-form-invalid-feedback>
                            {{ errors.imageMessage}}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-1"
                        :label="$t('form.news.tag')+':'"
                        label-for="input-1"
                        description=""
                    >
                        <b-form-tags input-id="" v-model="formData.tag" class="mb-2"></b-form-tags>
                    </b-form-group>
                </div>
                <b-form-group class="text-center">
                    <b-button v-if="!id" class="btn-success" v-on:click="CreateNews">submit</b-button>
                    <b-button v-if="id" class="btn-success" v-on:click="EditNews">Edit</b-button>
                </b-form-group>

            </div>
        </section>
    </div>
</template>

<script>
    import tinymce from 'vue-tinymce-editor'

    export default {
        name: "CreateNews",
        components: {
            tinymce,
        },
        data() {
            return {
                id: (this.$route.params.pathMatch) ? this.$route.params.pathMatch : null,
                errors: {
                    titleSate: null,
                    titleMessage: null,
                    summarySate: null,
                    summaryMessage: null,
                    contentSate: null,
                    contentMessage: null,
                    imageMessage: null,
                    cateSate: null,
                    cateMessage: null,
                },
                valueCate: null,
                listCate: [],
                formData: {
                    title: '',
                    cate: '',
                    summary: '',
                    content: '',
                    image: null,
                    tag: [],
                }
            }
        },
        mounted() {
            if (this.id) {
                this.loadDetail();
            }
        },
        watch: {
            valueCate: function (val) {
                this.getListCate(val);
            }
        },
        methods: {
            loadDetail() {
                axios.get('/news/EditNews/' + this.id).then(response => {
                    let {data} = response;
                    this.formData.title = data.title;
                    this.valueCate = data.cate;
                    this.formData.summary = data.summary;
                    this.formData.content = data.content;
                    this.formData.image = data.image;
                    this.formData.tag = data.tag.map(obj => {
                        let rObj = "";
                        rObj += obj['name'];
                        return rObj;
                    });
                }).catch(err => {
                    console.log(err.response);
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
                    }
                    reader.readAsDataURL(files[0]);
                }
            },
            getListCate(name) {
                let form = [];
                form['name'] = name;
                axios.post('/news/getListCate', form).then(response => {
                    if (response.data.data.lists.length > 0) {
                        this.listCate = response.data.data.lists.map(obj => {
                            let rObj = [];
                            rObj.push(obj['name']);
                            return rObj;
                        });
                    } else {
                        this.listCate = [];
                    }
                }).catch(err => {
                    console.log(err);
                })
            },
            submitForm(type) {
                this.formData.cate = this.valueCate;
                axios.post(type, this.formData).then(response => {
                    console.log(response);
                }).catch(err => {
                    const {data} = err.response;
                    if (typeof data.errors === 'object') {
                        $.each(data.errors, (key, value) => {
                            alertify.error(value[0]);
                        });
                    } else {
                        alertify.error(data.message);
                    }
                })
            },
            CreateNews() {
                let type = '/news/createNews';
                this.submitForm(type)
            },
            EditNews() {
                let type = '/news/Update/' + this.id;
                this.submitForm(type)
            }
        }
    }
</script>

<style scoped>

</style>
