import Vue from 'vue'
import Router from 'vue-router'
import store from './store'
import app from '@/pages/layouts/app'
import shop_app from '@/pages/layouts/shop'
// Home
import home_index from '@/pages/home/index'
import home_menu from '@/pages/home/menu'
import home_argument from '@/pages/home/argument'
// Banner
import home_banner from '@/pages/home/banner'
// Base
import base_login from '@/pages/base/login'
// User
import user_index from '@/pages/user/index'
// ---- Coupon ----
import coupon_index from '@/pages/coupon/index'
// comment
import coupon_comment from '@/pages/coupon/comment'
import coupon_order from '@/pages/coupon/order'

// --- Logs ---
import log_index from '@/pages/log'
import log_shop from '@/pages/log/shop'

// ---- Shop Coupon ----
import shop_coupon_index from '@/pages/shop/coupon/index'
import shop_home_qr_code from '@/pages/shop/home/qrCode'
import shop_home_store from '@/pages/shop/home/store'

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
            {path: 'user', component: user_index},
            // banner
            {path: 'home/banner', component: home_banner},
            // argument
            {path: 'home/argument', component: home_argument},
            // Coupon
            // Coupon Index
            {path: 'coupon', component: coupon_index},
            // Comment
            {path: 'coupon/comment', component: coupon_comment},
            // Order
            {path: 'coupon/order', component: coupon_order},
            // Log
            {path: 'logs', component: log_index},
            {path: 'log/shop', component: log_shop},

        ],
    },
    {
        path: '/shop',
        component: shop_app,
        meta: {
            auth: true
        },
        children: [
            // Coupon Index
            {path: 'coupon', component: shop_coupon_index},
            {path: 'store', component: shop_home_store},
            {path: 'qr_code', component: shop_home_qr_code},
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
