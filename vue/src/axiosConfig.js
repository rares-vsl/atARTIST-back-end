import axios from 'axios'
const instance = axios.create({
  baseURL: 'http://api.atartist.it/'
})

instance.interceptors.request.use(function (config) {
  //const token = store.state.authToken
  //config.headers.Authorization = 'Bearer ' + localStorage.getItem('user-token')

  return config
})


export default instance