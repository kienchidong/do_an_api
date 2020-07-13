<template>
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ userName }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION
                <li>
                <router-link to="/"><i class="fa fa-home" aria-hidden="true"></i> <span>Home</span></router-link>
                </li>
                <li>
                    <router-link to="/testVue"><i class="fa fa-text-width" aria-hidden="true"></i> <span>test</span></router-link>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-file-text" aria-hidden="true"></i> <span>News</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <router-link to="/cateNew"><i class="fa fa-bookmark" aria-hidden="true"></i><span>Cate</span></router-link>
                        </li>
                        <li>
                            <router-link to="/News-List"><i class="fa fa-newspaper-o" aria-hidden="true"></i><span>News</span>
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-file-text" aria-hidden="true"></i> <span>Videos</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <router-link to="/type-video.html"><i class="fa fa-bookmark" aria-hidden="true"></i><span>Types of Video</span></router-link>
                        </li>
                        <li>
                            <router-link to="/list-video.html"><i class="fa fa-newspaper-o" aria-hidden="true"></i><span>Videos</span>
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-question-circle-o" aria-hidden="true"></i> <span>Questions</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <router-link to="/List-Simple-Question"><i class="fa fa-bookmark" aria-hidden="true"></i><span>Simple Questions</span></router-link>
                        </li>
                        <li>
                            <router-link to="/List-Group-Question"><i class="fa fa-bookmark" aria-hidden="true"></i><span>Group Questions</span></router-link>
                        </li>
                        <li>
                            <a href="#" v-on:click="showModal = !showModal"><i class="fa fa-bookmark" aria-hidden="true"></i><span>Level Detail</span></a>
                        </li>
                        <level-detail-component :show="showModal" v-on:closeModal="showModal = $event"></level-detail-component>
                    </ul>
                </li>
                <li class="header">LABELS</li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users" aria-hidden="true"></i> <span>Account</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <router-link to="adminAccount"><i class="fa fa-circle-o text-red"></i> <span>Admin Account</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link to="User-List"><i class="fa fa-circle-o text-red"></i> <span>User Account</span>
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li>
                    <router-link to="/list-feedback.html"><i class="fa fa-comments-o text-yellow" aria-hidden="true"></i> <span>Feedback</span></router-link>
                </li>
                <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
    import LevelDetailComponent from "../component/LevelDetailComponent";
    export default {
        name: "AppAside",
        components:{
            LevelDetailComponent,
        },
        data(){
            return {
                showModal: false,
            }
        },
        created() {

        }
    };
</script>
