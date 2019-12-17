require('./bootstrap');

// 导入扩展包
window.Vue = require('vue');

import App from './app.vue'
import VueRouter from 'vue-router';
import iView from 'iview';
import 'iview/dist/styles/iview.css';

import Category from './components/Category'
import CreateCategory from './components/CreateCategory'
import EditCategory from './components/EditCategory'
import DetailCategory from './components/DetailCategory'
import Product from './components/Product'
import CreateProduct from './components/CreateProduct'
import EditProduct from './components/EditProduct'
import DetailProduct from './components/DetailProduct'
import Navigation from './components/Navigation'
import CreateNav from './components/CreateNav'
import EditNav from './components/EditNav'
import DetailNav from './components/DetailNav'


// 导入vue
Vue.use(iView);
Vue.use(VueRouter);

// 路由配置
const RouterConfig = {
    routes: [
        // ExampleComponent laravel默认的示例组件
        { path: '/', component: Category },
        { path: '/createCategory', component: CreateCategory },
        { path: '/editCategory', component: EditCategory },
        { path: '/detailCategory', component: DetailCategory },
        { path: '/product', component: Product },
        { path: '/createProduct', component: CreateProduct },
        { path: '/editProduct', component: EditProduct },
        { path: '/detailProduct', component: DetailProduct },
        { path: '/navigation', component: Navigation },
        { path: '/createNav', component: CreateNav },
        { path: '/editNav', component: EditNav },
        { path: '/detailNav', component: DetailNav },
    ]
};

const router = new VueRouter(RouterConfig);

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App)
});
