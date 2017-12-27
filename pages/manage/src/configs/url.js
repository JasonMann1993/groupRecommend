import env from '../../.env'

const api = {
    /**
     * Api List
     */
    user: {  // User
        login: '/manage/login',
        member: '/manage/user/member',
        info: '/manage/user/info',
        token_refresh: '/token_refresh'
    },
    home: {
        menus: '/manage/menus',
        menu: '/manage/home/menu',
        banner: '/manage/home/banner',
        upload: env.API_BASE_URL + '/manage/upload',
        group: '/manage/user/group',
        shop: '/manage/user/business',
        group_search: '/manage/user/group/search',
        shop_search: '/manage/user/business/search',
        user_search: '/manage/user/member/search',

        map_key: '/manage/map_key'
    },
    /*
     * register to vue
     * @param vue
     */
    install(Vue) {
        Vue.prototype.$url = this
    }
}

export default api

