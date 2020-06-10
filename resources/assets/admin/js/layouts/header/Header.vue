<template>
    <header class="main-header">
        <!-- Logo -->
        <a  :href="clientLink" target="_blank" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>H</b>ĐK</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Hà </b>Đức Kiên</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="">
            <!-- Sidebar toggle button-->
            <b-navbar toggleable="lg" type="dark" variant="">
                <b-navbar-brand href="#" data-toggle="push-menu" role="button"><i class="fa fa-bars" aria-hidden="true"></i></b-navbar-brand>

                <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

                <b-collapse id="nav-collapse" is-nav>

                    <!-- Right aligned nav items -->
                    <b-navbar-nav class="ml-auto">


                        <b-nav-item-dropdown text="Lang" right>
                            <b-dropdown-item href="#" v-on:click="changeLanguage('vi')">VI</b-dropdown-item>
                            <b-dropdown-item href="#" v-on:click="changeLanguage('en')">EN</b-dropdown-item>
                        </b-nav-item-dropdown>

                        <b-nav-item-dropdown right>
                            <!-- Using 'button-content' slot -->
                            <template v-slot:button-content>
                                <em>{{ userName }}</em>
                            </template>
                            <b-dropdown-item href="#">Profile</b-dropdown-item>
                            <b-dropdown-item href="logoutAdmin">Sign Out</b-dropdown-item>
                        </b-nav-item-dropdown>
                    </b-navbar-nav>
                </b-collapse>
            </b-navbar>
        </nav>
    </header>
</template>

<script>
    export default {
        name: "AppHeader",
        data() {
            return {
                language: this.$i18n.locale
            };
        },
        methods: {
            changeLanguage(lang) {
                localStorage.setItem('language', lang);
                this.$i18n.locale = lang;
                axios.get('change-language/'+lang);
            }
        },
        beforCreate() {
            this.$i18n.locale = localStorage.getItem('language');
        },
    };
</script>
<style scoped>
    .logo{
        background: none !important;
    }
</style>
