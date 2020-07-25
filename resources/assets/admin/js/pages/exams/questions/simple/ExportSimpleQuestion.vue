<template>
    <div class="root">
        <b-modal
            title="Export Excel"
            v-model="isShow">
            <b-form-group
                label="Size:"
            >
                <b-form-select v-model="size" class="mb-3">
                    <b-form-select-option :value="null">Please select the size of results</b-form-select-option>
                    <b-form-select-option value="5">5 Rows</b-form-select-option>
                    <b-form-select-option value="10">10 Rows</b-form-select-option>
                    <b-form-select-option value="20">20 Rows</b-form-select-option>
                    <b-form-select-option value="0">all of Rows</b-form-select-option>
                </b-form-select>
            </b-form-group>
            <b-form-group
                label="Type:"
            >
                <b-form-select v-model="type" class="mb-3">
                    <b-form-select-option :value="null">Please select an extension of file</b-form-select-option>
                    <b-form-select-option value="xlsx">Excel file</b-form-select-option>
                    <b-form-select-option value="CSV">CSV file</b-form-select-option>
                </b-form-select>
            </b-form-group>
            <template v-slot:modal-footer>
                <a class="btn btn-outline-info" :href="link+'?size='+ size +'&type='+type"><i class="fa fa-download"></i> Down Load</a>
            </template>
        </b-modal>
    </div>
</template>

<script>
    export default {
        name: "ExportSimpleQuestion",
        props: ['value', 'link'],
        data() {
            return {
                isShow: false,
                size: 0,
                type: null,
            }
        },
        mounted() {
            this.isShow = this.value;
        },
        watch: {
            isShow: function (val) {
                if (val == false) {
                    this.$emit('input', val);
                }
            }
        },
        computed:{
            formData: function () {
                return {
                    size: this.size,
                    type: this.type,
                }
            }
        },
        methods:{
            Submit() {
                axios.post('question/simple/export', this.formData).then(response => {
                    console.log(response);
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
