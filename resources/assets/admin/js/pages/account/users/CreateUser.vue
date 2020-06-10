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
                        <div class="col-md-12">
                            <div class="form-group">
                                <b-container fluid>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>{{ $t('form.createUser.name') }} <span class="text-danger">(*)</span>
                                                :</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input
                                                :state="errors.nameSate"
                                                v-model="name"
                                                type="text"></b-form-input>
                                            <b-form-invalid-feedback>
                                                {{ errors.nameMessage }}
                                            </b-form-invalid-feedback>
                                        </b-col>
                                    </b-row>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>{{ $t('form.createUser.email') }}<span class="text-danger">(*)</span>:</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input
                                                :state="errors.emailSate"
                                                v-model="email"
                                                type="email"></b-form-input>
                                            <b-form-invalid-feedback>
                                                {{ errors.emailMessage }}
                                            </b-form-invalid-feedback>
                                        </b-col>
                                    </b-row>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>{{ $t('form.createUser.password') }}<span
                                                class="text-danger">(*)</span>:</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input
                                                :state="errors.passwordSate"
                                                v-model="password"
                                                type="password"></b-form-input>
                                            <b-form-invalid-feedback>
                                                {{ errors.passwordMessage }}
                                            </b-form-invalid-feedback>
                                        </b-col>
                                    </b-row>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>{{ $t('form.createUser.rePassword') }}<span
                                                class="text-danger">(*)</span>:</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input
                                                :state="errors.repasswordSate"
                                                v-model="repassword"
                                                type="password"></b-form-input>
                                            <b-form-invalid-feedback>
                                                {{ errors.repasswordMessage }}
                                            </b-form-invalid-feedback>
                                        </b-col>
                                    </b-row>
                                    <hr>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>{{ $t('form.createUser.phone') }}:</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-input
                                                v-model="formData.phone"
                                                type="text"></b-form-input>
                                        </b-col>
                                    </b-row>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>{{ $t('form.createUser.gender') }}:</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-select v-model="formData.gender" class="mb-3">
                                                <b-form-select-option value="0">{{ $t('gender.female') }}
                                                </b-form-select-option>
                                                <b-form-select-option value="1">{{ $t('gender.male') }}
                                                </b-form-select-option>
                                                <b-form-select-option value="2">{{ $t('gender.lgbt') }}
                                                </b-form-select-option>
                                            </b-form-select>
                                        </b-col>
                                    </b-row>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>{{ $t('form.createUser.birthDay') }}:</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-datepicker id="example-datepicker" v-model="birthday"
                                                               class="mb-2"></b-form-datepicker>
                                        </b-col>
                                    </b-row>
                                    <b-row class="my-1">
                                        <b-col sm="3">
                                            <label>{{ $t('form.createUser.avatar') }}:</label>
                                        </b-col>
                                        <b-col sm="9">
                                            <b-form-file
                                                placeholder="Choose a file or drop it here..."
                                                drop-placeholder="Drop file here..."
                                                v-on:change="uploadFile"
                                            ></b-form-file>
                                            <img :src="formData.avatar" width="50%" alt="">
                                        </b-col>
                                    </b-row>
                                </b-container>
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
        name: "CreateUser",
        data() {
            return {
                errors: {
                    nameSate: null,
                    nameMessage: null,
                    emailSate: null,
                    emailMessage: null,
                    passwordSate: null,
                    passwordMessage: null,
                    repasswordSate: null,
                    repasswordMessage: null,
                },
                name: null,
                email: null,
                password: null,
                repassword: null,
                birthday:null,
                formData: {
                    name: null,
                    email: null,
                    password: null,
                    repassword: null,
                    phone: null,
                    gender: null,
                    birthday: null,
                    avatar: null,
                },
            }
        },
        watch: {
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
            birthday: function (val) {
                let day = new Date(val);
                this.formData.birthday = day.valueOf()
            }
        },
        methods: {
            uploadFile(e) {
                let files = e.target.files || e.dataTransfer.files;
                let arrayType = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!arrayType.includes(files[0].type)) {
                    e.target.value = '';
                } else {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.formData.avatar = e.target.result;
                    }
                    reader.readAsDataURL(files[0]);
                }
            },
            onSubmit() {
                axios.post('adminAccount/createUser', this.formData).then(response => {
                    this.$router.push('/User-List');
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
