import axios from 'axios'

const apiClient = axios.create({
  baseURL: 'http://localhost/api',
  headers: {
    'Accept': 'application/json',
  },
})

export default apiClient
