<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package millor
 */

?>
</main>

  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="footer-title">Підписка на новини та розсилку</h2>
          <p class="footer-text">Підпишіться на нашу розсилку прямо зараз і будьте в курсі нових поставок, знижок та
            ексклюзивних пропозицій.</p>
        </div>
        <div class="col-lg-12">
          <form action="#" class="form-mailing">
            <input class="form-mailing__input" type="email" placeholder="Ваш email" name="email" required>
            <button type="submit" class="form-mailing__btn">Підписатися</button>
          </form>
          <p class="form-mailing__text">Натискаючи на кнопку “Підписатися”, ви приймаєте правила
            <a href="#">користувальницької угоди</a>
          </p>
        </div>
      </div>
      <div class="row">
        <div class="footer-menu">
          <div class="col-4 col-xl-3">
			<?php the_custom_logo();?>
            <!-- <a href="/" class="logo">
              <img src="./img/header/logo.svg" alt="logo" class="logo__img">
            </a> -->
          </div>
          <div class="col-6 col-lg-7">
            <nav class="menu-header">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'       => 'ul',
							'menu_class'       => 'navigation navigation_footer',
						)
					);
			?>
              <!-- <ul class="navigation navigation_footer">
                <li>
                  <a href="#">Каталог товарів</a>
                </li>
                <li>
                  <a href="#">Блог</a>
                </li>
                <li>
                  <a href="#">Контакти</a>
                </li>
              </ul> -->
            </nav>
          </div>
        </div>
      </div>

    </div>
  </footer>

<?php wp_footer(); ?>

</body>
</html>
