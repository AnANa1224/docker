<template>
    <div id="app">
        <!-- wrapper -->
        <div id="wrapper">

            <!-- navbar -->
            <nav class="navbar navbar-default navbar-fixed-top" style="z-index: 666">
                <div class="brand">
                    <a href="index.html">
                        Product<span>Admin</span>
                    </a>
                </div><!--/.brand -->
                <div class="container-fluid">
                    <div class="navbar-btn">
                        <button type="button" class="btn-toggle-fullwidth">
                            <i class="lnr lnr-arrow-left-circle"></i>
                        </button>
                    </div><!--/.navbar-btn -->
                    <form class="navbar-form navbar-left">
                        <div class="search-group">
                            <button type="button"><i data-feather="search"></i></button>
                            <input type="text" value="" placeholder="Search..">
                        </div><!--/.search-group -->
                    </form><!--/form -->
                    <div class="navbar-menu">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="/assets/images/parson.png" class="img-circle" alt="parson-img">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div><!--/.container-fluid -->

            </nav><!--/nav -->
            <!-- END NAVBAR -->

            <!-- LEFT SIDEBAR -->
            <div id="sidebar-nav" class="sidebar">
                <div class="sidebar-scroll">
                    <nav>
                        <ul class="nav">
                            <li :class="active === '' ? 'active' : ''">
                                <a @click="local(''),active = ''"><i data-feather="home"></i> <span>Categorys</span></a>
                            </li>
                            <li :class="active === 'product' ? 'active' : ''">
                                <a @click="local('product'),active = 'product'"><i data-feather="package"></i> <span>Products</span></a>
                            </li>
                            <li :class="active === 'navigation' ? 'active' : ''">
                                <a @click="local('navigation'),active = 'navigation'"><i data-feather="package"></i> <span>Navigation</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- END LEFT SIDEBAR -->

            <router-view/>

        </div>
        <!-- END WRAPPER -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                active:'',
                path:'',
            }
        },
        mounted() {
            let path = this.$route.fullPath.split('?')[0];
            this.path = path;
            if (path === '/' || path === '/detailCategory'  || path === '/editCategory'  || path === '/createCategory') {
                this.active = '';
            } else if (path === '/product' || path === '/detailProduct'  || path === '/editProduct'  || path === '/createProduct') {
                this.active = 'product';
            } else if (path === '/navigation' || path === '/detailNav'  || path === '/editNav'  || path === '/createNav') {
                this.active = 'navigation';
            }
        },
        methods: {
            local(uri){
                let path = this.path;
                if (this.path[0] === '/') {
                    let path = this.path.split('/')[1];
                }
                if (path === '/'+uri) {
                    return false;
                }
                this.$router.push({path:'/'+uri});
            }
        },
        computed: {
            menuitemClasses: function () {
                return [
                    'menu-item',
                    this.isCollapsed ? 'collapsed-menu' : ''
                ]
            }
        }
    }
</script>

<style scoped>


</style>
