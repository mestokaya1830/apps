import React from 'react'
import { useState, useEffect } from 'react'
import { useParams, useNavigate } from 'react-router-dom'
import axios from 'axios'

export default function Details() {
  const [data, setData] = useState([])
  const { user, id } = useParams()
  const navigate = useNavigate()
  useEffect(() => {
    axios.get(`http://localhost:3000/api/user/posts/post/${id}`)
    .then((res) => setData(res.data))
    .catch((err) => console.log(err))
  }, [user, id])

  const goBack = () => {
    window.history.back()
  }
  const deletePost = () => {
    axios.post(`http://localhost:3000/api/user/posts/delete/${id}`, {imageName: data.imageName})
    .then((res) => navigate('/user/posts'))
    .catch((err) => console.log(err))
  }
  return (
    <>
      <h1>User Post Details</h1>
      <div className='container'>
        <div className='row d-flex justify-content-center'>
          <div className='col-sm-8' key={data._id}>
            <div className='card'>
              <div className='card-body'>
                <h2>{data.title}</h2>
                <img src={`/uploads/${data.imageName}`} alt="No Image" />
                <p>Date: {data.createdAt}</p>
                <span>{data.body}</span>
                <div className='d-flex justify-content-between mt-3'>
                    <button onClick={goBack} className='btn btn-secondary'>Back</button>
                  <div>
                    <a href={`/user/post/edit/${data._id}`} className='btn btn-warning me-3'>Edit</a>
                    <button className='btn btn-danger' onClick={deletePost}>Delete</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  )
}

