<?php
/**
 * Archive Product Override — разный вывод для страницы Магазина и для страниц категорий
 */
defined('ABSPATH') || exit;

get_header();
?>

<?php if (function_exists('is_shop') && is_shop()): ?>
    <!-- ==== Страница Магазина (/shop/) ==== -->
    <main>
        <div class="container-destyle">
            <?php if (function_exists('yoast_breadcrumb')): ?>
                <?php
                yoast_breadcrumb(
                    '<nav class="breadcrumbs" aria-label="breadcrumb"><ul><li>',
                    '</li></ul></nav>'
                );
                ?>
            <?php endif; ?>

            <h1 class="classic-title-block">
                <?php
                if (function_exists('woocommerce_page_title')) {
                    woocommerce_page_title();
                } else {
                    single_post_title();
                }
                ?>
            </h1>

            <?php
            // Получаем ID «Uncategorized» и исключаем её
            $uncat = get_term_by('slug', 'uncategorized', 'product_cat');
            $exclude = $uncat ? array($uncat->term_id) : array();

            // Все категории, кроме «Uncategorized»
            $cats = get_terms(array(
                'taxonomy' => 'product_cat',
                'hide_empty' => true,
                'orderby' => 'name',
                'order' => 'ASC',
                'exclude' => $exclude,
            ));

            if ($cats):
                foreach ($cats as $cat):
                    $thumb_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                    $image_url = $thumb_id ? wp_get_attachment_url($thumb_id) : '';

                    $products = wc_get_products(array(
                        'status' => 'publish',
                        'limit' => 4,
                        'category' => array($cat->slug),
                        'orderby' => 'popularity',
                    ));
                    ?>
                    <div class="colection-element mode-block">
                        <h2 class="classic-h2-title">
                            <?php echo esc_html($cat->name); ?>
                        </h2>

                        <?php if ($image_url): ?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($cat->name); ?>">
                        <?php endif; ?>

                        <div class="destye-obs-slider-wrap">
                            <div class="destye-obs-slider-track">
                                <?php foreach ($products as $prod):
                                    $prod_id = $prod->get_id();
                                    $prod_link = get_permalink($prod_id);
                                    $prod_title = $prod->get_name();
                                    $img_id = $prod->get_image_id();
                                    $img_src = $img_id ? wp_get_attachment_url($img_id) : wc_placeholder_img_src();
                                    ?>
                                    <a class="destye-obs-slider-slide" href="<?php echo esc_url($prod_link); ?>">
                                        <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr($prod_title); ?>">
                                        <p><?php echo esc_html($prod_title); ?></p>
                                        <button class="b-link-standart">
                                            Подробнее
                                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 12H21M21 12L17.2642 8.5M21 12L17.2642 15.5" stroke="white" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="destye-obs-progress-container">
                            <div class="destye-obs-progress-bar"></div>
                        </div>

                        <div class="button-el-123">
                            <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="b-link-standart2">
                                Показать больше
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 11.5H21M21 11.5L17.2642 8M21 11.5L17.2642 15" stroke="#D0043C" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach;
            endif;
            ?>
        </div>
    </main>

