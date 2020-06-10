<template>
    <div class="root">
        <section class="content">

            <!-- SELECT2 EXAMPLE -->
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"></h3>
                            b-bu
                            <div class="box-tools">
                                <b-form inline>
                                    <b-input
                                        v-model="nameSearch"
                                        id="inline-form-input-name"
                                        placeholder="Search"
                                    ></b-input>
                                </b-form>
                            </div>
                            <hr>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <b-button variant="outline-primary" to="/createAdmin">Create</b-button>
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
                                        <td colspan="5" class="text-center"><h5>{{ table.isNull }}</h5></td>
                                    </tr>
                                    <tr v-if="!table.isNull" v-for="(item, index) in table.data">
                                        <slot v-for="(columnIndex, indexColumn) in table.index">
                                            <td :key="indexColumn" v-html="collumnItem(index, columnIndex)"></td>
                                        </slot>
                                        <td>
                                            <b-dropdown split
                                                        split-variant="outline-primary"
                                                        variant="primary" id="dropdown-1" size="sm" text="Actions"
                                                        class="m-md-2">
                                                <!--<b-dropdown-item-button
                                                    v-on:click="chooseRole(item.id)">
                                                    <i class="fa fa-edit"></i>Edit
                                                </b-dropdown-item-button>-->
                                                <b-dropdown-item-button >
                                                    <role-component :users="item"></role-component>
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
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import Paginate from "vuejs-paginate";
    import RoleComponent from "./RoleComponent";

    const table_collumns = ['account.admins.#', 'account.admins.name', 'account.admins.email', 'account.admins.role', 'account.admins.action'];
    const table_index = ['#', 'name', 'email', 'role'];
    export default {
        name: "AdminaccountList",
        components: {
            Paginate,
            RoleComponent
        },
        data() {
            return {
                totalPage: 0,
                currentPage: 1,
                nameSearch: null,
                formLoad: {
                    name: '',
                    page: null,
                },
                table: {
                    collumns: [...table_collumns],
                    index: [...table_index],
                    isNull: null,
                    data: [],
                },
            }
        },
        created() {
            this.firstLoad();
        },
        watch: {
            nameSearch: function (val) {
                this.formLoad.name = val;
                this.firstLoad();
            }
        },
        methods: {
            firstLoad() {
                this.formLoad.page = this.currentPage;
                axios.post('/adminAccount/getlist', this.formLoad)
                    .then(response => {
                        this.totalPage = response.data.total_page;
                        if (response.data.lists.length > 0) {
                            this.table.data = response.data.lists;
                            this.table.isNull = false;
                        } else {
                            this.table.isNull = 'Không có admin';
                        }
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            collumnItem(index, key) {
                switch (key) {
                    case table_index[0]: {
                        return 10 * (this.currentPage - 1) + index + 1;
                    }
                    case table_index[3]: {
                        return this.$t(this.table.data[index][key]);
                    }
                    default: {
                        return this.table.data[index][key]
                    }
                }
            },
            chooseRole(id){
                this.$bvModal.show('modal-role');
                console.log(id)
            }
        }
    }
</script>

<style scoped>

</style>
