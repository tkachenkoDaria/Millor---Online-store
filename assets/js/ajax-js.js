/**
  *  Ajax more product - On Click
  */

// const coffeCatalogWrapp = document.querySelector('.coffe-catalog-wrapp');
// const seeMoreProductBtn = document.getElementById('more-product');

// const loadMoreProduct = function () {
//     let countPage = seeMoreProductBtn.dataset.page;
//     let catId = seeMoreProductBtn.dataset.cat_id;
//     const data = new FormData()
//     data.append('action', 'load_more_product');
//     data.append('page', countPage);
//     data.append('cat_id', catId);
//     countPage++;
//     seeMoreProductBtn.dataset.page = countPage;

//     fetch(wp_js_vars.ajaxurl, {
//         method: 'POST',
//         body: data,
//     })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 coffeCatalogWrapp.insertAdjacentHTML('beforeEnd', data.html);
//                 handleClickSelectEvents();
            
//                 if (countPage >= wp_js_vars.max_page) {
//                     seeMoreProductBtn.remove();
//                 }
//             } else {
//                 console.error(data);
//             }
//         })
//         .catch(e => console.log(e.message))
// }
// if (seeMoreProductBtn) {
//     seeMoreProductBtn.addEventListener('click', function () {
//         loadMoreProduct();
//         handleClickSelectEvents();
//     });
// } 


/**
  *  Ajax more comment for product - On Click
  */

const wrappComentProdut = document.querySelector('.commentlist');
const loadMoreReviewsProductBtn = document.querySelector('.load-more-reviews-product');

if (loadMoreReviewsProductBtn) {
    let countPage = loadMoreReviewsProductBtn.dataset.page;
    let commentPageLast = loadMoreReviewsProductBtn.dataset.pageLast;
    let productId = loadMoreReviewsProductBtn.dataset.productId;

    loadMoreReviewsProductBtn.addEventListener('click', function (e) {
        const data = new FormData()

        data.append('action', 'load_more_reviews');
        data.append('page', countPage);
        data.append('product_id', productId);

        countPage++;

        fetch(wp_js_vars.ajaxurl, {
            method: 'POST',
            body: data,
        })
            .then(response => response.json())
            .then((data) => {
                if (data.success) {
                    loadMoreReviewsProductBtn.textContent = 'Завантаження';
                    wrappComentProdut.insertAdjacentHTML('beforeend', data.html)
                    loadMoreReviewsProductBtn.textContent = 'Показати ще';
                    if (countPage == commentPageLast) loadMoreReviewsProductBtn.remove();
                } else {
                    console.error(data);
                }
            })
            .catch(e => console.log(e.message))
    })

}

/**
  *  Ajax load pagination for news-category   - On Click
  */

const newsCategory = document.querySelector('.news-category');

const changePaginationAndPosts = function () {
    const wrappNewsCategory = document.querySelector('.wrapp-filter-news-posts.active');
    if (!wrappNewsCategory) return;

    const paginationNewsCategory = wrappNewsCategory.querySelector('.pagination-news');

    paginationNewsCategory.addEventListener('click', function (e) {
        const link = e.target.closest('a');
        if (!link) return;

        e.preventDefault();
        const pageHref = link.getAttribute('href');
        const page = parseInt(pageHref.match(/\d+/));

        const categoryNews = newsCategory.querySelector('button.active');
        const categoryId = categoryNews.dataset.categoryNews;

        const data = new FormData();
        data.append('action', 'load_posts_by_page');
        data.append('page', page);
        data.append('category_news', categoryId);

        fetch(wp_js_vars.ajaxurl, {
            method: 'POST',
            body: data,
        })
            .then(response => response.json())
            .then((data) => {
                if (data.success) {
                    wrappNewsCategory.innerHTML = data.html + data.pagination;
                    changePaginationAndPosts();
                } else {
                    console.error(data);
                }
            })
            .catch(e => console.log(e.message));
    });
};

changePaginationAndPosts();
if (newsCategory) {
    newsCategory.addEventListener('click', function (e) {
        const btnName = e.target.closest('button');
        if (!btnName) return;

        changePaginationAndPosts();
    });
}


/**
  *  Ajax product filter - On Click
  * 
  */


const grainWrapp = document.querySelector('.coffe-filters .row');
const wrapProduct = document.querySelector('.see-more-product-row');
const cardProduct = document.querySelectorAll('.card-coffe');
const paginationProduct = document.querySelector('.pagination-news.pagination-news_product');

