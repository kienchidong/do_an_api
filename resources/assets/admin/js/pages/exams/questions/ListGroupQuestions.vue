<template>
    <div class="root">
        <section class="content">
            <!-- SELECT2 EXAMPLE -->
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title" v-if="!checkQuestion">
                                <router-link class="btn btn-primary" to="Questions-Create">Thêm Mới</router-link>
                                <b-button variant="success" v-on:click="importModal = !importModal"><i class="fa fa-upload" aria-hidden="true"></i> Import</b-button>
                                <b-button variant="success" v-on:click="exportModal = !exportModal"><i class="fa fa-download" aria-hidden="true"></i> Export</b-button>
                            </h3>

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
                                        <th v-if="checkQuestion">chọn</th>
                                        <th v-for="(col) in table.collumns">{{ $t(col) }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in table.data">
                                        <td v-if="checkQuestion">
                                            <input type="checkbox" name="group" v-model="chooseQuestions" :value="item.group_id"></b-form-checkbox-group>
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
                                                <b-dropdown-item variant="primary"
                                                                 v-if="!checkQuestion"
                                                                 :to="'Edit-Group-Question?id='+item.group_id">
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
                        </div>
                        <!-- Modal -->
                        <div ref="DetailQuestion" v-model="showModal" hide-footer title="Chi Tiết Câu Hỏi">
                            <b-container class="bv-example-row">
                                <b>{{ modalDetail.name }}</b>
                                <hr>
                                <b-row>
                                    <b-col sm="12" md="12">
                                        <b-form inline>
                                            <p v-html="modalDetail.describe"></p>
                                        </b-form>
                                    </b-col>
                                    <audio controls v-if="modalDetail.audio">
                                        <source :src="modalDetail.audio" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                    <hr>
                                    <b-col v-for="(question, indexQuestions) in modalDetail.questions"
                                           :key="indexQuestions" sm="12"
                                           md="6" align="left">
                                        <b>{{indexQuestions+1}}: {{ question.question}}</b><br>
                                        <img v-if="question.image != 0" :src="question.image" width="50%" alt="">
                                        <b-row>
                                            <b-col v-for="(item, index) in question.answers" :key="index" sm="12"
                                                   md="6">
                                                <b-form inline>
                                                    <label class="mr-sm-2">
                                                        <b>{{ questionLabel[index] }}:</b> &nbsp; {{ item.answer }}
                                                    </label><i v-if="item.status"
                                                               class="fa fa-check text-green"></i>
                                                </b-form>
                                            </b-col>
                                        </b-row>
                                    </b-col>
                                </b-row>
                            </b-container>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--import-->
        <import-simple-question
            v-if="importModal"
            v-model="importModal"
            @handle="firstLoad"
            link="question/group/import"
        />
        <!--export-->
        <export-simple-question
            v-if="exportModal"
            v-model="exportModal"
            link="question/group/export"
        />
    </div>
</template>

<script>
    import Paginate from "vuejs-paginate";
    import EditGroupComponent from "./EditGroupComponent";
    import ExportSimpleQuestion from "./simple/ExportSimpleQuestion";
    import ImportSimpleQuestion from "./simple/ImportSimpleQuestion";

    const table_collumns = [
        'table.#',
        'table.questions.name',
        'table.actions',
    ];

    const table_index = [
        '#',
        'name',
    ];
    const questionLabel = [
        'A',
        'B',
        'C',
        'D'
    ];

    export default {
        name: "ListSimpleQuestions",
        components: {
            Paginate,
            EditGroupComponent,
            ExportSimpleQuestion,
            ImportSimpleQuestion
        },

        props: {
            checkQuestion: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                done: false,
                questionLabel: [...questionLabel],
                editGroup: false,
                showModal: false,
                table: {
                    collumns: [...table_collumns],
                    index: [...table_index],
                    data: [],
                },
                totalPage: 1,
                currentPage: 1,
                modalDetail: {
                    name: null,
                    describe: null,
                    questions: [],
                    audio: null,
                },
                editForm: [],
                importModal: false,
                exportModal: false,
                chooseQuestions: [],
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
        computed:{
            formLoad:function () {
                return {
                    page: this.currentPage,
                    type: 0
                }
            },
        },
        created() {
            this.firstLoad();
        },
        methods: {
            firstLoad() {
                axios.post('question/group/getList', this.formLoad).then(response => {
                    let {data} = response;
                    console.log(data)
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
                    case table_index[1]: {
                        let str = item[key];
                        if (str.length > 50) {
                            return item[key].substr(0, 50) + '...';
                        } else {
                            return item[key];
                        }
                    }
                    default: {
                        return item[key];
                    }
                }
            },
            viewDetail(index) {
                let item = this.table.data[index];

                this.modalDetail.name = item['name'];
                this.modalDetail.describe = item['describe'];
                this.modalDetail.questions = item['questions'];
                this.modalDetail.audio = item['audio'];

                this.$swal({
                    width: 1000,
                    html: this.$refs.DetailQuestion,
                    showCloseButton: true,
                })
                //this.showModal = true;
            },
            edit(index) {
                this.editForm = this.table.data[index];
                this.editGroup = !this.editGroup;
            }
        }
    }
</script>

<style scoped>

</style>
