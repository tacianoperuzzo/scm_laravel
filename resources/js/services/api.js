import axios from 'axios';

const api = axios.create({
    baseURL: window.location.origin+'/',
    headers: {
      'Content-Type': 'application/json'
    },
})

api.interceptors.request.use(function (config) {
   return config
}, (error) => {
   return Promise.reject(error)
})

api.interceptors.response.use(function (response) {
    return response
}, async (error) => {
    return Promise.reject(error)
})

export default api
