<template>
    <div class="root">
        <section class="content">
            <!-- SELECT2 EXAMPLE -->
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">
                                <router-link class="btn btn-primary" to="Questions-Create">Thêm Mới</router-link>
                                <b-button variant="success" v-on:click="importModal = !importModal"><i class="fa fa-upload" aria-hidden="true"></i> Import</b-button>
                                <b-button variant="success" v-on:click="exportModal = !exportModal"><i class="fa fa-download" aria-hidden="true"></i> Export</b-button>
                            </h3>

                            <div class="box-tools">
                                <b-form inline>
                                    <b-input
                                        id="inline-form-input-name"
                                        placeholder="Search"
                                    ></b-input>
                                </b-form>
                            </div>
                            <hr>
                        </div>
                        <div class="box-body">
                           <list-simple />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--modal import-->
        <import-simple-question
            v-if="importModal"
            v-model="importModal"
            @handle="firstLoad"
            link="question/simple/import"
        />
        <export-simple-question
            v-if="exportModal"
            v-model="exportModal"
            link="question/simple/export"
        />
    </div>
</template>

<script>
    import Paginate from "vuejs-paginate";
    import SimpleQuestion from "./SimpleQuestion";
    import ImportSimpleQuestion from "./simple/ImportSimpleQuestion";
    import ExportSimpleQuestion from "./simple/ExportSimpleQuestion";
    import ListSimple from "./simple/ListSimple";

    const table_collumns = [
        'table.#',
        'table.questions.question',
        'table.actions',
    ];

    const table_index = [
        '#',
        'question',
    ];


    export default {
        name: "ListSimpleQuestions",
        components: {
            ImportSimpleQuestion,
            ExportSimpleQuestion,
            ListSimple
        },
        data() {
            return {
                importModal: false,
                exportModal: false,
            }
        },
        watch: {
            done: function (val) {
                if (val) {
                    this.editModal = false;
                    this.firstLoad();
                    this.done = false;
                }
            }
        },
        methods: {
            firstLoad() {
                this.importModal = false;
                this.formLoad.page = this.currentPage;
                axios.post('question/simple/getList', this.formLoad).then(response => {
                    let {data} = response;
                    this.totalPage = data.total_page;
                    this.table.data = data.lists;
                }).catch(err => {
                    console.log(err);
                });
            },
        }
    }
</script>

<style scoped>

</style>
