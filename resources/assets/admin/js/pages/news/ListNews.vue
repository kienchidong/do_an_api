<template>
    <div class="root">
        <section class="content">

            <!-- SELECT2 EXAMPLE -->
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"></h3>
                            <router-link class="btn btn-primary" to="News-Create">Thêm Mới</router-link>
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
                                                <b-dropdown-item-button v-on:click="deleteNews(item.id)"
                                                                        variant="danger">
                                                    <i class="fa fa-trash"></i>
                                                    Delete
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
        'table.news.title',
        'table.news.cate',
        'table.news.summary',
        'table.news.image',
        'table.actions',
    ];
    const table_index = [
        '#',
        'title',
        'cate',
        'summary',
        'image',
    ];
    export default {
        name: "ListNews",
        components: {
            Paginate,
        },
        data() {
            return {
                totalPage: 0,
                currentPage: 1,
                formLoad: {
                    name: '',
                    page: null,
                },
                table: {
                    isNull: null,
                    collumns: [...table_collumns],
                    index: [...table_index],
                    data: [],
                }
            }
        },

        created() {
            this.firstLoad();
        },
        methods: {
            firstLoad() {
                this.formLoad.page = this.currentPage;
                axios.post('news/getListNews', this.formLoad).then(response => {
                    console.log(response);
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
                        return 10 * (this.currentPage - 1) + index + 1;
                    }
                    case table_index[3]: {
                        if (item[key] && item[key].length > 100) {
                            return item[key].slice(0, 100) + '...';
                        } else {
                            return item[key]
                        }
                    }
                    case table_index[4]: {
                        return "<img src='" + item[key] + "' width='80px' />";
                    }
                    default: {
                        return item[key];
                    }
                }
            },
            deleteNews(id) {
                let con = confirm('Bạn có Chắc Không?');
                if (con === true) {
                    axios.delete('news/DeleteNews/' + id).then((response) => {
                        console.log(response)
                        //this.firstLoad();
                    }).catch(err => {
                        console.log(err.response);
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>
