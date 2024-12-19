import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import axios from "axios";
import { Helmet } from 'react-helmet'

export default function Details() {
  const [data, setData] = useState({});
  const { id } = useParams();
  const navigate = useNavigate()
  useEffect(() => {
    axios
      .get("http://localhost:3000/api/admin/post/" + id)
      .then((res) => {
        setData(res.data.post);
      })
      .catch((err) => console.log(err));
  }, [id]);

  const goBack = () => {
    window.history.back();
  };

  //delete post
   const deletePost = () => {
    axios.post('http://localhost:3000/api/admin/delete/' + id, {imageName: data.imageName})
    .then((res) => {
      res.status === 200 ? navigate('/admin') : ""
    })
    .catch((err) => console.log(err))
  }
  return (
    <>
     <Helmet>
      <title>Post Details</title>
      <meta name="description" content="Post Details content" />
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
                <div className="d-flex justify-content-between">
                  <button
                    onClick={goBack}
                    className="card-link btn btn-secondary"
                  >
                    Back
                  </button>
                  <div>
                    <a
                      href={`/admin/post/edit/${data._id}`}
                      className="card-link btn btn-warning"
                    >
                      Edit
                    </a>
                    <button
                      onClick={deletePost}
                      className="card-link btn btn-danger"
                    >
                      Delete
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
