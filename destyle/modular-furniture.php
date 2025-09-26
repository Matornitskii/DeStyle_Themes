<?php
/**
 * Template Name: Модульная мебель
 * Template Post Type: page
 *
 * @package destyle
 * @version 2.0
 */
get_header();
?>

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
        <?php if (has_post_thumbnail(get_the_ID())): ?>
            <?php
            // выводим миниатюру страницы full-размера с нужным классом и alt = заголовок страницы
            the_post_thumbnail(
                'full',
                [
                    'class' => 'img-model',
                    'alt' => esc_attr(get_the_title())
                ]
            );
            ?>
        <?php endif; ?>


        <h1 class="classic-title-block">
            <?php echo esc_html(get_the_title()); ?>
        </h1>
        <div class="modal-block-el">
            <?php
            // Получаем все опубликованные товары WooCommerce
            $products = wc_get_products(array(
                'status' => 'publish',
                'limit' => -1,       // без лимита
                'orderby' => 'date',   // по дате
                'order' => 'DESC',
            ));

            if (!empty($products)) {
                foreach ($products as $product) {
                    // Ссылка на товар
                    $link = $product->get_permalink();

                    // URL изображения "большого" размера; возвращает false, если не задано
                    $img_url = wp_get_attachment_image_url($product->get_image_id(), 'large');

                    // Название товара
                    $title = $product->get_name();
                    ?>
                    <a class="destye-obs-slider-slide" href="<?php echo esc_url($link); ?>">
                        <?php if ($img_url): ?>
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?>">
                        <?php else: ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/img/placeholder.png'); ?>"
                                alt="Нет изображения">
                        <?php endif; ?>
                        <p><?php echo esc_html($title); ?></p>
                        <button class="b-link-standart">
                            Подробнее
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 12H21M21 12L17.2642 8.5M21 12L17.2642 15.5" stroke="white" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </svg>
                        </button>
                    </a>
                    <?php
                }
                // Возвращаем глобальную переменную $post в исходное состояние, если она менялась
                wp_reset_postdata();
            } else {
                echo '<p>Товары не найдены.</p>';
            }
            ?>
            

        </div>
        <div class="modal-block-el2" style="margin-bottom: 80px;"><?php the_content(); ?></div>
        
        


    </div>
</main>

<?php get_footer(); ?>