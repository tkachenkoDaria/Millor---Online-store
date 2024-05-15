/**
  *  Ajax more product - On Click
  */

const coffeCatalogWrapp = document.querySelector('.coffe-catalog-wrapp');
const seeMoreProductBtn = document.getElementById('more-product');
const seeMoreProductRow = document.querySelector('.see-more-product-row');

if (seeMoreProductBtn) {
    let countPage = seeMoreProductBtn.dataset.page;
    const dataMoreProduct = {
        'page': countPage,
    };
    seeMoreProductBtn.addEventListener('click', function (e) {
        dataMoreProduct.page++;
        fetch(wp_js_vars.ajaxurl + '?action=more_product'
            , {
                method: 'POST',
                body: JSON.stringify(dataMoreProduct),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then((response) => {
                if (!response.ok)
                    throw new Error('No reviews');
                return response.text();
            })

            .then((data) => {
                seeMoreProductBtn.textContent = 'Завантаження';
                coffeCatalogWrapp.insertAdjacentHTML('beforeend', data);
                seeMoreProductBtn.textContent = 'Показати ще';

                if (dataMoreProduct.page == wp_js_vars.max_page)
                    seeMoreProductRow.remove();
            })
            .catch(e => console.log(e.message))
    });
}


/**
  *  Ajax more product for category - On Click
  */

const seeMoreProductBtnCategory = document.getElementById('more-product-category');
if (seeMoreProductBtnCategory) {
    let countPage = seeMoreProductBtnCategory.dataset.page;
    let catId = seeMoreProductBtnCategory.dataset.catId;
    console.log(catId);
    const dataMoreProduct = {
        'page': countPage,
        'cat_id': catId,
    };

    seeMoreProductBtnCategory.addEventListener('click', function (e) {
        dataMoreProduct.page++;
        fetch(wp_js_vars.ajaxurl + '?action=more_product_category'
            , {
                method: 'POST',
                body: JSON.stringify(dataMoreProduct),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then((response) => {
                if (!response.ok)
                    throw new Error('No reviews');
                return response.text();
            })

            .then((data) => {
                seeMoreProductBtnCategory.textContent = 'Завантаження';
                coffeCatalogWrapp.insertAdjacentHTML('beforeend', data);
                seeMoreProductBtnCategory.textContent = 'Показати ще';

                if (dataMoreProduct.page == wp_js_vars.max_page)
                    seeMoreProductRow.remove();
            })
            .catch(e => console.log(e.message))
    });
}

/**
  *  Ajax more comment for product - On Click
  */

const wrappComentProdut = document.querySelector('.commentlist');
const loadMoreReviewsProductBtn = document.querySelector('.load-more-reviews-product');

if (loadMoreReviewsProductBtn) {
    let countPage = loadMoreReviewsProductBtn.dataset.page;
    let commentPageLast = loadMoreReviewsProductBtn.dataset.pageLast;
    let productId = loadMoreReviewsProductBtn.dataset.productId;
    const dataLoadMoreReviews = {
        'page': countPage,
        'product_id': productId
    }
    loadMoreReviewsProductBtn.addEventListener('click', function (e) {
        dataLoadMoreReviews.page++;
        fetch(wp_js_vars.ajaxurl + '?action=load_more_reviews', {
            method: 'POST',
            body: JSON.stringify(dataLoadMoreReviews),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then((response) => {
                if (!response.ok)
                    throw new Error('No reviews');
                return response.text()
            })
            .then((html) => {
                loadMoreReviewsProductBtn.textContent = 'Завантаження';
                wrappComentProdut.insertAdjacentHTML('beforeend', html)
                loadMoreReviewsProductBtn.textContent = 'Показати ще';
                if (dataLoadMoreReviews.page == commentPageLast) loadMoreReviewsProductBtn.remove();

            })
            .catch(e => console.log(e.message))
    })

}

/**
  *  Ajax load news-category - On Click
  */
const newsCategory = document.querySelector('.news-category');
const wrappNewsCategory = document.querySelector('.wrapp-filter-news-posts');
if (newsCategory) {
    const newsCategoryButtons = document.querySelectorAll('.news-category button');

    newsCategory.addEventListener('click', function (e) {
        const btn = e.target.closest('button');
        if (!btn) return;
        newsCategoryButtons.forEach(btn => btn.classList.remove('active'));

        const btnValue = btn.value;

        const datanewsCategory = {
            'category_id': btnValue,
        };

        fetch(wp_js_vars.ajaxurl + '?action=load_posts_by_category', {
            method: 'POST',
            body: JSON.stringify(datanewsCategory),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then((response) => {
                if (!response.ok) throw new Error('No posts found');
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    btn.classList.add('active');
                    wrappNewsCategory.innerHTML = data.data.posts + data.data.pagination;
                    attachPaginationEvent();
                } else {
                    console.log('No posts found');
                }
            })
            .catch(e => console.log(e.message));
    });
}


/**
  *  Ajax load pagination for news-category   - On Click
  */

function attachPaginationEvent() {
    const paginationNewsCategory = document.querySelector('.pagination-news');
    if (!paginationNewsCategory) return;

    paginationNewsCategory.addEventListener('click', function (e) {
        e.preventDefault();
        const target = e.target;
        if (target.tagName === 'A' && target.classList.contains('page-numbers')) {
            const page = target.getAttribute('href').slice(-1);
            const activeCategoryButton = document.querySelector('.news-category button.active');
            const categoryId = activeCategoryButton ? activeCategoryButton.value : '';

            const data = {
                'page': parseInt(page, 10),
                'category_id': categoryId
            };

            fetch(wp_js_vars.ajaxurl + '?action=load_posts_by_page', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error('Failed to load posts');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        wrappNewsCategory.innerHTML = data.data.posts + data.data.pagination;
                        attachPaginationEvent();
                    } else {
                        console.log('No posts found');
                    }
                })
                .catch(error => console.error(error));
        }
    });
}

// Initial call to attach the pagination event listener
attachPaginationEvent();
