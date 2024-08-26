import { configureStore } from '@reduxjs/toolkit'
import authSlice from './authSlice.jsx'

export default configureStore({
  reducer: {
    auth: authSlice
  }
})