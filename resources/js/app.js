import './bootstrap';
import 'bootstrap';
import './main.js';
import { Input, initMDB } from "mdb-ui-kit";

initMDB({ Input });

import Splide from '@splidejs/splide';

document.addEventListener('DOMContentLoaded', () => {
  const el = document.querySelector('.splide');
  if (el) {
    new Splide(el, {
      type: 'loop',
      perPage: 3,
      gap: '1rem',
      pagination: true,
      arrows: true,
    }).mount();
  }
});
