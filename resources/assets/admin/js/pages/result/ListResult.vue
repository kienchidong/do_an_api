<template>
    <div class="root">
        <section class="content">

            <!-- SELECT2 EXAMPLE -->
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"></h3>

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
                                        <th v-for="(col) in table.collumns">{{ col }}</th>
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
                                                <b-dropdown-item variant="primary" v-on:click="showDetail(index)">
                                                    <i class="fa fa-edit"></i>
                                                    View Detail
                                                </b-dropdown-item>

                                            </b-dropdown>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot class="thead-light">
                                    <tr>
                                        <th v-for="(col) in table.collumns">{{ col }}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--review-->
        <result-detail v-if="showReview"
                     @closeModal="showReview = $event"
                     :answers="answerReview"
        />
    </div>
</template>

<script>
    import Paginate from "vuejs-paginate";
    import ResultDetail from "./ResultDetail";

    const table_collumns = [
        '#',
        'Học Viên',
        'Mã đề',
        'Điểm',
        'Thời gian',
        'Actions'
    ];
    const table_index = [
        '#',
        'user',
        'code',
        'point',
        'time',
    ];
    export default {
        name: "ListResult",
        components: {
            Paginate,
            ResultDetail
        },
        data() {
            return {
                currentPage: 1,
                totalPage: 0,
                size: 10,
                table: {
                    collumns: [...table_collumns],
                    index: [...table_index],
                    data: []
                },
                showReview: false,
                answerReview: [],
            }
        },
        computed: {
            formLoad: function () {
                return {
                    size: this.size,
                    page: this.currentPage,
                }
            }
        },
        created() {
            this.firstLoad();
        },
        methods: {
            firstLoad() {
                axios.post('result/getList', this.formLoad).then(response => {
                    this.totalPage = response.data.total_page;
                    if (response.data.lists.length > 0) {
                        this.table.data = response.data.lists;
                    }
                }).catch(err => {
                    console.log(err);
                });
            },
            tableIndex(index, key) {
                let item = this.table.data[index];
                switch (key) {
                    case table_index[0]: {
                        return this.size * (this.currentPage - 1) + index + 1;
                    }
                    case table_index[1]: {
                        return item[key].name;
                    }
                    case table_index[2]: {
                        return item[key]+ item.id;
                    }
                    default: {
                        return item[key];
                    }
                }
            },
            showDetail(index){
                let obj = this.table.data[index];
                this.answerReview = obj.answer_detail;
                this.showReview = true;
            }
        },
    }
</script>

<style scoped>

</style>
