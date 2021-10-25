const axios = require('axios')
const qs = require('qs')

const instance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
   },
   paramsSerializer: function (params) {
    return qs.stringify(params, { encode: false })
  },
})

export default instance