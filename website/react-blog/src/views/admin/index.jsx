import { useEffect, useState } from "react";
import axios from "axios";
import { Link } from "react-router-dom";
import { Helmet } from 'react-helmet'

export default function Index() {
  const [data, setData] = useState([]);
  useEffect(() => {
    axios
      .get("http://localhost:3000/api/client")
      .then((res) => {
        setData(res.data.posts);
      })
      .catch((err) => console.log(err));
  }, []);
  return (
    <>
     <Helmet>
      <title>Dashboard</title>
      <meta name="description" content="Dashboard content" />
      <meta name="keywords" content="react, meta tags, seo" />
      <meta name="author" content="Your Name" />
    </Helmet>
      <div className="container">
        <div className="d-flex justify-content-between">
          <h2> Posts</h2>
          <Link to="/admin/create">
            <button className="btn btn-success">Create New Post</button>
          </Link>
        </div>
        <div className="row">
          {data.map((item) => (
            <div key={item._id} className="col-sm-6">
              <div className="card">
                <div className="card-body">
                  <img src={`/uploads/${item.imageName}`} alt="" />
                  <h5 className="card-title">{item.title}</h5>
                  <p className="card-subtitle mb-2 text-muted">
                    {new Date(item.createdAt).toLocaleDateString()}
                    <strong>{item.owner}</strong>
                  </p>
                  <p className="card-text"></p>
                  <a href={`/admin/post/${item._id}`} className="card-link">
                    Read more...
                  </a>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </>
  );
}