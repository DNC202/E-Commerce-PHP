import React from "react";
import { CiSearch } from "react-icons/ci";
import { FaCartShopping } from "react-icons/fa6";
import Logo from "../../assets/react.svg";
import Darkmode from "./Darkmode";

const Navbar = () => {
  return (
    <div className="shadow-md bg-white dark:bg-gray-900 dark:text-white duration-200 relative z-40">
      {/* upper Navbar */}
      <div className="bg-primary/40 py-2">
        <div className="container flex justify-between items-center ">
          <div>
            <a href="#" className="front-bold text-2xl sm:text-3xl flex gap-2">
              <img src={Logo} alt="" className="w-[50px]" />
              E-commerce
            </a>
          </div>
          {/* sreach bar */}
          <div className="flex justify-between items-center gap-4">
            <div className="relative group hiidden sm:block">
              <input
                type="text"
                placeholder="Search"
                className="w-[200px] sm:w-[200px] group-hover:w-[300px] transition-all duration-300 rounded-full border border-gay-300 px-2 py-1 focus:outline-none focus-border-1 focus:border-primary"
              />
              <CiSearch className="text-gray-500 group-hover:text-primary absolute right-3 top-1/2 -translate-y-1/2" />
            </div>
            <button
              onClick={() => alert("Ordering not avaible yet")}
              className="bg-gradient-to-r from-primary to-secondary transition-all duration-200 text-white py-1 px-4 rounded-full flex items-center gap-3 group"
            >
              <span className="group-hover:block-hiidden transition-all duration-200">
                Order
              </span>
              <FaCartShopping className="text-xl text-white drop-shadow-sm cursor-pointer" />
            </button>
            {/* Drakmode swich */}
            <div>
              <Darkmode />
            </div>
          </div>
          {/* order button  */}
        </div>
      </div>
      {/* lower Navbar */}
      <div></div>
    </div>
  );
};

export default Navbar;
