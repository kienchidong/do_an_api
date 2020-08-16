<template>
    <div class="root">
        <span v-on:click="editRole"> <i class="fa fa-edit"></i> edit Role</span>

        <b-modal v-model="modalShow">
            <b-form-checkbox-group id="checkbox-group-2" v-model="formData.permissions" name="flavour-2" stacked>
                <b-form-checkbox v-for="(per, index) in listPermission" :key="index" :value="per.id">{{ $t(per.name) }}
                </b-form-checkbox>
            </b-form-checkbox-group>
            <template v-slot:modal-footer>
                <b-button v-on:click="submitPermission">Sửa Quyền</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
    export default {
        name: "RoleComponent",
        props: ['users'],
        data() {
            return {
                modalShow: false,
                formData: {
                    id: null,
                    permissions: [],
                },
                listPermission: [],
            }
        },
        methods: {
            editRole() {
                this.userHaspermission();
                this.getListPermission();
                this.modalShow = true;
            },
            userHaspermission() {
                axios.get('/adminAccount/adminHasPermission/' + this.users.id).then(response => {
                    this.formData.permissions = response.data;
                })
            },
            getListPermission() {
                axios.get('/adminAccount/getPermissions/' + this.users.role).then(response => {
                    this.listPermission = response.data;
                })
            },
            submitPermission() {
                this.formData.id = this.users.id;
                axios.post('/adminAccount/setPermission/', this.formData).then(response => {
                    alertify.success('thành công');
                    this.modalShow = false;
                }).catch(err => {
                    console.log(err.response);
                })
            }
        }
    }
</script>

<style scoped>

</style>
