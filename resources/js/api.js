import axios from 'axios'

const api = axios.create({
    baseURL: '',
    timeout: 0,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
});

export default api