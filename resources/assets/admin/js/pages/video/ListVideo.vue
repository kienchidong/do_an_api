<template>
    <div class="root">
        <section class="content">
            <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <b-button v-on:click="CreateNew">Thêm mới</b-button>
                </div>
                <!-- /.box-header -->
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
                            <tr v-if="table.isNull">
                                <td colspan="3" class="text-center">{{ table.isNull }}</td>
                            </tr>
                            <tr v-if="!table.isNull" v-for="(item, index) in table.data">
                                <slot v-for="(columnIndex, indexColumn) in table.index">
                                    <td :key="indexColumn" v-html="tableIndex(index, columnIndex)"></td>
                                </slot>
                                <td>
                                    <!-- <b-dropdown split
                                                 split-variant="outline-primary"
                                                 variant="primary" id="dropdown-1" size="sm" text="Actions"
                                                 class="m-md-2">
                                         <b-dropdown-item-button v-on:click="EditCate(index)">
                                             <i class="fa fa-edit"></i>
                                             Edit
                                         </b-dropdown-item-button>
                                         <b-dropdown-item-button v-on:click="DeleteCate(index)">
                                             <i class="fa fa-trash"></i>
                                             Delete
                                         </b-dropdown-item-button>
                                     </b-dropdown>-->
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
        </section>

        <!-- modal -->
        <create-video
            :video-detail="detail"
            v-if="show"
            @done="done"></create-video>
    </div>
</template>

<script>
    import Paginate from "vuejs-paginate";
    import CreateVideo from "./CreateVideo";

    const table_collumns = [
        'account.users.#',
        'account.users.name',
        'table.video.link',
        'table.video.type',
        'account.users.action',
    ];
    const table_index = [
        '#',
        'name',
        'link',
        'type',
    ];

    export default {
        name: "ListVideo",
        components: {
            Paginate,
            CreateVideo
        },
        data() {
            return {
                currentPage: 1,
                totalPage: 0,
                formLoad: {
                    page: null,
                },
                table: {
                    isNull: null,
                    collumns: [...table_collumns],
                    index: [...table_index],
                    data: [],
                },
                detail: {},
                show: false,

            }
        },
        created() {
            this.firstLoad();
        },
        methods: {
            firstLoad() {
                this.formLoad.page = this.currentPage;
                axios.post('video/getList', this.formLoad).then(response => {
                    console.log(response.data)
                    this.totalPage = response.data.total_page;
                    if (response.data.lists.length > 0) {
                        this.table.data = response.data.data.lists;
                        this.table.isNull = null;
                    } else {
                        this.table.isNull = 'Không có Video';
                    }
                }).catch(err => {
                    console.log(err)
                })
            },
            CreateNew() {
                this.show = !this.show;
            },
            done() {
                this.firstLoad();
                this.show = false;
            },
            tableIndex(index, key) {
                let obj = this.table.data[index];
                switch (key) {
                    case table_index[0]:
                        return 10 * (this.currentPage - 1) + index + 1;
                    case table_index[2]:
                        let link ='https://www.youtube.com/watch?v='+obj['video_id'];
                        return '<a target="_blank" href="'+link+'">'+link+'</a>';
                    default:
                        return obj[key];

                }

            }
        }
    }
</script>

<style scoped>

</style>
