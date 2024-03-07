import React from "react";
import { Products } from "../../index.ts";

import { FaStar } from "react-icons/fa";

const Product = () => {
  return (
    <div className="mt-14 mb-12">
      <div className="container">
        {/* header section  */}
        <div className="text-center mb-10 max-w-[600px] mx-auto">
          <p data-aos = "fade-up" className="text-sm text-primary">Top Selling Products for you</p>
          <h1 data-aos = "fade-up" className="text-3xl font-bold">Products</h1>
          <p data-aos = "fade-up" className="text-xs text-gray-400">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sit
            asperiores modi Sit asperiores modi
          </p>
        </div>
        {/* body section */}
        <div>
          <div className="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 place-items-center gap-5">
            {Products.map((item) => (
              <div key={item.id} className="space-y-3" data-aos = "fade-up" data-aos-delay = {item.aosDelay}>
                <img
                  src={item.img}
                  alt=""
                  className="h-[220px] w-[150px] object-cover rounded-md"
                />
                <div>
                  <h3 className="font-semibold">{item.title}</h3>
                  <p className="text-sm text-gray-600">{item.color}</p>
                  <div className="flex items-center gap-1">
                    <FaStar className="text-yellow-400"/>
                    <span>{item.rating}</span>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

export default Product;
