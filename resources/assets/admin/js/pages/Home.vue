<template>
    <div class="root">
        <b-row>
            <b-col sm="12" md="3">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ data.users }}</h3>

                        <p>{{ $t('home.users') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <router-link to="/User-List" class="small-box-footer">{{ $t('home.more') }} <i class="fa fa-arrow-circle-right"></i></router-link>
                </div>
            </b-col>
            <b-col sm="12" md="3">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ data.news }}</h3>

                        <p>{{ $t('home.news') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                    </div>
                    <router-link to="/News-List" class="small-box-footer">{{ $t('home.more') }} <i class="fa fa-arrow-circle-right"></i></router-link>
                </div>
            </b-col>
            <b-col sm="12" md="3">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ data.exams }}</h3>

                        <p>{{ $t('home.exams') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    </div>
                    <a href="#" class="small-box-footer">{{ $t('home.more') }} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </b-col>
            <b-col sm="12" md="3">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ data.users }}</h3>

                        <p>{{ $t('home.users') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <router-link to="/User-List" class="small-box-footer">{{ $t('home.more') }} <i class="fa fa-arrow-circle-right"></i></router-link>
                </div>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    export default {
        name: "Home",
        data(){
            return {
               data: 0,
            }
        },
        created() {
            console.log(this.$route);
            this.firstLoad();
        },
        methods: {
            firstLoad(){
                axios.post('home/getHome').then(response =>{
                    let {data} = response;
                    this.data = data;
                    console.log(data)
                }).catch(err => {
                    console.log(err);
                });
            },
        }
    }
</script>

<style scoped>

</style>
