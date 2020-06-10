<template>
    <div class="root">
        <b-modal v-model="showModal" size="xl" hide-footer title="Level Detail">
           <b-container>
               <div v-html="detail" class="table-responsive"></div>
           </b-container>

        </b-modal>
    </div>
</template>

<script>
    export default {
        name: "LevelDetailComponent",
        props: ['show'],
        data() {
            return {
                showModal: false,
                detail: null,
            }
        },
        watch: {
            show: function (val) {
                this.showModal = val;
            },
            showModal: function(val){
                this.$emit('closeModal', val);
            }
        },
        created(){
          this.getDetail();
        },
        methods:{
            getDetail(){
                axios.get('question/getDetailLevel').then(response => {
                    this.detail = response.data;
                })
            }
        }
    }
</script>

<style scoped>

</style>
