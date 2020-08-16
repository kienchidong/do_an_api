<template>
    <div class="root">
        <section class="content">

            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="box-title">
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
                                    <tr>
                                        <td colspan="4" v-if="table.isNull" class="text-center"><h4>{{ table.isNull
                                            }}</h4></td>
                                    </tr>
                                    <tr v-for="(item, index) in table.data" v-if="!table.isNull">
                                        <slot v-for="(columnIndex, indexColumn) in table.index">
                                            <td :key="indexColumn" v-html="tableIndex(index, columnIndex)"></td>
                                        </slot>
                                        <td>
                                            <b-dropdown split
                                                        split-variant="outline-primary"
                                                        variant="primary" id="dropdown-1" size="sm"
                                                        :text="$t('table.actions')" class="m-md-2">
                                                <b-dropdown-item :to="'News-Edit/'+item.id" variant="primary">
                                                    <i class="fa fa-edit"></i>
                                                    Edit
                                                </b-dropdown-item>
                                                <b-dropdown-item-button variant="success">
                                                    <a target="_blank" :href="clientLink +'#/news/'+item.slug">
                                                        <i class="fa fa-eye"></i>
                                                        Preview
                                                    </a>
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
    </div>
</template>

<script>
    import Paginate from "vuejs-paginate";

    const table_collumns = [
        'table.#',
        'table.feedback.content',
        'table.created',
        'table.feedback.user',
        'table.actions',
    ];

    const table_index = [
        '#',
        'content',
        'created',
        'user',
    ];

    export default {
        name: "ListFeedBack",
        components: {
            Paginate
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
                }
            }
        },
        created() {
            this.firstLoad()
        },
        computed: {
            formLoad: function () {
                return {
                    page: this.currentPage,
                    size: this.size,
                }
            }
        },
        watch:{
          size: function (val) {
              this.firstLoad();
          }
        },
        methods: {
            firstLoad() {
                axios.post('feedback/getList', this.formLoad).then(response => {
                    let {data} = response;
                    this.totalPage = data.total_page;
                    if (data.lists.length > 0) {
                        this.table.data = data.lists;
                        this.table.isNull = null;
                    } else {
                        this.table.isNull = 'Không Có feedback';
                    }
                    console.log(data);
                }).catch(err => {
                    console.log(err);
                });
            },
            tableIndex(index, key) {
                let obj = this.table.data[index];
                switch (key) {
                    case table_index[0]: {
                        return this.size * (this.currentPage - 1) + index + 1;
                    }
                    case table_index[2]: {
                        return new Date(obj[key]*1000).toLocaleString();
                    }
                    case table_index[3]: {
                        return obj[key].name;
                    }
                    default: {
                        return obj[key];
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>
