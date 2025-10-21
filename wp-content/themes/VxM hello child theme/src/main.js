import '../styles/tailwind.css';
import '../styles/style-index.css';
import "iconify-icon";
import Swiper from 'swiper/bundle';  
import 'swiper/css/bundle';
import './acordeon'

const swiper = new Swiper('.swiper', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,
  slidesPerView: "auto",
  spaceBetween:0,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});



