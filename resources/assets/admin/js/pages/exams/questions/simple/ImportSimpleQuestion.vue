<template>
    <div class="root">
        <upload-excel-component v-on:uploadFile="formData.file = $event"></upload-excel-component>

        <b-button v-on:click="Submit">upload</b-button>
    </div>
</template>

<script>
    import UploadExcelComponent from "../../../../components/UploadExcelComponent";

    const config = {
        headers: { 'content-type': 'multipart/form-data' }
    };
    export default {
        name: "ImportSimpleQuestion",
        components: {
            UploadExcelComponent
        },
        data() {
            return {
                formData: {
                    file: 'image',
                }
            }
        }, methods: {
            Submit() {
                let form = new FormData();
                axios.post('question/simple/import', this.formData, config).then(response => {
                    console.log(response)
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
