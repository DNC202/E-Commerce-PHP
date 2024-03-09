import React, {useEffect} from "react";

import Hero from "../Hero/Hero";
import Product from "../Product/Product";

import AOS from "aos";
import "aos/dist/aos.css";
import TopProduct from "../TopProduct/TopProduct";
import Banner from "../Banner/Banner";
import Subscribe from "../Subscribe/Subscribe";
import Testimonials from "../Testimonials/Testimonials";

const Home = () => {
  useEffect(() => {
    AOS.init({
      offset: 100,
      duration: 800,
      easing: "ease-in-out-sine",
      delay: 100,
    });
    AOS.refresh();
  }, []);
  return (
    <>
     
      <Hero />
      <Product />
      <TopProduct />
      <Banner />
      <Subscribe />
      <Testimonials />
     
    </>
  );
};

export default Home;
