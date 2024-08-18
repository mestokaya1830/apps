import React from 'react'
import { useState, useEffect } from 'react'
import { useParams } from 'react-router-dom'
import axios from 'axios'

export default function Details() {
  const [data, setData] = useState([])
  const { user, id } = useParams()

  useEffect(() => {
    axios.get(`http://localhost:3000/api/client/${user}/post/${id}`)
      .then((res) => setData(res.data))
      .catch((err) => console.log(err))
  }, [user, id])

  const goBack = () => {
    window.history.back()
  }
  return (
    <>
      <h1>Post Details</h1>
      <div className='container'>
        <div className='row d-flex justify-content-center'>
          <div className='col-sm-8' key={data._id}>
            <div className='card'>
              <div className='card-body'>
                <h2>{data.title}</h2>
                <img src={`/uploads/${data.imageName}`} alt="No Image" />
                <p>Date: {data.createdAt} / {data.owner}</p>
                <span>{data.body}</span>
                <div>
                  <button onClick={goBack} className='btn btn-secondary'>Back</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  )
}

