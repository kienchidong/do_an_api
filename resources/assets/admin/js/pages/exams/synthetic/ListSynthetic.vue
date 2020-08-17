<template>
    <div class="root">
        <section class="content">

            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="box-title">
                                <b-button variant="success" v-on:click="createModal = !createModal"><i class="fa fa-upload" aria-hidden="true"></i> Thêm</b-button>
                                Show:
                                <b-form-select v-model="size" size="sm" id="input-sm">
                                    <b-form-select-option value="1">1</b-form-select-option>
                                    <b-form-select-option value="5">5</b-form-select-option>
                                    <b-form-select-option value="10">10</b-form-select-option>
                                    <b-form-select-option value="25">25</b-form-select-option>
                                </b-form-select>
                            </div>
                            <hr>
                        </div>
                        <div class="box-body">
                            <div class="" v-if="totalPage >1">
                                <paginate
                                    v-model="currentPage"
                                    :page-count="totalPage"
                                    :click-handler="firstLoad"
                                    :prev-text="'<<'"
                                    :next-text="'>>'"
                                    :container-class="'pagination'"
                                    :page-class="'page-item'"
                                    :page-link-class="'page-link'"
                                    :prev-class="'page-item'"
                                    :prev-link-class="'page-link'"
                                    :next-class="'page-item'"
                                    :next-link-class="'page-link'"
                                ></paginate>
                            </div>
                            <div class="table-responsive table-bordered">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                    <tr>
                                        <th v-for="(col) in table.collumns">{{ $t(col) }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in table.data">
                                        <slot v-for="(columnIndex, indexColumn) in table.index">
                                            <td :key="indexColumn" v-html="tableIndex(index, columnIndex)"></td>
                                        </slot>
                                        <td>
                                            <b-dropdown split
                                                        split-variant="outline-primary"
                                                        variant="primary" id="dropdown-1" size="sm"
                                                        :text="$t('table.actions')" class="m-md-2">
                                                <b-dropdown-item-button variant="success" v-on:click="viewDetail(index)">
                                                    <i class="fa fa-eye"></i>
                                                    View Detail
                                                </b-dropdown-item-button>

                                            </b-dropdown>
                                        </td>
                                    </tr>

                                    </tbody>
                                    <tfoot class="thead-light">
                                    <tr>
                                        <th v-for="(col) in table.collumns">{{ $t(col) }}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <create-exams
            v-if="createModal"
            @created="firstLoad"
            v-model="createModal"/>
        <!--modal detail-->
        <b-modal v-model="showDetail" size="lg" title="Detail">
            <div v-for="(item, index) in testDetail" :key="index">
                <question-component
                    :question-detail="item"
                    :number-question="index+1"
                    :explain="true"
                ></question-component>
                <hr>
            </div>
        </b-modal>
    </div>

</template>

<script>
    import Paginate from "vuejs-paginate";
    import QuestionComponent from "../result/QuestionComponent";
    import CreateExams from "./CreateExams";

    const table_collumns = [
        'table.#',
        'table.exams.Level',
        'table.exams.number_question',
        'table.exams.time',
        'table.exams.status',
        'table.actions',
    ];
    const status = ['status.lock', 'status.active'];

    const table_index = [
        '#', 'level', 'number_question', 'time', 'status'
    ]
    export default {
        name: "ListSynthetic",
        components: {
            Paginate,
            QuestionComponent,
            CreateExams
        },
        data() {
            return {
                size: 10,
                currentPage: 1,
                totalPage: 0,
                table: {
                    isNull: null,
                    collumns: [...table_collumns],
                    index: [...table_index],
                    data: [],
                },
                showDetail: false,
                testDetail: [],
                createModal: false,
            }
        },
        computed: {
            formLoad: function () {
                return {
                    size: this.size,
                    page: this.currentPage
                }
            }
        },
        created() {
            this.firstLoad()
        },
        watch: {
            size: function () {
                this.firstLoad();
            }
        },
        methods: {
            firstLoad() {
                axios.post('exams/index', this.formLoad).then(response => {
                    let {total_page, lists} = response.data;
                    this.totalPage = total_page;
                    this.table.data = lists;
                })
            },
            tableIndex(index, key) {
                let obj = this.table.data[index];
                switch (key) {
                    case table_index[0]:
                        return this.size * (this.currentPage - 1) + index + 1;
                    case table_index[2]:
                        return obj[key] + ' ' +this.$t('system.question');
                    case table_index[3]:
                        return obj[key] + ' ' + this.$t('system.mininute');
                    case table_index[4]:
                        return this.$t(status[obj[key]]);
                    default:
                        return obj[key];
                }
            },
            viewDetail(index){
                this.testDetail = this.table.data[index].list_question;
                this.showDetail =true;
            }
        }
    }
</script>

<style scoped>

</style>
