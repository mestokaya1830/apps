import { useEffect, useState } from 'react'
import axios from 'axios'
import { useParams, useNavigate } from 'react-router-dom'
import { Helmet } from 'react-helmet'

export default function Create() {
  const {id} = useParams()
  const [post, setPost] = useState({})
  const navigate = useNavigate()

  //get post
  useEffect(() => {
    axios.get('http://localhost:3000/api/admin/post/' + id)
    .then((res) => setPost(res.data.post))
    .catch((err) => console.log(err))
  },[id])
  
  //handle inputs
  const handleInput = (e) => {
    setPost(prev => ({...prev, [e.target.name]: e.target.value}))
  }
  
  const handelFile = (e) => {
    const frmData = new FormData()
    frmData.append('file', e.target.files[0])
    frmData.append('post', JSON.stringify(post))
    setPost(frmData)
  }
  //update post
  const updatePost = (e) => {
    e.preventDefault()
    if(Array.from(post) == []){
      const frmData = new FormData()
      frmData.append('post', JSON.stringify(post))
      setPost(frmData)
    }
    axios.post('http://localhost:3000/api/admin/update', post)
    .then((res) => {
      res.status === 200 ? navigate('/admin') : ""
    })
    .catch((err) => console.log(err))
  }

  return (
    <>
     <Helmet>
      <title>Post Edit</title>
      <meta name="description" content="Post Edit content" />
      <meta name="keywords" content="react, meta tags, seo" />
      <meta name="author" content="Your Name" />
    </Helmet>
      <div className="container">
      <h3>Edit Post</h3>
      <h3 className="text text-success text-center"></h3>
      <form onSubmit={updatePost} className="border rounded p-4">
        <div className="mb-3 row">
          <label htmlFor="title">Title</label>
          <div>
            <input type="text" className="form-control" name='title' onChange={handleInput} defaultValue={post.title} />
            <div className="text text-danger mt-2" ></div>
          </div>
          <label htmlFor="body">Body</label>
          <div>
            <textarea className="form-control" name='body' onChange={handleInput} rows="10"  defaultValue={post.body} ></textarea>
            <div className="text text-danger mt-2"></div>
          </div>
          <label htmlFor="title">Image</label>
          <img src={`/uploads/${post.imageName}`} alt="" className="updateImage" />
          <div>
            <input type="file" name='files'  accept="image/*" onChange={handelFile} />
            <div className="text text-danger mt-2"></div>
          </div>
          <div className="d-grid mt-3">
            <button type='submit' className="btn btn-dark">Update</button>
          </div>
        </div>
      </form>
    </div>
    </>
  )
}
