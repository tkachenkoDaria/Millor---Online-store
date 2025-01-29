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
const body = document.querySelector('body');


if (btnOpen) {
  btnOpen.addEventListener('click', () => {
    molad.classList.add('active');
    body.classList.add('no-scroll');
  })
  const closeModal = () => {
    molad.classList.remove('active');
    body.classList.remove('no-scroll');
  }

  closeImg.addEventListener('click', () => {
    molad.classList.remove('active');
    body.classList.remove('no-scroll');
  })

  overlay.addEventListener('click', closeModal);
}

const handleClickSelectEvents = () => {
  document.querySelectorAll('.product .variations').forEach((variations) => {
   
    variations.addEventListener('click', (e) => {
      const btnOpen = e.target.closest('.btn-select-open');
      if (!btnOpen) return;

      const list = btnOpen.nextElementSibling;
      const select = list.nextElementSibling;
      const items = list.querySelectorAll('li');
  
      btnOpen.classList.toggle('active');
      list.classList.toggle('active');

      list.addEventListener('click', (e) => {
        const target = e.target.closest('.select-list__item');
        if (!target || target.classList.contains('select-list__item_none')) return;

        const value = target.getAttribute('value');

        items.forEach((option) => {
          list.querySelectorAll('.select-list__item').forEach((item) => {
            item.classList.remove('select-list__item_selected');
            item.removeAttribute('selected');
          });

          target.classList.add('select-list__item_selected');
          target.setAttribute('selected', 'selected');

          btnOpen.textContent = value;
          btnOpen.classList.remove('active');
          list.classList.remove('active');

          Array.from(select).forEach((option) => {
            if (option.value === value) {
              option.selected = true;
              const changeEvent = new Event('change', { bubbles: true });
              select.dispatchEvent(changeEvent);
            }
          });

        });
       
      });
      
    });
  });
};
handleClickSelectEvents();

// const orderby = document.querySelectorAll('.orderby');
// const woocommerceOrdering = document.querySelector('.woocommerce-ordering');
// const woocommerceOrderings = document.querySelectorAll('.woocommerce-ordering');
// if (orderby) {
//   const selectListOrderby = document.createElement('ul');
//   selectListOrderby.classList.add('select-list');

//   const btnOrderbyOpen = document.createElement('button');
//   btnOrderbyOpen.classList.add('btn-select-open');
//   btnOrderbyOpen.setAttribute('type', 'button');

//   woocommerceOrdering.prepend(selectListOrderby);
//   woocommerceOrdering.prepend(btnOrderbyOpen);
  

//   Array.from(orderby[0]).forEach((option, index) => {
//     const selectItem = document.createElement('li');
//     selectItem.classList.add('select-list__item');
//     selectItem.innerText = option.innerText;

//     if (index === 0) {
//       selectItem.classList.add('select-list__item_none');
//     } else {
//       selectItem.setAttribute('value', option.value);
//       if (option.selected) {
//         btnOrderbyOpen.innerText = option.innerText;
//         selectItem.classList.add('select-list__item_selected');
//       }
//     }
//     selectListOrderby.append(selectItem);
//   });
//     // handleClickEvents(woocommerceOrderings);
// }



// sort product
let sortItemsCoffe = document.querySelector('.orderby');
const btnSelectPpenOrderby = document.querySelector('.btn-select-open_orderby');
const selectListOrderby = document.querySelector('.select-list_orderby');
const selectListOrderbyItems = document.querySelectorAll('.select-list_orderby li');
const orderbySelect = document.querySelector('.orderby_select');
let textBtnSelectPpenOrderby = '';

const selectListCustomOrderby = function () {

  Array.from(orderbySelect.options).forEach((option) => {
    if (option.selected) textBtnSelectPpenOrderby = option.textContent;
  });

  btnSelectPpenOrderby.textContent = textBtnSelectPpenOrderby;

  btnSelectPpenOrderby.addEventListener('click', () => {
    btnSelectPpenOrderby.classList.toggle('active');
    selectListOrderby.classList.toggle('active');
  });

  selectListOrderby.addEventListener('click', (e) => {
    let list = e.target.closest('.select-list__item');
    if (!list) return;

    const value = list.getAttribute('value');

    selectListOrderbyItems.forEach((option) => {
      selectListOrderbyItems.forEach((item) => {
        item.classList.remove('select-list__item_selected');
        item.removeAttribute('selected');
      });

      list.classList.add('select-list__item_selected');
      list.setAttribute('selected', 'selected');

      btnSelectPpenOrderby.textContent = list.textContent;
      btnSelectPpenOrderby.classList.remove('active');
      selectListOrderby.classList.remove('active');


      Array.from(orderbySelect.options).forEach((option) => {
        if (option.value === value) {
          option.selected = true;
          const changeEvent = new Event('change', { bubbles: true });
          orderbySelect.dispatchEvent(changeEvent);
        }
      });

    });
  });

}

if (selectListOrderby) selectListCustomOrderby();

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

const btnOpenFilter = document.querySelector('.open-filter');
const sectionCoffeFilters = document.querySelector('.coffe-filters');
const btnCloseFilter = document.querySelector('.btn-close-filter');
if (btnOpenFilter) {
  btnOpenFilter.addEventListener('click', function () {
    sectionCoffeFilters.classList.add('active');
    btnCloseFilter.classList.add('active');
  })
  btnCloseFilter.addEventListener('click', function () {
    sectionCoffeFilters.classList.remove('active');
    btnCloseFilter.classList.remove('active');
  })
}
