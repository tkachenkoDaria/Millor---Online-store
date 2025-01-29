<?php
function add_term_args(&$args, $name_term_post, $pa_name) {
    if (!empty($name_term_post)) {
        $args['tax_query'][] = array(
            'taxonomy' => $pa_name,
            'field' => 'term_id',
            'terms' => $name_term_post,
            'operator' => 'IN',
        );
    }
}


function get_terms_taxonomy($taxonomy, $product_ids) {
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
        'object_ids' => $product_ids,
    ));
    return $terms;
}



function render_term_filter($terms, $title, $input_name, $selected_value) {
    ob_start();
    if (!empty($terms)) {
        echo '<h5 class="coffe-filter__name coffe-filter__name_filter-two">' . esc_html($title) . '</h5>';
        foreach ($terms as $term) {
            $checked = ($term->term_id == $selected_value) ? 'checked' : '';
            echo '<div class="checkbox checkbox_filter-two">';
            echo '<input class="custom-checkbox" type="radio" id="' . esc_attr($input_name) . '-' . esc_attr($term->term_id) . '" name="' . esc_attr($input_name) . '" value="' . esc_attr($term->term_id) . '" ' . $checked . '>';
            echo '<label for="' . esc_attr($input_name) . '-' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</label>';
            echo '</div>';
        }
    }
    return ob_get_clean();
}
function render_term_filter_grain($terms, $title, $input_name, $selected_value) {
    ob_start();
    if (!empty($terms)) {
        echo '<h4 class="coffe-filter__name">' . esc_html($title) . '</h4>';
        foreach ($terms as $term) {
            $checked = ($term->term_id == $selected_value) ? 'checked' : '';
            echo '<div class="checkbox">';
            echo '<input class="custom-checkbox" type="radio" id="' . esc_attr($input_name) . '-' . esc_attr($term->term_id) . '" name="' . esc_attr($input_name) . '" value="' . esc_attr($term->term_id) . '" ' . $checked . '>';
            echo '<label for="' . esc_attr($input_name) . '-' . esc_attr($term->term_id) . '"></label>';
            echo '<div class="grain-wrapp">';
            echo '<img class="grain" src="' . esc_url(get_bloginfo('template_url')) . '/assets/img/coffe-filter/grain/grain-' . esc_html($term->name) . '.svg" alt="grain-' . esc_html($term->name) . '" width="' . esc_attr($term->name * 24) . '" height="24">';
            echo '</div>';
            echo '</div>';
        }
    }
    return ob_get_clean();
}




function attribute_woo($name_attr, $name_input, $name_fn_render) {
    global $wp_query;

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array(
            'relation' => 'AND'
        )
    );
    $products_query = new WP_Query($args);
    $product_ids = wp_list_pluck($products_query->posts, 'ID');

    $terms = get_terms_taxonomy($name_attr, $product_ids);

    echo $name_fn_render($terms, wc_attribute_label($name_attr), $name_input, '');
}

function display_all_product_tags() {
    $terms = get_terms(array(
        'taxonomy' => 'product_tag',
        'hide_empty' => true,
    ));
    $count = 0;

    if (! empty($terms) && ! is_wp_error($terms)) {
        echo '<h5 class="coffe-filter__name coffe-filter__name_filter-two">Особливі</h5>';

        foreach ($terms as $term) : $count++; ?>
            <div class="checkbox checkbox_filter-two">
                <input class="custom-checkbox" type="radio" id="special-<?php echo $count; ?>" name="special" value="<?php echo $term->term_id; ?>">
                <label for="special-<?php echo $count; ?>"><?php echo $term->name; ?></label>
            </div>

<?php endforeach;
    }
}

add_action('wp_ajax_filter_products', 'filter_products');
add_action('wp_ajax_nopriv_filter_products', 'filter_products');

function filter_products() {
    $grain = $_POST['grain'];
    $geography = $_POST['geography'];
    $kislinka = $_POST['kislinka'];
    $method = $_POST['method'];
    $type_coffee = $_POST['type-coffee'];
    $special = $_POST['special'];
    $paged = $_POST['page'];


    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 9,
        'paged'     => $paged,
        'tax_query' => array(
            'relation' => 'AND'
        )
    );
   

    // Filter by Degree of roasting (grain)
    add_term_args($args, $grain, 'pa_degree-of-roasting');

    // Filter by Geography (geography)
    add_term_args($args, $geography, 'pa_geography');

    // Filter by Kislynka (kislinka)
    add_term_args($args, $kislinka, 'pa_sour-filter');

    // Filter by method (method)
    add_term_args($args, $method, 'pa_the-method-of-processing');

    //Filter by Type of coffee (type-coffee)
    add_term_args($args, $type_coffee, 'pa_type-coffee');

    // Filter by Labels (special)
    add_term_args($args, $special, 'product_tag');


    $args_terms  = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'paged'     => $paged,
        'tax_query' => array(
            'relation' => 'AND'
        )
    );
    add_term_args($args_terms, $grain, 'pa_degree-of-roasting');
    add_term_args($args_terms, $geography, 'pa_geography');
    add_term_args($args_terms, $kislinka, 'pa_sour-filter');
    add_term_args($args_terms, $method, 'pa_the-method-of-processing');
    add_term_args($args_terms, $type_coffee, 'pa_type-coffee');
    add_term_args($args_terms, $special, 'product_tag');



    // var_dump($args_terms);
    // var_dump($args);
    $products_query = new WP_Query($args);
    $products_query_tax = new WP_Query($args_terms);
    $product_ids_all_tax = wp_list_pluck($products_query_tax->posts, 'ID');

    // Update terms
    $pa_geography = get_terms_taxonomy('pa_geography', $product_ids_all_tax);
    $pa_degree_of_roasting = get_terms_taxonomy('pa_degree-of-roasting', $product_ids_all_tax);
    $pa_kislinka = get_terms_taxonomy('pa_sour-filter', $product_ids_all_tax);
    $pa_the_method_of_processing = get_terms_taxonomy('pa_the-method-of-processing', $product_ids_all_tax);
    $pa_type_coffee = get_terms_taxonomy('pa_type-coffee', $product_ids_all_tax);
    $tag_special = get_terms_taxonomy('product_tag', $product_ids_all_tax);

    $html = '';

    if ($products_query->have_posts()) {
        ob_start();
        while ($products_query->have_posts()) {
            $products_query->the_post();
            get_template_part('template-file/archive-product');
        }
        $html = ob_get_clean();
    } else {
        $html = '<p>No products found.</p>';
    }

    wp_reset_postdata();

    $html_geography = render_term_filter($pa_geography, 'Географія', 'geography', $geography);
    $html_kislinka = render_term_filter($pa_kislinka, 'Кислинка', 'kislinka', $kislinka);
    $html_grain = render_term_filter_grain($pa_degree_of_roasting, 'Ступінь обсмажування', 'grain', $grain);
    $html_method = render_term_filter($pa_the_method_of_processing, 'Спосіб обробки', 'method', $method);
    $html_type_coffee = render_term_filter($pa_type_coffee, 'Вид кави', 'type-coffee', $type_coffee);
    $html_special = render_term_filter($tag_special, 'Особливі', 'special', $special);


    $data = array(
        'success' => true,
        'html' => $html,
        'html_geography' => $html_geography,
        'html_grain' => $html_grain,
        'html_kislinka' => $html_kislinka,
        'html_method' => $html_method,
        'html_type_coffee' => $html_type_coffee,
        'html_special' => $html_special
    );
    echo json_encode($data);

    wp_die();
}
