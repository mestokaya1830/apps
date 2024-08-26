import { NavLink } from "react-router-dom"
import { useSelector } from "react-redux"

export default function Navbar() {
  const auth = useSelector(state => state.auth.value)
  return (
    <>
      <nav className="navbar">
        <NavLink to="/" className="links">Home</NavLink>
        {
        auth === "" ? 
        <div>
          <NavLink to="/login" className="links">Login</NavLink>
          <NavLink to="/register" className="links">Register</NavLink>
        </div>
        :
        <div className="links">{auth}</div>
        }
      </nav>
    </>
  )
}
