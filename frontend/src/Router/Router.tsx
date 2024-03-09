import React from "react";

import { Routes, Route, Navigate } from "react-router-dom";

import Home from "../components/Home/Home";
import Login from "../components/Login/Login";
import Register from "../components/Register/Register";



const Router = () => {
  return (
      <Routes>
        <Route path="/" element={<Navigate to={"/home"} />} />
        <Route path="/home" element={<Home />} />
        <Route path="/login" element={<Login/>} />
        <Route path="/register" element={<Register/>} />
      </Routes>
  );
};

export default Router;
