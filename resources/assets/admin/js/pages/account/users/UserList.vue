<template>
    <div class="root">
        <section class="content">
            <!-- SELECT2 EXAMPLE -->
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">
                                <router-link class="btn btn-primary" to="User-Create">Thêm Mới</router-link>
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
                                    <tr  v-for="(item, index) in table.data">
                                    <slot v-for="(columnIndex, indexColumn) in table.index">
                                            <td :key="indexColumn" v-html="tableIndex(index, columnIndex)"></td>
                                        </slot>
                                        <td>
                                            <b-dropdown split
                                                        split-variant="outline-primary"
                                                        variant="primary" id="dropdown-1" size="sm" text="Actions" class="m-md-2">
                                                <b-dropdown-item-button v-if="item.status == 1" v-on:click="lockUser(item.id,0)">
                                                    <i class="fa fa-lock"></i>
                                                    Lock
                                                </b-dropdown-item-button>
                                                <b-dropdown-item-button v-if="item.status == 0" v-on:click="lockUser(item.id,1)">
                                                    <i class="fa fa-unlock"></i>
                                                    UnLock
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
    const table_collumns =[
        'account.users.#',
        'account.users.name',
        'account.users.email',
        'account.users.phone',
        'account.users.gender',
        'account.users.avatar',
        'account.users.status',
        'account.users.action',
    ];
    const table_index = [
        '#',
        'name',
        'email',
        'phone',
        'gender',
        'avatar',
        'status'
    ];
    const gender = [
        'gender.female',
        'gender.male',
        'gender.lgbt',
    ];
    const status = [
        'status.lock',
        'status.active',
    ];

    export default {
        name: "UserList",
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
                    data:[],
                }
            }
        },
        created() {
            this.firstLoad();
        },
        methods:{
            firstLoad(){
                this.formLoad.page = this.currentPage;
                axios.post('adminAccount/getListUser', this.formLoad).then(response =>{
                    this.totalPage = response.data.total_page;
                    if(response.data.lists.length >0){
                        this.table.data = response.data.lists;
                    }
                }).catch(err => {
                    console.log(err);
                });
            },
            tableIndex(index,key){
                let item =this.table.data[index];
                switch (key){
                    case table_index[0]:{
                        return 10 * (this.currentPage - 1) + index + 1;
                    }
                    case table_index[4]:{
                        return this.$t(gender[item[key]]);
                    }
                    case table_index[5]:{
                        return "<img src='"+item[key]+"' width='80px' />";
                    }
                    case table_index[6]:{
                        return this.$t(status[item[key]]);
                    }
                    default:{
                        return item[key];
                    }
                }
            },
            lockUser(id,status){
                axios.get('adminAccount/lockUser/'+id+'/'+status).then(response =>{
                    this.firstLoad();
                }).catch(err => {
                   console.log(err);
                });
            }
        }
    }
</script>

<style scoped>

</style>
