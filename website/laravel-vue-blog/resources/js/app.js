import { createApp } from "vue";
import App from './views/App.vue'
import Router from './router/index.js'

import 'bootstrap/dist/css/bootstrap.min.css'

createApp(App)
.use(Router)
.mount('#app')
