import '../styles/tailwind.css';
import '../styles/style-index.css';
import "iconify-icon";
import Swiper from 'swiper/bundle';  
import 'swiper/css/bundle';
import './acordeon'

const swiper = new Swiper('.swiper-banner', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,
  slidesPerView: "auto",
  spaceBetween:0,
  pagination: {
    el: '.swiper-pagination-banner',
    clickable: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});
const swiperTestimonies = new Swiper('.swiper-testimonios', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,
  slidesPerView: "auto",
  spaceBetween:48,
  autoHeight: true,
  pagination: {
    el: '.swiper-pagination-testimonios',
    clickable: true,
  },
});
const swiperClients = new Swiper('.swiper-clients', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,
  slidesPerView: "auto",
  spaceBetween:72,
  autoplay: {
    delay: 2500,
  },

  // pagination: {
  //   el: '.swiper-pagination-testimonios',
  //   clickable: true,
  // },
});



