import React from 'react'
import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import axios from 'axios'

export default function Register() {
  const [data, setData] = useState({
    username: '',
    email: '',
    password: '',
    confirmPassword: ''
  })
  const [error, setError] = useState({
    username: '',
    email: '',
    password: '',
    confirmPassword: '',
    duplicate:''
  })

  let navigate = useNavigate()

  const handelInputs = (e) => {
    setData(values => ({ ...values, [e.target.name]: e.target.value }))
  }
  const createUser = (e) => {
    e.preventDefault()
    if (data.password === data.confirmPassword) {
      axios.post('http://localhost:3000/api/auth/register', data)
      .then((res) => {
          if (res.data.errors) {
            setError(res.data.errors)
            return false
          } else if(res.status === 201){
            setError({duplicate:res.data})
            return false
          } else {
            setError({})
            setTimeout(() => {
              navigate('/user/posts')
            }, 1000)
          }
        })
        .catch((err) => console.log(err))
    } else {
      setError({ confirmPassword: 'Password not match!' })
    }
  }
  return (
    <>
      <h3 style={{ marginBottom: "30px" }}>Register</h3>
      <div className="container border rounded p-5">
        <div className="mb-3 row">
          <label htmlFor="name" className="form-label">Name</label>
          <div>
            <input type="name" onChange={handelInputs} name="username" className="form-control" id="username" />
            {error.username ? <div className="text text-danger mt-2">{error.username.message}</div> : ''}
          </div>
        </div>
        <div className="mb-3 row">
          <label htmlFor="email" className="form-label">Email</label>
          <div>
            <input type="email" onChange={handelInputs} name="email" className="form-control" id="email" />
            {error.email ? <div className="text text-danger mt-2">{error.email.message}</div> : ''}
            {error.duplicate ? <div className="text text-danger mt-2">{error.duplicate}</div> : ''}
          </div>
        </div>
        <div className="mb-3 row">
          <label htmlFor="inputPassword" className="form-label">Password</label>
          <div>
            <input type="password" onChange={handelInputs} name="password" className="form-control" id="inputPassword" />
            {error.password ? <div className="text text-danger mt-2">{error.password.message}</div> : ''}
          </div>
        </div>
        <div className="mb-3 row">
          <label htmlFor="confirm_password" className="form-label">Confirm Password</label>
          <div>
            <input type="password" onChange={handelInputs} name="confirmPassword" className="form-control" id="confirm_password" />
            {error.confirmPassword ? <div className="text text-danger mt-2">{error.confirmPassword}</div> : ''}
          </div>
        </div>
        <div className="d-grid">
          <button className="btn btn-dark btn-lg" onClick={createUser}>Register</button>
        </div>
      </div >
    </>
  )
}
