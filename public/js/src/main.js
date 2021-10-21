import Vue from 'vue'

require('./globalCmp')

import 'vuesax/dist/vuesax.css'
import 'material-icons/iconfont/material-icons.css'
import Vuesax from "vuesax"
Vue.use(Vuesax)

import axios from "./plugins/axios"
Vue.prototype.$axios = axios

import router from './router'


new Vue({
  el: '#app',
  router
})
