<template>
    <div class="root">
        <section class="content">

            <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Select2</h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <import-simple-question></import-simple-question>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </div>
</template>

<script>
    import tinymce from 'vue-tinymce-editor';
    import ImportSimpleQuestion from "./exams/questions/simple/ImportSimpleQuestion";

    export default {
        name: "test",
        components: {
            tinymce,
            ImportSimpleQuestion
        },
        data() {
            return {
                url: null,
                test: null,
                init: {
                    plugins: [
                        'colorpicker textcolor preview theme lists link image paste help wordcount fullscreen'
                    ],
                    toolbar: 'undo redo |autolink  formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | textcolor'

                },
                myValue: '',
                myOptions: ['op1', 'op2', 'op3'],
            }
        },
        methods: {
            myChangeEvent(val) {
                console.log(val);
            },
            mySelectEvent({id, text}) {
                console.log({id, text})
            },
            onInput(e) {
                console.log(e);
            },
            showAlert() {
                // Use sweetalert2
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
                        this.$swal('Deleted', 'You successfully deleted this file', 'success')
                    } else {
                        this.$swal('Cancelled', 'Your file is still intact', 'info')
                    }
                });
            },
        },

    }
</script>

<style scoped>

</style>
