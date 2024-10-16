import { useState } from 'react'
import axios from 'axios'
import {useNavigate} from 'react-router-dom'
import { Helmet } from 'react-helmet'

export default function Create() {
  const [post, setPost] = useState()
  const navigate = useNavigate()
  const handleInput = (e) => {
    setPost(prev => ({...prev, [e.target.name]: e.target.value}))
  }
  const handleFile = (e) => {
    const frmData = new FormData()
    frmData.append('file', e.target.files[0])
    frmData.append('post', JSON.stringify(post))
    setPost(frmData)
  }
  
  const addPost = (e) => {
    e.preventDefault()
    axios.post('http://localhost:3000/api/admin/create', post)
    .then((res) => {
      res.status === 200 ? navigate('/admin') : ""
    })
    .catch((err) => console.log(err))
  }
  return (
    <>
     <Helmet>
      <title>Create Post</title>
      <meta name="description" content="Create Post content" />
      <meta name="keywords" content="react, meta tags, seo" />
      <meta name="author" content="Your Name" />
    </Helmet>
      <div className="container">
      <h3>Create New Post</h3>
      <h3 className="text text-success text-center"></h3>
      <form onSubmit={addPost} className="border rounded p-4" encType='multipart/form-data'>
        <div className="mb-3 row">
          <label htmlFor="title">Title</label>
          <div>
            <input type="text" className="form-control" name='title' onChange={handleInput} />
            <div className="text text-danger mt-2" ></div>
          </div>
          <label htmlFor="body">Body</label>
          <div>
            <textarea className="form-control" name='body' onChange={handleInput} rows="10"  id="body"></textarea>
            <div className="text text-danger mt-2"></div>
          </div>
          <label htmlFor="title">Image</label>
          <div>
            <input type="file" name='files'  accept="image/*" onChange={handleFile} />
            <div className="text text-danger mt-2"></div>
          </div>
          <div className="d-grid mt-3">
            <button type='submit' className="btn btn-dark">Create</button>
          </div>
        </div>
      </form>
    </div>
    </>
  )
}
