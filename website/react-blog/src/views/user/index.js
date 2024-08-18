import React from 'react'
import { useState, useEffect } from 'react'
import axios from 'axios'

export default function Index() {
  const [data, setData] = useState([])

  useEffect(() => {
    axios.get('http://localhost:3000/api/user/posts')
      .then((res) => setData(res.data))
      .catch((err) => console.log(err))
  }, [])
  return (
    <>
      <div className='container'>
        <h2 className='d-flex justify-content-between create-btn'>
          <div>User Posts</div>
          <a href="/user/post/create"><button className='btn btn-primary'>Create New Post</button></a>
        </h2>
        <div className='row'>
          {data.map(item =>
            <div className='col-sm-6' key={item._id}>
              <div className='card'>
                <div className='card-body'>
                  <h2>{item.title}</h2>
                  <img src={`/uploads/${item.imageName}`} alt="No Image" />
                  <p>Date: {item.createdAt}</p>
                  <span>{String(item.body).substring(0, 100)}</span>
                  <div className='read-more'>
                    <a href={`/user/${item.owner}/${item._id}`}>Read more...</a>
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
