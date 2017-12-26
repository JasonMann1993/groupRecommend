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
        argument: '/argument',

        log: {
            top_up: '/log/top_up',
            buy: '/log/buy',
            payoff: '/log/payoff'
        },
        map_key: '/map_key'
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

