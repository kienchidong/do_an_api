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
                            <tr v-for="(item, index) in table.data">
                                <slot v-for="(columnIndex, indexColumn) in table.index">
                                    <td :key="indexColumn" v-html="tableIndex(index, columnIndex)"></td>
                                </slot>
                                <td>
                                    <b-dropdown split
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
        </section>

        <!--modal-->
        <b-modal id="create-modal" :title="modal.title">
            <div class="d-block ">
                <b-form-group
                    id="input-group-1"
                    label="Name:"
                    label-for="input-1"
                >
                    <b-form-input
                        id="input-1"
                        v-model="name"
                        type="email"
                        :state="errors.nameSate"
                        required
                        placeholder="Enter name"
                    ></b-form-input>
                    <b-form-invalid-feedback>
                        {{ errors.nameMessage }}
                    </b-form-invalid-feedback>
                </b-form-group>

            </div>
            <template v-slot:modal-footer>
                <b-button v-on:click="submitCate">{{ modal.btn }}</b-button>
            </template>
        </b-modal>
    </div>
</template>
<script>
    import Paginate from "vuejs-paginate";

    const table_collumns = [
        'account.users.#',
        'account.users.name',
        'account.users.action',
    ];
    const table_index = [
        '#',
        'name',
    ];

    export default {
        name: "CateNews",
        components: {
            Paginate
        },
        data() {
            return {
                totalPage: 0,
                currentPage: 1,
                modal: {
                    title: null,
                    btn: null,
                },
                formLoad: {
                    page: null,
                },
                table: {
                    isNull: null,
                    collumns: [...table_collumns],
                    index: [...table_index],
                    data: [],
                },
                name: null,
                formData: {
                    id: null,
                    name: '',
                },
                errors: {
                    nameSate: null,
                    nameMessage: null,
                }
            };
        },
        watch: {
            name: function (val) {
                this.formData.name = val;
                this.errors.nameSate = null
            },
        },
        created() {
            this.firstLoad();
        },
        methods: {
            firstLoad() {
                this.formLoad.page = this.currentPage;
                axios.post('news/getListCate', this.formLoad).then(response => {
                    this.totalPage = response.data.data.total_page;
                    if (response.data.data.lists.length > 0) {
                        this.table.data = response.data.data.lists;
                        this.table.isNull = null;
                    } else {
                        this.table.isNull = 'không có cate';
                    }
                }).catch(err => {
                    console.log(err)
                })
            },
            tableIndex(index, key) {
                switch (key) {
                    case table_index[0]: {
                        return 10 * (this.currentPage - 1) + index + 1;
                    }
                    default: {
                        return this.table.data[index][key];
                    }
                }
            },
            CreateNew() {
                this.formData.id = null;
                this.name = null;
                this.modal.title = 'Thêm Mới';
                this.modal.btn = 'Tạo';
                this.$bvModal.show('create-modal');
            },
            EditCate(index) {
                let obj = this.table.data[index];
                this.formData.id = obj.cate_id;
                this.name = obj.name;
                this.modal.title = 'Sửa ' + obj.name;
                this.modal.btn = 'Sửa';
                this.$bvModal.show('create-modal');
            },
            submitCate() {
                let type = null;
                if (this.formData.id === null) {
                    type = 'news/createCate';
                } else {
                    type = 'news/editCate/' + this.formData.id;
                }
                axios.post(type, this.formData).then(response => {
                    this.$bvModal.hide('create-modal');
                    this.firstLoad();
                }).catch(err => {
                    const {data} = err.response;
                    if (typeof data.errors === 'object') {
                        $.each(data.errors, (key, value) => {
                            this.errors[key + 'Sate'] = false;
                            this.errors[key + 'Message'] = value[0];
                        });
                    } else {
                        alert(data.message);
                    }
                });
            },
            DeleteCate(index) {
                let obj = this.table.data[index];
                this.$swal({
                    title: 'Are you sure?',
                    text: obj.name,
                    showCancelButton: true,
                    confirmButtonText: 'Yes Delete it!',
                    cancelButtonText: 'No, Keep it!',
                    showCloseButton: true,
                }).then((result) => {
                    if (result.value) {
                        axios.post('news/deleteCate/' + obj.cate_id).then(response => {
                            this.firstLoad();
                        }).catch(err => {
                            const {data} = err.response;
                            alert(data.message);
                        })
                        this.$swal('Deleted', 'You successfully deleted this file', 'success')
                    } else {
                        this.$swal('Cancelled', 'Your file is still intact', 'info')
                    }
                })
            }
        }
    }
</script>
<style scoped>
</style>
