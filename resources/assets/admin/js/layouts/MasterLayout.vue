<template>
    <div class="wrapper" style="position: relative">
        <app-header></app-header>
        <app-aside></app-aside>
        <div class="content-wrapper content-bg">
            <section class="content-header">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 bien">
                        <h4>{{ $t(routeName) }}</h4>
                    </div>
                </div>
            </section>
            <section class="content">
                <router-view></router-view>
            </section>
        </div>
        <app-footer></app-footer>
        <app-control-siderbar></app-control-siderbar>
        <div class="control-sidebar-bg"></div>
    </div>
</template>

<script>
    import AppHeader from "./header/Header";
    import AppAside from "./aside/aside";
    import AppFooter from "./footer/Footer";
    import AppControlSiderbar from "./control_siderbar/ControlSiderbar";

    export default {
        name: "MasterLayout",
        components: {
            AppHeader,
            AppAside,
            AppControlSiderbar,
            AppFooter,
        },
        computed: {
            routeName(){
                return this.$route.name;
            }
        }
    }
</script>

<style scoped>
.content-bg{
    background-image: url("../../dist/img/background.jpg");
}
    .bien{
        background: white;
        border: black solid 1px;
        border-radius: 10px;
        text-align: center;
        padding: 1% 0%;
    }
</style>
