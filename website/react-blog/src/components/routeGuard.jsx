import { Outlet, Navigate } from "react-router-dom";
import { useSelector } from "react-redux";
import Navbar from "../components/navbar.jsx";

export default function RouteGuard() {
  const auth = useSelector((state) => state.auth.value);
  return (
    <>
      <Navbar />
      <div className="router">
        {auth ? <Outlet /> : <Navigate to="/login" />}
      </div>
    </>
  );
}
