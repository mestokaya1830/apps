import React from 'react'
import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import axios from 'axios'

export default function Login() {
  const [data, setData] = useState({
    email: '',
    password: ''
  })
  const [error, setError] = useState({
    email: '',
    password: '',
    status: ''
  })

  let navigate = useNavigate()

  const handelInputs = (e) => {
    setData(values => ({ ...values, [e.target.name]: e.target.value }))
  }
  const loginUser = (e) => {
    e.preventDefault()
    if (data.email === '') {
      setError({ email: 'Email cant be null!' })
      return false
    } else if (data.password === '') {
      setError({ password: 'Password cant be null!' })
      return false
    } else {
      axios.post('http://localhost:3000/api/auth/login', data)
      .then((res) => {
          if (res.data.errors) {
            setError(res.data.errors)
            return false
          } else if (res.status === 201) {
            setError({status: res.data.result })
            return false
          } else {
            setError({})
            setTimeout(() => {
              navigate('/user/posts')
            }, 1000)
          }
        })
        .catch((err) => console.log(err))
    }
  }
  return (
    <>
      <h3 style={{ marginBottom: "30px" }}>Login</h3>
      <div className="container border rounded p-5">
        <div className="mb-3 row">
          <label htmlFor="email" className="form-label">Email</label>
          <div>
            <input type="email" onChange={handelInputs} name="email" className="form-control" id="email" />
            {error.email ? <div className="text text-danger mt-2">{error.email}</div> : ''}
          </div>
        </div>
        <div className="mb-3 row">
          <label htmlFor="inputPassword" className="form-label">Password</label>
          <div>
            <input type="password" onChange={handelInputs} name="password" className="form-control" id="inputPassword" />
            {error.password ? <div className="text text-danger mt-2">{error.password}</div> : ''}
          </div>
        </div>
        <div className="mb-3 row">
          {error.status ? <div className="text text-danger mt-2">{error.status}</div> : ''}
        </div>
        <div className="d-grid">
          <button className="btn btn-dark btn-lg" onClick={loginUser}>Login</button>
        </div>
      </div >
    </>
  )
}
