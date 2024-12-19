import { useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import { Helmet } from 'react-helmet'

export default function Register() {
  const [user, setUser] = useState({
    username:'',
    email:'',
    password: '',
    passwordConfirm: ''
  })

  const [errors, setErrors] = useState({})
  const [dubemail, setDubemail] = useState('')
  const [passwordconfirm, setPasswordconfirm] = useState('')
  const navigate = useNavigate()
  const handleInput = (e) => {
    setErrors({})
    setDubemail('')
    setPasswordconfirm('')
    setUser(prev => ({...prev, [e.target.name]: e.target.value}))
  }

  const registerUser = (e) => {
    e.preventDefault()
    if(user.password !== user.passwordConfirm){
      setPasswordconfirm('Given password are not matching!')
      return false
    }
    axios.post('http://localhost:3000/api/register', user)
    .then((res) => {
      if(res.data.errors){
        setErrors(res.data.errors)
      } else if(res.status === 201){
        setDubemail(res.data)
      } else {
        navigate('/login')
      }
    })
    .catch((err) => console.log(err))
  }
  return (
    <>
     <Helmet>
      <title>Register</title>
      <meta name="description" content="Register content" />
      <meta name="keywords" content="react, meta tags, seo" />
      <meta name="author" content="Your Name" />
    </Helmet>
      <form onSubmit={registerUser} className="container border rounded p-5">
        <h3 style={{marginBottom: "30px"}}>Register</h3>
        <div className="mb-3 row">
          <label htmlFor="name" className="form-label">
            Name
          </label>
          <div>
            <input type="name" name="username" onChange={handleInput} className="form-control" id="name" />
            {errors.name ? <div className="text text-danger mt-2">{errors.name.message}</div>: ""}
          </div>
        </div>
        <div className="mb-3 row">
          <label htmlFor="email" className="form-label">
            Email
          </label>
          <div>
            <input type="email" name="email" onChange={handleInput} className="form-control" id="email" />
            {errors.email ? <div className="text text-danger mt-2">{errors.email.message}</div>: ""}
          </div>
        </div>
        <div className="mb-3 row">
          <label htmlFor="inputPassword" className="form-label">
            Password
          </label>
          <div>
            <input
              type="password"
              name="password"
              onChange={handleInput}
              className="form-control"
              id="inputPassword"
            />
            {errors.password ? <div className="text text-danger mt-2">{errors.password.message}</div>: ""}
          </div>
        </div>
        <div className="mb-3 row">
          <label htmlFor="confirm_password" className="form-label">
            Confirm Password
          </label>
          <div>
            <input
              type="password"
              name="passwordConfirm"
              onChange={handleInput}
              className="form-control"
              id="confirm_password"
            />
           {passwordconfirm ?  <div className="text text-danger mt-2">{passwordconfirm}</div> : ""}
           {dubemail ?  <div className="text text-danger mt-2">{dubemail}</div> : ""}
          </div>
        </div>
        <div className="d-grid">
          <button type="submit" className="btn btn-dark btn-lg">Register</button>
        </div>
      </form>
    </>
  );
}
