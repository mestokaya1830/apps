import React from 'react'
import { useState } from 'react'
import axios from 'axios'
import { useNavigate } from 'react-router-dom'

export default function Create() {
  const [data, setData] = useState({
    title: '',
    body: ''
  })
  const [error, setError] = useState({
    file: '',
    title: '',
    body: ''
  })
  const [file, setFile] = useState()
 
  let navigate = useNavigate()

  const handelInputs = (e) => {
    setData(values => ({...values, [e.target.name]: e.target.value}))
  }
  const selectImage = (e) => {
    setFile(e.target.files[0])
  }
  const createPost = (e) => {
    e.preventDefault()
    if(file !== undefined){
      const frmData = new FormData()
      frmData.append('file', file)
      frmData.append('post', JSON.stringify(data))
      axios.post('http://localhost:3000/api/user/posts/create', frmData)
      .then((res) => {
        if(res.data.errors){
          setError(res.data.errors)
          return false
        }
        setError({})
        setTimeout(() => {
          navigate('/user/posts')
        }, 1000)
      })
      .catch((err) => console.log(err))
    } else {
      setError({file: 'Image cant be null!'})
    }
  }
  return (
    <>
      <h1>Create New Products</h1>
      <div className='container'>
        <div className="border rounded p-4">
          <div className="mb-3 row">
            <label htmlFor="title">Title</label>
            <div>
              <input type="text" className="form-control" name="title" onChange={handelInputs} />
              {error.title ? <div className="text text-danger mt-2">{error.title.message}</div> : ''}
            </div>
            <label htmlFor="body">Body</label>
            <div>
              <textarea className="form-control" rows="10" name="body" id="body" onChange={handelInputs}></textarea>
              {error.body ? <div className="text text-danger mt-2">{error.body.message}</div> : ''}
            </div>
            <label htmlFor="title">Image</label>
            <div>
              <input type="file" name="file" onChange={selectImage} accept="image/*" />
              <div className="text text-danger mt-2">{error.file}</div>
            </div>
            <div className="d-grid mt-3">
              <input type='button' onClick={createPost} className="btn btn-dark"  value="Create New Post"/>
            </div>
          </div>
        </div>
      </div>
    </>
  )
}