let clickedElements = [];
let isResetButtonAdded = false;
let isPageButtonAdded = false;
let currentPage = 1;

const createData = function (element) {
    if (!element) return;

    const elementIndex = clickedElements.findIndex(el => el.name === element.name);

    if (elementIndex > -1) {
        element.checked = false;
        clickedElements.splice(elementIndex, 1);
        if (currentPage > 1) currentPage--;
    } else {
        document.querySelectorAll(`input[name="${element.name}"]`).forEach(input => {
            if (input !== element) {
                input.checked = false;
            }
        });
        element.checked = true;
        clickedElements = clickedElements.filter(el => el.name !== element.name);
        clickedElements.push(element);
    }
}

const buttonFilter = function (data) {
     paginationProduct.remove();
    if (!isResetButtonAdded) {
        grainWrapp.insertAdjacentHTML('beforeend', '<button type="button" id="reset-filter" class="btn-reset">Очистити</button>');
        isResetButtonAdded = true;
    }
    if (!isPageButtonAdded) {
        // wrapProduct.insertAdjacentHTML('beforeend', '<button type="button" id="more-product-filter" style="display:none" class="see-more-product">Показати ще</button>');
        isPageButtonAdded = true;
    }

    const btnResetFilter = document.getElementById('reset-filter');
    btnResetFilter.addEventListener('click', () => window.location.reload());

    data.append('page', currentPage);
}


const fetchProducts = function () {

    const catalogWrapp = document.querySelector('.coffe-catalog-wrapp');
    const elementGeography = document.getElementById('geography');
    const elementGrain = document.getElementById('grain');
    const elementKislinka = document.getElementById('kislinka');
    const elementMethod = document.getElementById('method');
    const elementTypeCoffee = document.getElementById('type-coffee');
    const elementSpecial = document.getElementById('special');

    let data = new FormData();
    data.append('action', 'filter_products');

    clickedElements.forEach(el => {
        data.append(el.name, el.value);
    });

    buttonFilter(data);

    fetch(wp_js_vars.ajaxurl, {
        method: 'POST',
        body: data,
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {

                const btnPage = document.getElementById('more-product-filter');
                if (data.html == '<p>No products found.</p>') {
                    currentPage = 1;
                    btnPage.style.display = 'none';
                    catalogWrapp.innerHTML += data.html;
                } else {
                    if (currentPage === 1) {
                        catalogWrapp.innerHTML = data.html;
                        currentPage = 1;
                    } else {
                        catalogWrapp.innerHTML += data.html;
                    }
                    const cardProduct = document.querySelectorAll('.card-coffe');
                    if (cardProduct.length == 9 || cardProduct.length == 18) {
                        btnPage.style.display = 'block';
                    } else {
                        btnPage.style.display = 'none';
                        currentPage = 1;
                    }
                }


                if (elementGeography) elementGeography.innerHTML = data.html_geography;
                if (elementGrain) elementGrain.innerHTML = data.html_grain;
                if (elementKislinka) elementKislinka.innerHTML = data.html_kislinka;
                if (elementMethod) elementMethod.innerHTML = data.html_method;
                if (elementTypeCoffee) elementTypeCoffee.innerHTML = data.html_type_coffee;
                if (elementSpecial) elementSpecial.innerHTML = data.html_special;
            } else {
                console.error(data);
            }
        })
        .catch(e => console.log(e.message));
}
if (grainWrapp) {
    grainWrapp.addEventListener('click', function (e) {
        const btnName = e.target.closest(`.custom-checkbox`);
        if (!btnName) return;

        let grain = null, geography = null, kislinka = null, method = null, typeCoffee = null, special = null;
        if (btnName.attributes.name.nodeValue == 'grain') grain = btnName;
        if (btnName.attributes.name.nodeValue == 'geography') geography = btnName;
        if (btnName.attributes.name.nodeValue == 'kislinka') kislinka = btnName;
        if (btnName.attributes.name.nodeValue == 'method') method = btnName;
        if (btnName.attributes.name.nodeValue == 'type-coffee') typeCoffee = btnName;
        if (btnName.attributes.name.nodeValue == 'special') special = btnName;

        createData(grain);
        createData(geography);
        createData(kislinka);
        createData(method);
        createData(typeCoffee);
        createData(special);

        fetchProducts();
    });
}

document.addEventListener('click', function (e) {
    if (e.target.id === 'more-product-filter') {
        currentPage++;
        fetchProducts();
    }
});
