require('./bootstrap');

// 导入扩展包
window.Vue = require('vue');

import App from './app.vue'
import VueRouter from 'vue-router';
import iView from 'iview';
import 'iview/dist/styles/iview.css';


import Product from './components/pro'
import Order from './components/order'


// 导入vue
Vue.use(iView);
Vue.use(VueRouter);

// 路由配置
const RouterConfig = {
    routes: [
        // ExampleComponent laravel默认的示例组件
        { path: '/', component: Product },
        { path: '/order', component: Order },
    ]
};

const router = new VueRouter(RouterConfig);

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App)
});
