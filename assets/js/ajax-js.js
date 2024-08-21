/**
  *  Ajax more product - On Click
  */

const coffeCatalogWrapp = document.querySelector('.coffe-catalog-wrapp');
const seeMoreProductBtn = document.getElementById('more-product');

if (seeMoreProductBtn) {
    let countPage = seeMoreProductBtn.dataset.page;
    let catId = seeMoreProductBtn.dataset.cat_id;

    seeMoreProductBtn.addEventListener('click', function (e) {
        const data = new FormData()
        data.append('action', 'load_more_product');
        data.append('page', countPage);
        data.append('cat_id', catId);
        countPage++;


        fetch(wp_js_vars.ajaxurl, {
            method: 'POST',
            body: data,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    coffeCatalogWrapp.insertAdjacentHTML('beforeEnd', data.html);
                    if (countPage >= wp_js_vars.max_page) {
                        seeMoreProductBtn.remove();
                    }
                } else {
                    console.error(data);
                }
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
