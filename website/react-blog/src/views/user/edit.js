import React from 'react'
import { useState, useEffect } from 'react'
import { useParams, useNavigate } from 'react-router-dom'
import axios from 'axios'

export default function Edit() {
  const {id} = useParams()
  const [data, setData] = useState({
    title: '',
    body: '',
    _id: id
  })
  const [error, setError] = useState({
    file: '',
    title: '',
    body: ''
  })
  const [file, setFile] = useState()
  const navigate = useNavigate()
  useEffect(() => {
    axios.get(`http://localhost:3000/api/user/posts/post/${id}`)
      .then((res) => setData(res.data))
      .catch((err) => console.log(err))
  }, [id])

  const handelInputs = (e) => {
    setData(values => ({...values, [e.target.name]: e.target.value}))
  }
  const selectImage = (e) => {
    setFile(e.target.files[0])
  }
  const updatePost = (e) => {
    e.preventDefault()
    const frmData = new FormData()
    frmData.append('file', file)
    frmData.append('post', JSON.stringify(data))
    axios.post('http://localhost:3000/api/user/posts/update', frmData)
    .then((res) => {
      if(res.data.errors){
        setError(res.data.errors)
        return false
      }
      setError({})
      navigate('/user/posts')
    })
    .catch((err) => console.log(err))
  }
  return (
    <>
      <h1>Edit</h1>
      <div className='container'>
        <form onSubmit={updatePost} id="form" className="border rounded p-4" encType="multipart/form-data">
          <div className="mb-3 row">
            <label htmlFor="title">Title</label>
            <div>
              <input type="text" className="form-control" name="title" value={data.title} onChange={handelInputs} />
              {error.title ? <div className="text text-danger mt-2">{error.title.message}</div> : ''}
            </div>
            <label htmlFor="body">Body</label>
            <div>
              <textarea className="form-control" rows="10" name="body" id="body" value={data.body} onChange={handelInputs}></textarea>
              {error.body ? <div className="text text-danger mt-2">{error.body.message}</div> : ''}
            </div>
            <label htmlFor="title">Image</label>
            <img className='updateImage' src={`/uploads/${data.imageName}`}  alt="no image"/>
            <div>
              <input type="file" name="file" onChange={selectImage} accept="image/*" />
              <div className="text text-danger mt-2">{error.file}</div>
            </div>
            <div className="d-grid mt-3">
              <button type='submit' className="btn btn-dark">Update Post</button>
            </div>
          </div>
        </form>
      </div>
    </>
  )
}
