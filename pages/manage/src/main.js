// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import Request from './utils/request'
import Util from './utils/util'
import Url from './configs/url'

Vue.use(ElementUI)
// Utils
Vue.use(Request)
Vue.use(Util)

// Config
Vue.use(Url)

import Pages from './components/page.vue'
import Search from './components/search.vue'
import PageInfo from './components/pageInfo.vue'
import ButtonDelete from './components/buttonDelete.vue'
import Upload from './components/upload.vue'

Vue.component('pages', Pages)
Vue.component('search', Search)
Vue.component('page-info', PageInfo)
Vue.component('button-delete', ButtonDelete)
Vue.component('upload', Upload)


Vue.config.productionTip = false

const app = new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
