// import image
import Image1 from "../src/assets/hero/women.png";
import Image2 from "../src/assets/hero/sale.png";
import Image3 from "../src/assets/hero/shopping.png";

// Define your menu items
const menuItems = [
  { id: 1, label: "Home", link: "/home" },
  { id: 2, label: "Product", link: "/product" },
  { id: 3, label: "About", link: "/about" },
  { id: 4, label: "Contact", link: "/contact" },
];

const Dropdown = [
  // { id: 1, label: 'Treding Product', link: '#' },
  { id: 2, label: "New Product", link: "#" },
  { id: 3, label: "Best Selling", link: "#" },
  { id: 4, label: "Best Rated", link: "#" },
];

const ImageList = [
  {
    id: 1,
    img: Image1,
    title: "Upto 50% off on all Men's Wear",
    description:
      "lorem His Life will forever be Changed dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
  },
  {
    id: 2,
    img: Image2,
    title: "30% off on all Women's Wear",
    description:
      "Who's there lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
  },
  {
    id: 3,
    img: Image3,
    title: "70% off on all Products Sale",
    description:
      "consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
  },
];

// Export the menu
export const Menu = menuItems;
export const DropdownMenu = Dropdown;
export const ImageListSection = ImageList;
