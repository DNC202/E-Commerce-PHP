import React, {useEffect} from 'react'
import Navbar from './components/NavBar/Navbar'
import Hero from './components/Hero/Hero'
import Product from './components/Product/Product'

import AOS from 'aos';
import 'aos/dist/aos.css';
import TopProduct from './components/TopProduct/TopProduct';
import Banner from './components/Banner/Banner';
import Subscribe from './components/Subscribe/Subscribe';
import Testimonials from './components/Testimonials/Testimonials';
import Footer from './components/Footer/Footer';


const App = () => {

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
    <div>
      <Navbar/>
      <Hero/>
      <Product/>
      <TopProduct/>
      <Banner/>
      <Subscribe/>
      <Testimonials/>
      <Footer/>
    </div>
  )
}

export default App