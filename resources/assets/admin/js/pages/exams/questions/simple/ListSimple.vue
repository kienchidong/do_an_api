<template>
    <div class="root">
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
                    <th v-if="checkQuestion">chọn</th>
                    <th v-for="(col) in table.collumns">{{ $t(col) }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in table.data">
                    <td v-if="checkQuestion">
                        <input type="checkbox" name="group" v-model="chooseQuestions" :value="item.id"></b-form-checkbox-group>
                    </td>
                    <slot v-for="(columnIndex, indexColumn) in table.index">
                        <td :key="indexColumn" v-html="tableIndex(index, columnIndex)"></td>
                    </slot>
                    <td>
                        <b-dropdown split
                                    split-variant="outline-primary"
                                    variant="primary" id="dropdown-1" size="sm"
                                    :text="$t('table.actions')" class="m-md-2">
                            <b-dropdown-item variant="primary" v-on:click="viewDetail(index)">
                                <i class="fa fa-eye"></i>
                                View Detail
                            </b-dropdown-item>
                            <b-dropdown-item variant="primary" v-on:click="edit(index)" v-if="!checkQuestion">
                                <i class="fa fa-edit"></i>
                                Edit
                            </b-dropdown-item>
                        </b-dropdown>
                    </td>
                </tr>
                </tbody>
                <tfoot class="thead-light">
                <tr>
                    <th v-if="checkQuestion">chọn</th>
                    <th v-for="(col) in table.collumns">{{ $t(col) }}</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div ref="DetailQuestion" v-model="showModal" title="Chi Tiết Câu Hỏi">
            <b-container class="bv-example-row">
                <b-row>
                    <b-col sm="12" md="12">
                        <b-form inline>
                            <label>{{ modalDetail.question }}</label>
                        </b-form>
                    </b-col>
                    <b-col v-for="(item, index) in modalDetail.answers" :key="index" sm="12" md="6">
                        <b-form inline>
                            <label class="mr-sm-2">
                                {{ questionLabel[index] }}: {{ item.answer }}
                            </label><i v-if="item.status" class="fa fa-check text-green"></i>
                        </b-form>
                    </b-col>
                    <hr>
                    <b-col sm="12" md="12">
                        <b-form inline>
                            <label>Giải thích: {{ modalDetail.explain }}</label>
                        </b-form>
                    </b-col>
                </b-row>
            </b-container>
        </div>
        <b-modal v-model="editModal" hide-footer title="Sửa Câu Hỏi">
            <simple-question
                :editQuestion="editForm"
                :group_level="editForm.level"
                :action="false"
                v-on:nextStep="done = true"
            ></simple-question>
        </b-modal>
    </div>
</template>

<script>
    import Paginate from "vuejs-paginate";
    import SimpleQuestion from "../SimpleQuestion";

    const table_collumns = [
        'table.#',
        'table.questions.question',
        'table.actions',
    ];
    const questionLabel = [
        'A',
        'B',
        'C',
        'D'
    ];

    const table_index = [
        '#',
        'question',
    ];
    export default {
        name: "ListSimple",
        components: {
            Paginate,
            SimpleQuestion,
        },
        props: {
            checkQuestion: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                totalPage: 1,
                currentPage: 1,
                table: {
                    collumns: [...table_collumns],
                    index: [...table_index],
                    data: [],
                },
                showModal: false,
                modalDetail: {
                    questions: null,
                    answers: [],
                    explain: null,
                },
                editModal: false,
                editForm: [],
                questionLabel: [...questionLabel],
                done: false,
                chooseQuestions: [],
            }
        },
        computed: {
            formLoad: function () {
                return {
                    page: this.currentPage
                }
            }
        },
        watch: {
            done: function (val) {
                if (val) {
                    this.editModal = false;
                    this.firstLoad();
                    this.done = false;
                }
            },
            chooseQuestions: function (val) {
               this.$emit('getList', val);
            }
        },
        created() {
            this.firstLoad();
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
            tableIndex(index, key) {
                let item = this.table.data[index];
                switch (key) {
                    case table_index[0]: {
                        return 10 * (this.currentPage - 1) + index + 1;
                    }
                    default: {
                        return item[key];
                    }
                }
            },
            viewDetail(index) {
                let item = this.table.data[index];
                this.modalDetail.question = item['question'];
                this.modalDetail.answers = item['answers'];
                this.modalDetail.explain = item['explain'];
                this.$swal({
                    title: '<i>Chi tiết câu hỏi</i>',
                    html: this.$refs.DetailQuestion,
                    showCloseButton: true,
                })
                //this.showModal = true;
            },
            edit(index) {
                this.editForm = this.table.data[index];
                this.editModal = true;
            }
        }
    }
</script>

<style scoped>

</style>
