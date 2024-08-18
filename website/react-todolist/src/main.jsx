import { createRoot } from 'react-dom/client'
import './index.css'
import Router from './router/index.jsx'
import { store } from './store/index.jsx'
import { Provider } from 'react-redux'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.js'

createRoot(document.getElementById('root')).render(
  <Provider store={store}>
    <Router />
  </Provider>,
)
