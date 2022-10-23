import { createApp } from 'vue'
import App from './App'
import router from './router'
import store from './store'
import Notifications from '@kyvg/vue3-notification'
import '@fortawesome/fontawesome-free/css/all.css'

const app = createApp(App)

store.dispatch('Settings/get').then(settings => {
  app.mixin({
    methods: {
      hasPermissions (permissions) {
        if (typeof permissions === 'object') {
          return permissions.some(permission => !settings.permissions?.[permission]?.disabled || false)
        } else {
          return !settings.permissions?.[permissions]?.disabled || false
        }
      },
      config (key) {
        return settings.config[key] || null
      },
      user (key) {
        return settings.user[key] || null
      },
      lang (key, def) {
        return settings.lexicon[key] || def
      }
    }
  })
  app.use(store)
  app.use(router)
  app.use(Notifications)
  app.mount('#app')
})
