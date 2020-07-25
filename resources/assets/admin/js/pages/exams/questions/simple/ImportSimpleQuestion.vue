<template>
    <div class="root">
        <b-modal title="Upload Simple Question" hide-footer v-model="isShow">
            <upload-excel-component v-on:uploadFile="file = $event"></upload-excel-component>

            <b-button v-on:click="Submit">upload</b-button>
        </b-modal>

    </div>
</template>

<script>
    import UploadExcelComponent from "../../../../components/UploadExcelComponent";

    const config = {
        headers: {'content-type': 'multipart/form-data'}
    };
    export default {
        name: "ImportSimpleQuestion",
        components: {
            UploadExcelComponent
        },
        props: ['value'],
        data() {
            return {
                file: null,
                isShow: false,
            }
        },
        mounted() {
            this.isShow = this.value;
        },
        watch: {
            isShow: function (val) {
                if (val == false) {
                    this.$emit('input', val)
                }
            }
        },
        computed: {
            formData: function () {
                let form = new FormData();
                form.append('file', this.file);
                return form;
            }
        },
        methods: {
            Submit() {
                axios.post('question/simple/import', this.formData, config).then(response => {
                    this.$emit('handle');
                }).catch(err => {
                    const {data} = err.response;
                    if (typeof data.errors === 'object') {
                        $.each(data.errors, (key, value) => {
                            this.errors[key + 'Sate'] = false;
                            this.errors[key + 'Message'] = value[0];
                        });
                    } else {
                        alert(data.message);
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>
