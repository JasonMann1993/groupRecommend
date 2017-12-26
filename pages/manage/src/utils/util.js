import request from './request'
import url from '../configs/url'
import store from '../store'

export default {
    copyObj(obj) {
        return JSON.parse(JSON.stringify(obj))
    },
    compareObj(obj1, obj2) {
        return JSON.stringify(obj1) === JSON.stringify(obj2)
    },
    refreshToken() {
        request.get(url.user.token_refresh).then(res => {
            store.commit('login', {data: res.data, type: localStorage.login_type})
        })
    },
    // Vue Install
    install(Vue) {
        Vue.prototype.$util = this
    }
}