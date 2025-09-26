<?php
// category.php
defined('ABSPATH') || exit;

get_header(); ?>

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
        <?php
        // Получаем текущую рубрику
        $term = get_queried_object();
        $term_name = $term->name;

        // Берём URL изображения из ACF-поля 'category_image'
        $image_url = get_field('category_image', $term);
        ?>

        <?php if ($image_url): ?>
            <img class="img-model" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term_name); ?>">
        <?php endif; ?>

        <h1 class="classic-title-block">
            <?php echo esc_html($term_name); ?>
        </h1>

        <?php
        defined('ABSPATH') || exit;

        // 1) стартовые параметры
        $paged = 1;
        $per_page = 9;

        // 2) первоначальный запрос
        $news = new WP_Query([
            'post_type' => 'post',
            'posts_per_page' => $per_page,
            'paged' => $paged,
        ]);

        if ($news->have_posts()):
            $max_pages = $news->max_num_pages;
            ?>
            <!-- контейнер ваших ссылок -->
            <div class="modal-block-el" id="ajax-news-container" data-paged="<?php echo $paged; ?>"
                data-max="<?php echo $max_pages; ?>">
                <?php while ($news->have_posts()):
                    $news->the_post(); ?>
                    <a class="destye-obs-slider-slide" href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('full'); ?>
                        <?php else: ?>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/placeholder.png" alt="">
                        <?php endif; ?>

                        <div class="destye-obs-slider-slide-blog-info">
                            <p><?php echo get_the_date('j F Y'); ?></p>
                            <p><?php echo esc_html(get_the_title()); ?></p>
                        </div>

                        <button class="b-link-standart">Подробнее
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 12H21M21 12L17.2642 8.5M21 12L17.2642 15.5" stroke="white" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </a>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </div>

            <?php if ($max_pages > 1): ?>
                <div class="button-model-el-bol" id="load-more-news">
                    <a href="#" class="b-link-standart2">
                        Загрузить ещё
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 11.5H21M21 11.5L17.2642 8M21 11.5L17.2642 15" stroke="#D0043C" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <p>Новостей нет.</p>
        <?php endif; ?>


    </div>
</main>

<?php get_footer(); ?>