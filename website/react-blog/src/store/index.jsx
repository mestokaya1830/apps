import { configureStore } from "@reduxjs/toolkit";
import authSlice from "./authSlice.jsx";
import storage from "redux-persist/lib/storage";
import { combineReducers } from "@reduxjs/toolkit";
import persistReducer from "redux-persist/es/persistReducer";

const persistConfig = {
  key: "root",
  version: 1,
  storage,
};
const reducer = combineReducers({
  auth: authSlice,
});

export const store = configureStore({
  reducer: persistReducer(persistConfig, reducer),
  middleware: (getDefaultMiddleware) =>
    getDefaultMiddleware({
      serializableCheck: false,
    }),
});
