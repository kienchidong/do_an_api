<template>
    <div class="root">
        <b-modal v-model="show" :title="title">
            <b-form-group
                label="Name"
            >
                <b-form-input v-model="name" trim></b-form-input>
            </b-form-group>
            <b-form-group
                label="Link"
            >
                <b-form-input v-model="link" trim></b-form-input>
            </b-form-group>
            <b-form-group
                label="type"
            >
                <b-form-select v-model="type" class="mb-3">
                    <b-form-select-option v-for="(item, index) in list_type" :key="index" :value="item.id">{{ item.name }}</b-form-select-option>
                </b-form-select>
            </b-form-group>
            {{ formData }}
            <template v-slot:modal-footer>
                <b-button v-on:click="submitForm">submit</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
    export default {
        name: "CreateVideo",
        props: {
            videoDetail: {
                type: Object,
                require: false
            },
        },
        data() {
            return {
                show: false,
                name: null,
                type: null,
                link: null,
                id: null,
                id_video: null,
                list_type: [],
                title: 'Thêm Video'
            }
        },
        watch:{
            show:function(val){
                if(val== false){
                    this.$emit('done');
                }
            },
            link: function(val){
                var youtube = 'https://www.youtube.com/watch?v=';
                var ktra = val.indexOf(youtube);
                if(ktra == 0) {
                    var start = val.indexOf('=') + 1;
                    var end = val.indexOf('&');
                    if (end == -1) {
                        end = val.length;
                    }
                    this.id_video = val.substring(start, end);
                }
            },
        },
        computed: {
            formData: function () {
                return {
                    'id': this.id,
                    'name': this.name,
                    'id_video': this.id_video,
                    'type_id': this.type,
                }
            },
        },
        created() {
            if(this.videoDetail.id != undefined) {
                this.title = 'Sửa Video';
                this.id = this.videoDetail.id;
            }
            this.show = true;
            this.getType();
        },
        methods:{
            getType(){
                axios.post('typeVideo/getList').then(response => {
                    if (response.data.data.lists.length > 0) {
                        this.list_type = response.data.data.lists;
                    }
                }).catch(err => {
                    console.log(err)
                })
            },
            submitForm(){
                axios.post('video/store', this.formData).then(response => {
                    this.$emit('done');
                }).catch(err => {
                    console.log(err)
                })
            }
        }
    }
</script>

<style scoped>

</style>
