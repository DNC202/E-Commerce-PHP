import React, {useEffect} from 'react'
import Navbar from './components/NavBar/Navbar'
import Hero from './components/Hero/Hero'
import Product from './components/Product/Product'

import AOS from 'aos';
import 'aos/dist/aos.css';


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
    </div>
  )
}

export default App