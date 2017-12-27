import Vue from 'vue'
import Router from 'vue-router'
import store from './store'
import app from '@/pages/layouts/app'
// Home
import home_index from '@/pages/home/index'
import home_menu from '@/pages/home/menu'
// Banner
import home_banner from '@/pages/home/banner'
// Base
import base_login from '@/pages/base/login'
// User
import user_index from '@/pages/user/index'
import group_index from '@/pages/group'
import shop_index from '@/pages/shop'



Vue.use(Router)

const routes = [
    {
        path: '/',
        component: app,
        meta: {
            auth: true
        },
        children: [
            {path: '', component: home_index},
            {path: 'menus', component: home_menu},
            // User
            {path: 'user/member', component: user_index},
            {path: 'user/group', component: group_index},
            {path: 'user/business', component: shop_index},
            // banner
            {path: 'home/banner', component: home_banner},

        ],
    },
    {path: '/login', component: base_login},
]

// 页面刷新时，重新赋值token
if (localStorage.getItem('token')) {
    store.commit('login', {data: localStorage.getItem('token')})
}

const router = new Router({
    mode: 'history',
    base: 'manage',
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(r => r.meta.auth)) {
        if (store.state.token) {
            next();
        } else {
            next({
                path: '/login',
                query: {redirect: to.fullPath}
            })
        }
    } else {
        next();
    }
})
export default router
