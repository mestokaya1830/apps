import { HelmetProvider } from 'react-helmet-async'
import { createRoot } from 'react-dom/client'
import './index.css'
import Router from './router/index.jsx'
import { Provider } from 'react-redux'
import { store } from './store/index.jsx'
import { PersistGate } from 'redux-persist/integration/react'
import { persistStore } from 'redux-persist'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'

const persistor = persistStore(store)
createRoot(document.getElementById('root')).render(
  <HelmetProvider>
    <Provider store={store}>
      <PersistGate persistor={persistor}>
        <Router />
      </PersistGate>
    </Provider>
  </HelmetProvider>,
)