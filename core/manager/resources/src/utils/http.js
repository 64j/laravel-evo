// import store from '@/store'
// import router from '@/router'
import { toRaw } from 'vue'

export default {
  baseUrl: localStorage['EVO.HOST'] || '',

  setUrl () {
    return this.baseUrl + 'manager/'
  },

  setBody (body) {
    if (!body) {
      return null
    }
    body = body || {}
    if (typeof body !== 'string') {
      body = JSON.stringify(toRaw(body))
    }
    return body
  },

  setHeaders (headers) {
    return Object.assign({
      'Cache': 'no-cache',
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + localStorage['EVO.TOKEN'] || '',
    }, headers || {})
  },

  handlerResponse (response) {
    if (response.ok) {
      return response.json()
    }

    // if (response.status !== 404) {
    //   if (location.hash !== '#/login') {
    //     store.dispatch('Settings/del').then(() => {
    //       store.dispatch('MultiTabs/delAllTabs').then(() => {
    //         router.push({ name: 'AuthLogin' })
    //       })
    //     })
    //   }
    // }

    return {}
  },

  handlerCatch (error) {
    return {
      errors: [error.message || '']
    }
  },

  fetch (method, url, body) {
    if (method === 'get') {
      body = null
    } else {
      body = {
        method: url,
        params: body || []
      }
    }
    return fetch(this.setUrl(), {
      method: method,
      body: this.setBody(body || ''),
      headers: this.setHeaders(),
      credentials: 'same-origin'
    }).then(this.handlerResponse).catch(this.handlerCatch)
  },

  get (url) {
    return this.fetch('get', url)
  },

  post (url, body) {
    return this.fetch('post', url, body)
  },

  read (method, data) {
    return this.fetch('post', method + '@read', data)
  },

  create (method, data) {
    return this.fetch('post', method + '@create', data)
  },

  update (method, data) {
    return this.fetch('post', method + '@update', data)
  },

  delete (method, data) {
    return this.fetch('post', method + '@delete', data)
  },

  copy (method, data) {
    return this.fetch('post', method + '@copy', data)
  },

  list (method, data) {
    return this.fetch('post', method + '@list', data)
  },

  login (data) {
    data = Object.assign(data, {
      method: 'Auth@login'
    })
    return fetch(this.setUrl(), {
      method: 'put',
      body: this.setBody(data || ''),
      headers: this.setHeaders(),
      credentials: 'same-origin'
    }).then(this.handlerResponse).catch(this.handlerCatch)
  }
}
