import React from 'react'
import { useState, useEffect } from 'react'
import { useParams } from 'react-router-dom'
import axios from 'axios'

export default function UserPosts() {
  const [data, setData] = useState([])
  const {id} = useParams()
 
  useEffect(() => {
    axios.get(`http://localhost:3000/api/client/${id}/posts`)
      .then((res) => setData(res.data))
      .catch((err) => console.log(err))
  }, [id])
  console.log(data)
  return (
    <>
      <h1>{id} Posts</h1>
      <div className='container'>
        <div className='row'>
          {data.map(item =>
            <div className='col-sm-6' key={item._id}>
              <div className='card'>
                <div className='card-body'>
                  <h2>{item.title}</h2>
                  <p>Date: {item.createdAt}</p>
                  <span>{String(item.body).substring(0,100)}</span>
                <div>
                <a href={`${item._id}`}>Read more...</a>
                </div>
                </div>
              </div>
            </div>
          )}
        </div>
      </div>
    </>
  )
}

