import { useEffect, useState } from "react"
import {useParams} from 'react-router-dom'
import axios from "axios";
import { Helmet } from 'react-helmet'

export default function Details() {
  const [data, setData] = useState({})
  const {id} = useParams()
  useEffect(() => {
    axios
      .get("http://localhost:3000/api/admin/post/" + id)
      .then((res) => {
        setData(res.data.post);
      })
      .catch((err) => console.log(err));
  }, [id]);

  const goBack = () => {
    window.history.back()
  }
  return (
    <>
     <Helmet>
      <title>User Details</title>
      <meta name="description" content="User Details content" />
      <meta name="keywords" content="react, meta tags, seo" />
      <meta name="author" content="Your Name" />
    </Helmet>
      <div className="container">
        <div className="d-flex justify-content-between">
          <h2> Posts</h2>
        </div>
        <div className="row">
          
            <div key={data._id} className="col-sm-8">
              <div className="card">
                <div className="card-body">
                  <img src={`/uploads/${data.imageName}`} alt="" />
                  <h5 className="card-title">{data.title}</h5>
                  <p className="card-subtitle mb-2 text-muted">
                    {new Date(data.createdAt).toLocaleDateString()}
                    <strong>{data.owner}</strong>
                  </p>
                  <p className="card-text"></p>
                  <button onClick={goBack} className="card-link">
                   Back
                  </button>
                </div>
              </div>
            </div>
        
        </div>
      </div>
    </>
  )
}