<template>
    <div class="root">
        <section class="content">
            <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Minimal</label>

                                <b-container fluid>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>{{ $t('account.admins.form.name') }}:</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input :state="errors.nameSate" v-model="name"
                                                          type="text"></b-form-input>
                                            <b-form-invalid-feedback>
                                                {{ errors.nameMessage }}
                                            </b-form-invalid-feedback>
                                        </b-col>
                                    </b-row>
                                </b-container>
                                <b-container fluid>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>{{ $t('account.admins.form.email') }}:</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input :state="errors.emailSate" v-model="email"
                                                          type="email"></b-form-input>
                                            <b-form-invalid-feedback>
                                                {{ errors.emailMessage }}
                                            </b-form-invalid-feedback>
                                        </b-col>
                                    </b-row>
                                </b-container>
                                <b-container fluid>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>{{ $t('account.admins.form.password') }}:</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input :state="errors.passwordSate" v-model="password"
                                                          type="password"></b-form-input>
                                            <b-form-invalid-feedback>
                                                {{ errors.passwordMessage }}
                                            </b-form-invalid-feedback>
                                        </b-col>
                                    </b-row>
                                </b-container>
                                <b-container fluid>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>{{ $t('account.admins.form.repassword') }}:</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input :state="errors.repasswordSate" v-model="repassword"
                                                          type="password"></b-form-input>
                                            <b-form-invalid-feedback>
                                                {{ errors.repasswordMessage }}
                                            </b-form-invalid-feedback>
                                        </b-col>
                                    </b-row>
                                </b-container>
                                <b-container fluid>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>{{ $t('account.admins.form.image') }}:</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-file
                                                placeholder="Choose a file or drop it here..."
                                                drop-placeholder="Drop file here..."
                                                v-on:change="uploadFile"
                                            ></b-form-file>
                                            <img :src="formData.image" width="100%" alt="">
                                        </b-col>
                                    </b-row>
                                </b-container>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Permissions: </label>
                                <b-form-select :state="errors.role_idSate" v-model="role_id" class="mb-3">
                                    <b-form-select-option :value="null">Please select an option
                                    </b-form-select-option>
                                    <b-form-select-option v-for="(item, indexRole) in roles" :key="indexRole"
                                                          :value="item.id">{{ $t(item.name)}}
                                    </b-form-select-option>
                                </b-form-select>
                                <b-form-invalid-feedback>
                                    {{ errors.role_idMessage }}
                                </b-form-invalid-feedback>
                                <hr>
                                <b-form-checkbox-group stacked id="checkbox-group-2" v-model="permission_id"
                                                       name="flavour-2">
                                    <b-form-checkbox v-for="(item, indexPer) in permission" :key="indexPer"
                                                     :value="item.id">{{ $t(item.name)}}
                                    </b-form-checkbox>
                                </b-form-checkbox-group>
                                <div v-if="errors.role_idSate===null && errors.permission_idSate === false"
                                     class="text-danger">{{ errors.permission_idMessage }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <b-button type="submit" variant="primary" v-on:click="onSubmit">Submit</b-button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "CreateAdmin",
        data() {
            return {
                role_id: null,
                permission: [],
                errors: {
                    nameSate: null,
                    nameMessage: null,
                    emailSate: null,
                    emailMessage: null,
                    passwordSate: null,
                    passwordMessage: null,
                    repasswordSate: null,
                    repasswordMessage: null,
                    role_idSate: null,
                    role_idMessage: null,
                    permission_idSate: null,
                    permission_idMessage: null,
                },
                name: null,
                email: null,
                password: null,
                repassword: null,
                roles: [],
                permission_id: [],
                formData: {
                    name: null,
                    email: null,
                    password: null,
                    repassword: null,
                    image: null,
                    role_id: null,
                    permission_id: [],
                }
            }
        },
        watch: {
            role_id: function (val) {
                this.formData.role_id = val;
                this.errors.role_idSate = null;
                this.getPermissionList(val);
            },
            name: function (val) {
                this.formData.name = val;
                this.errors.nameSate = null
            },
            email: function (val) {
                this.formData.email = val;
                this.errors.emailSate = null
            },
            password: function (val) {
                this.formData.password = val;
                this.errors.passwordSate = null
            },
            repassword: function (val) {
                this.formData.repassword = val;
                this.errors.repasswordSate = null
            },
            permission_id: function (val) {
                this.formData.permission_id = val;
                this.errors.role_idSate = null;
                this.errors.permission_idSate = null;
            },
        },
        created() {
            this.getRolesList()
        },
        methods: {
            getRolesList() {
                axios.get('adminAccount/getRoles').then(response => {
                    this.roles = response.data;
                }).catch(error => {
                    console.log(error)
                })
            },
            getPermissionList(role_id) {
                axios.get('adminAccount/getPermissions/' + role_id).then(response => {
                    this.formData.permission_id = [],
                        this.permission = response.data;
                }).catch(error => {
                    console.log(error)
                })
            },
            uploadFile(e) {
                let files = e.target.files || e.dataTransfer.files;
                let arrayType = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!arrayType.includes(files[0].type)) {
                    e.target.value = '';
                } else {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.formData.image = e.target.result;
                    }
                    reader.readAsDataURL(files[0]);
                }
            },
            onSubmit() {
                axios.post('adminAccount/createAdmin', this.formData).then(response => {
                    this.$router.push('/adminAccount');
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
                })
            }

        }
    }
</script>

<style scoped>

</style>
