import React from "react";

import { Routes, Route, Navigate } from "react-router-dom";

import Home from "../pages/Home/Home";
import Login from "../components/Login/Login";
import Register from "../components/Register/Register";
import Forgot from "../components/Forgot/Forgot";
import ChangePassword from "../components/Change/ChangePasswrod";
import NotFound from "../pages/NotFound/NotFound";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

const Router = () => {
  return (
    <>
      <Routes>
        <Route path="/" element={<Navigate to={"/home"} />} />
        <Route path="/home" element={<Home />} />
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/forgot" element={<Forgot />} />
        <Route path="/change" element={<ChangePassword />} />
        <Route path="*" element={<Navigate to={"/404"} />} />
        <Route path="/404" element={<NotFound />} />
      </Routes>
      <ToastContainer className="toast-position" position="bottom-right" />
    </>
  );
};

export default Router;
