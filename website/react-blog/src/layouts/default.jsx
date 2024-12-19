import { Outlet } from "react-router-dom"
import Navbar from '../components/navbar.jsx'

export default function Default() {
  return (
    <>
    <Navbar />
      <main className="router">
        <Outlet />
      </main>
    </>
  )
}
