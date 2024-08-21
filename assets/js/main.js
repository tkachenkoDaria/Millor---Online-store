'use strict';

// swiper
var swiper = new Swiper(".swiper_head", {
  spaceBetween: 30,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});

var swiper = new Swiper(".swiper_product-sale", {
  slidesPerView: 3,
  autoHeight: false,
  spaceBetween: 30,
  noSwipingClass: 'add_to_cart_button',
  noSwipingSelector: 'a',
  watchSlidesProgress: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next_card-next",
    prevEl: ".swiper-button-prev_card-prev",
  },

  breakpoints: {
    300: {
      slidesPerView: 1,
      autoHeight: true,
    },
    992: {
      slidesPerView: 2,
      // autoHeight: true,
    },
    1200: {
      slidesPerView: 3,
      autoHeight: false,
    },
  },
});

var swiper = new Swiper(".swiper_social-instagram", {
  slidesPerView: 2.5,
  slidesPerGroup: 1,
  autoHeight: false,
  grid: {
    rows: 1,
  },
  spaceBetween: 20,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    1200: {
      slidesPerGroup: 3,
      grid: {
        rows: 2,
      },
    },
  },
});


// search modal
let searchIcon = document.querySelector('.search-icon');
let searchBlok = document.querySelector('.yith-ajaxsearchform-container');
let svgCloseWrap = document.createElement('div');
let svgClose = document.createElement('span');


svgCloseWrap.classList.add('close-wrap');
svgClose.classList.add('close');


svgCloseWrap.append(svgClose);
searchBlok.append(svgCloseWrap);

searchIcon.addEventListener('click', function () {
  searchBlok.classList.add('active');
  svgClose.classList.add('active');
})
svgClose.addEventListener('click', function () {
  searchBlok.classList.remove('active');
  svgClose.classList.remove('active');
})

// gamburger
const icon = document.querySelector('.nav-icon');
const nav = document.querySelector('.menu-header_mobi');
const navbar = document.querySelector('.nav-bar');

icon.addEventListener('click', () => {
  icon.classList.toggle('icon-active');
  nav.classList.toggle('nav-active');
  navbar.classList.toggle('navbar-active');
});


// MODAL photo
const btnOpen = document.getElementById("open__btn");
const molad = document.getElementById('wrapper-modal');
const overlay = document.getElementById('overlay');
const closeImg = document.getElementById('close-img');

if (btnOpen) {
  btnOpen.addEventListener('click', () => {
    molad.classList.add('active');
  })
  const closeModal = () => {
    molad.classList.remove('active');

  }

  closeImg.addEventListener('click', () => {
    molad.classList.remove('active');
  })

  overlay.addEventListener('click', closeModal);
}





// sort product

let sortItemsCoffe = document.querySelector('.orderby');

// sort product coffee
const urlCoffe = 'https://millor.daria-tkachenko.website/product-category/all-product/freshly-roasted-coffee';
if (sortItemsCoffe) {
  if (urlCoffe === 'https://millor.daria-tkachenko.website/product-category/all-product/freshly-roasted-coffee') {
    sortItemsCoffe.classList.add('orderby-coffe');
  }
}


const sortItemsCoffes = document.querySelectorAll('orderby-coffe option');
sortItemsCoffes.forEach(el => el.addEventListener('click', () => {
  const data_value = el.getAttribute('data-value');
  window.location.href = "/product-category/all-product/freshly-roasted-coffee?orderby=" + data_value;
}));


const tabContent = function (btnContainer, buttons, contentBlocks, showBtnName) {
  const btnContainerElement = document.querySelector(`${btnContainer}`);
  const buttonsElement = document.querySelectorAll(`${buttons}`);
  const contentBlocksElement = document.querySelectorAll(`${contentBlocks}`);

  if (btnContainerElement) {
    btnContainerElement.addEventListener('click', function (e) {
      const btnName = e.target.closest(`${showBtnName}`);
      if (!btnName) return;

      const btnDataset = btnName.dataset.btn;
      buttonsElement.forEach(btn => btn.classList.remove('active'));
      btnName.classList.add('active');

      contentBlocksElement.forEach(content => content.classList.remove('active'));
      document.querySelector(`${contentBlocks}_${btnDataset}`).classList.add('active');
    });
  }
}

tabContent('.cooking-coffe', '.coffe-icon', '.cooking-content', '.coffe-icon');
tabContent('.news-category', '.news-category button', '.wrapp-filter-news-posts', 'button');