<?php elseif (function_exists('is_product_category') && is_product_category()): ?>
    <!-- ==== Страница товарной категории (/product-category/...) ==== -->
    <main>
        <div class="container-destyle">
            <?php if (function_exists('yoast_breadcrumb')): ?>
                <?php
                yoast_breadcrumb(
                    '<nav class="breadcrumbs" aria-label="breadcrumb"><ul><li>',
                    '</li></ul></nav>'
                );
                ?>
            <?php endif; ?>

            <h1 class="classic-title2"><?php single_term_title(); ?></h1>

            <?php
            // Получаем текущую категорию
            $term = get_queried_object();
            $cat_id = $term->term_id;
            $cat_name = $term->name;

            // 1) Два поля ACF: акцент и подакцент
            $accent = get_field('product_cat_accent', 'product_cat_' . $cat_id);
            $subaccent = get_field('product_cat_subaccent', 'product_cat_' . $cat_id);

            if ($accent): ?>
                <h2 class="tt-ver2-h2">
                    <?php echo nl2br(esc_html($accent)); ?>
                </h2>
            <?php endif;

            if ($subaccent): ?>
                <p class="prev-text-standart">
                    <?php echo nl2br(esc_html($subaccent)); ?>
                </p>
            <?php endif;

            // 2) Изображение категории
            $thumb_id = get_term_meta($cat_id, 'thumbnail_id', true);
            $image_url = $thumb_id ? wp_get_attachment_url($thumb_id) : '';

            if ($image_url): ?>
                <img class="new-img-class" src="<?php echo esc_url($image_url); ?>"
                    alt="<?php echo esc_attr($cat_name); ?>">
            <?php endif;

            // 3) Все товары этой категории (limit = -1 — без пагинации)
            $all_products = wc_get_products(array(
                'status' => 'publish',
                'limit' => -1,
                'category' => array($term->slug),
            ));

            if ($all_products): ?>
                <div class="modal-block-el">
                    <?php foreach ($all_products as $prod):
                        $pid = $prod->get_id();
                        $plink = get_permalink($pid);
                        $ptitle = $prod->get_name();
                        $img_id = $prod->get_image_id();
                        $img_src = $img_id ? wp_get_attachment_url($img_id) : wc_placeholder_img_src();
                        ?>
                        <a class="destye-obs-slider-slide" href="<?php echo esc_url($plink); ?>">
                            <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr($ptitle); ?>">
                            <p><?php echo esc_html($ptitle); ?></p>
                            <button class="b-link-standart">
                                Подробнее
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 12H21M21 12L17.2642 8.5M21 12L17.2642 15.5" stroke="white" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif;

            // 4) Описание категории (родное поле)
            $description = term_description($cat_id, 'product_cat');
            if ($description): ?>
                <div class="content-element">
                    <?php echo wp_kses_post(wpautop(trim($description))); ?>
                </div>
            <?php endif;

            // 5) Шесть самых популярных товаров на сайте
            $popular = wc_get_products(array(
                'status' => 'publish',
                'limit' => 6,
                'orderby' => 'popularity',
            ));

            if ($popular): ?>
                <div class="mode-block">
                    <div class="mode-block-lvl1">
                        <div class="mode-block-lvl1-left">
                            <h2>Популярные модели</h2>
                        </div>
                        <div class="mode-block-lvl1-right">
                            <button class="btn-prev" disabled>
                                <svg viewBox="0 0 34 15" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M33 7.5H1M1 7.5L7.64 1M1 7.5L7.64 14" stroke="#1E1E1E" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                            </button>
                            <button class="btn-next">
                                <svg viewBox="0 0 34 15" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 7.5H33M33 7.5L26.36 1M33 7.5L26.36 14" stroke="#1E1E1E" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="destye-obs-slider-wrap">
                        <div class="destye-obs-slider-track">
                            <?php foreach ($popular as $prod):
                                $pid = $prod->get_id();
                                $plink = get_permalink($pid);
                                $ptitle = $prod->get_name();
                                $img_id = $prod->get_image_id();
                                $img_src = $img_id ? wp_get_attachment_url($img_id) : wc_placeholder_img_src();
                                ?>
                                <a class="destye-obs-slider-slide" href="<?php echo esc_url($plink); ?>">
                                    <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr($ptitle); ?>">
                                    <p><?php echo esc_html($ptitle); ?></p>
                                    <button class="b-link-standart">
                                        Подробнее
                                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 12H21M21 12L17.2642 8.5M21 12L17.2642 15.5" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="destye-obs-progress-container" style="display: none;">
                        <div class="destye-obs-progress-bar"></div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </main>
<?php endif; ?>

<?php
get_footer();
