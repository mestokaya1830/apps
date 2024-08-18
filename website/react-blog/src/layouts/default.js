import React from 'react'
import { Outlet } from 'react-router-dom'
import Navbar from '../components/navbar.js'
export default function Default() {
  return (
    <div>
      <Navbar />
      <main className='router'>
        <Outlet />
      </main>
    </div>
  )
}
