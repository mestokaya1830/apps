import { NavLink, Link, useNavigate } from "react-router-dom"
import { useSelector, useDispatch } from "react-redux"
import axios from "axios"
import { setAuth } from '../store/authSlice.jsx'

export default function Navbar() {
  const auth = useSelector(state => state.auth.value)
  const navigate = useNavigate()
  const dispatch = useDispatch()

  const logout = () => {
    axios.post('http://localhost:3000/api/logout')
    .then((res) => {
      if(localStorage.getItem('persist:root')){
        localStorage.removeItem('persist:root')
      }
      dispatch(setAuth(""))
      res.status === 200 ? navigate('/login') : ""
    })
    .catch((err) => console.log(err))
  }
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
        <div className="dropdown">
          <Link to="/admin" className="links" exact-active-class="active">{auth}</Link>
          <img src="https://picsum.photos/200/300" alt="" className="btn btn-secondary dropdown-toggle"
            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" />
  
          <ul className="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a className="dropdown-item" href="/admin">Posts</a></li>
            <li>
              <button type="submit" onClick={logout} className="dropdown-item" >Logout</button>
            </li>
          </ul>
        </div>
        }
      </nav>
    </>
  )
}
