<template>
    <div class="root">
        <label for="uploadFile" class="btn btn-outline-primary">
            Choose a file
        </label>
        <span v-if="file"  class="file-chose">{{ file.name }}</span>
        <input id="uploadFile" style="display: none" type="file" v-on:change="UploadFile">
    </div>
</template>

<script>

    export default {
        name: "UploadExcelComponent",
        data() {
            return {
                file: null,
            }
        },
        watch: {
          file: function(val){
              console.log('đây');
              console.log(val);
          }
        },
        methods: {
            UploadFile(e) {
                let files = e.target.files || e.dataTransfer.files;
                let arrayType = ["application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", ".xlsx"];
                if (!arrayType.includes(files[0].type)) {
                    alertify.error('ngu');
                    e.target.value = '';
                } else {
                    this.file = e.target.files[0];
                    this.$emit('uploadFile', this.file);
                }

            }
        }
    }
</script>

<style scoped>

</style>
