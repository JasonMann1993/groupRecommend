import Axios from 'axios'
import config_url from '../configs/url'
import config_axios from '../configs/axios'
import ElementUI from 'element-ui'
import store from '../store'
import env from '../../.env'

config_axios.baseURL = env.API_BASE_URL
let axiosIns = Axios.create(config_axios)

// Start Request
axiosIns.interceptors.request.use(function (config) {
    // config.baseURL = env.API_BASE_URL
    config.headers.Authorization = 'Bearer ' + store.state.token
    return config
}, function (error) {
    return Promise.reject(error);
});


/** Response */
axiosIns.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    console.log(error)
    handleRequest.response.error(error)
    return Promise.reject(error);
});

let handleRequest = {
    response: {
        error: function (error) {
            if (handleCode[error.response.status])
                handleCode[error.response.status](error);
        },
    }
}

let handleCode = {
    401: function (error) {
        ElementUI.Message.warning('登录已过期，请重新登录')
        store.commit('logout');
    },
    422: function (error) {
        let msg = Object.values(error.response.data.errors)[0][0]
        ElementUI.Message.warning(msg)
    },
    405: function (error) {
        ElementUI.Message.error("系统错误，请重试")
    }
}

export default Object.assign({
    install(Vue) {

        Vue.prototype.$request = this
    }
}, axiosIns)
