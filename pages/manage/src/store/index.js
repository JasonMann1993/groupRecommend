import Vue from 'vue'
import Vuex from 'vuex'
import router from '../router'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        user: {},
        token: null,
        menu: {
            collapse: false
        }
    },
    mutations: {
        login(state, {data, type}) {
            localStorage.login_type = type ? type : 'user';
            localStorage.token = data;
            state.token = data
        },
        logout(state, data) {
            localStorage.removeItem('token');
            state.token = null
            if (localStorage.login_type == 'shop')
                router.replace({path: '/shop_login',})
            else
                router.replace({path: '/login',})
        },
        changeMenuType(state) {
            localStorage.menu_collapse = !state.menu.collapse;
            state.menu.collapse = !state.menu.collapse
        },
        initMenu(state) {
            console.log(localStorage.menu_collapse)
            if (localStorage.menu_collapse == 'true')
                state.menu.collapse = true
        },
        upUser(state, data) {
            state.user = data
        },
    },
    actions: {
        changeMenuType({commit}) {
            commit('changeMenuType')
        },
        initMenu({commit}) {
            commit('initMenu')
        },
        upUser(action, data) {
            action.commit('upUser', data)
        }
    }
})