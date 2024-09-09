import React from 'react'
import { createBrowserRouter, RouterProvider } from 'react-router-dom'
import RouteGuard from '../components/routeGuard.jsx'

//layouts
import DefaultLayout from '../layouts/default.jsx'
import AdminLayout from '../layouts/admin.jsx'

//auth
const Register  = React.lazy(() => import('../views/auth/register.jsx'))
const Login  = React.lazy(() => import('../views/auth/login.jsx'))
const EmailVerfication  = React.lazy(() => import('../views/auth/email-verfication.jsx'))
const ResetPassword  = React.lazy(() => import('../views/auth/reset-password.jsx'))

//client
import Home from '../views/client/index.jsx'
const UserPosts  = React.lazy(() => import('../views/client/user-posts.jsx'))
const Details  = React.lazy(() => import('../views/client/details.jsx'))

//admin
const Dashboard  =  React.lazy(() => import('../views/admin/index.jsx'))
const Create  = React.lazy(() => import('../views/admin/create.jsx'))
const AdminDetails =  React.lazy(() => import('../views/admin/details.jsx'))
const Edit =  React.lazy(() => import('../views/admin/edit.jsx'))

//global
const Notfound  =  React.lazy(() => import('../views/notfound.jsx'))

export default function index() {
  const router = createBrowserRouter([
    {
      path: '/',
      element: <DefaultLayout/>,
      children: [
        {
          path: '/',
          element: <Home />
        },
        {
          path: "/user-posts",
          element: <React.Suspense fallback="Loading..."><UserPosts /></React.Suspense>
        },
        {
          path: "/user/:id",
          element: <React.Suspense fallback="Loading..."><Details /></React.Suspense>
        },
        {
          path: "/register",
          element: <React.Suspense fallback="Loading..."><Register /></React.Suspense>
        },
        {
          path: "/login",
          element: <React.Suspense fallback="Loading..."><Login /></React.Suspense>
        },
        {
          path: "/email-verfication",
          element: <React.Suspense fallback="Loading..."><EmailVerfication /></React.Suspense>
        },
        {
          path: "/reset-password",
          element: <React.Suspense fallback="Loading..."><ResetPassword /></React.Suspense>
        },
      ]
    },
    {
      path: '/admin',
      element : <RouteGuard><AdminLayout /></RouteGuard>,
      children: [
        {
          path:'/admin',
          element: <React.Suspense fallback="Loading..."><Dashboard /></React.Suspense>
        },
        {
          path:'/admin/create',
          element: <React.Suspense fallback="Loading..."><Create /></React.Suspense>
        },
        {
          path:'/admin/post/:id',
          element: <React.Suspense fallback="Loading..."><AdminDetails /></React.Suspense>
        },
        {
          path:'/admin/post/edit/:id',
          element: <React.Suspense fallback="Loading..."><Edit /></React.Suspense>
        }
      ]
    },
    {
      path: '*',
      element: <React.Suspense fallback="Loading..."><Notfound /></React.Suspense>
    }
  ])
  return (
    <>
      <RouterProvider router={router} />
    </>
  )
}
