import React from 'react'
import { NavLink } from 'react-router-dom'

export default function navbar() {
  return (
    <div className='navbar'>
      <div>
        <NavLink to="/" className="links">Home</NavLink>
        <NavLink to="/about" className="links">About</NavLink>
        <NavLink to="/contact" className="links">Contact</NavLink>
      </div>
      <div>
        <NavLink to="/register" className="links">Register</NavLink>
        <NavLink to="/login" className="links">Login</NavLink>
      <div className="dropdown">
        <NavLink to="/user/posts" className="links">Username</NavLink>
        <img src="https://picsum.photos/200/300" alt="" className="btn btn-secondary dropdown-toggle"
          id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" />

        <ul className="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li><a className="dropdown-item" href="/user/posts">Posts</a></li>
          <li>
            <button type="submit" className="dropdown-item">Logout</button>
          </li>
        </ul>
      </div>
      </div>
    </div>
  )
}
