<?php
// single.php
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
        <h1 class="classic-title-block">
            <?php the_title(); ?>
        </h1>

        <p class="news-data">
            <?php echo get_the_date('j F Y'); ?>
        </p>

        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('full', ['class' => 'news-img-block', 'alt' => get_the_title()]); ?>
        <?php endif; ?>

        <div class="news-element-content-sod">
            <?php
            // Выводим содержимое текущей записи, разбив на абзацы автоматически
            the_content();
            ?>
        </div>


        <div class="mode-block">
            <div class="mode-block-lvl1">
                <div class="mode-block-lvl1-left">
                    <h2>Последние новости</h2>
                </div>

            </div>

            <div class="destye-obs-slider-wrap">
                <?php
                // Запрос 4 самых свежих записей
                $recent_posts = new WP_Query([
                    'post_type' => 'post',
                    'posts_per_page' => 4,
                    'orderby' => 'date',
                    'order' => 'DESC',
                ]);
                if ($recent_posts->have_posts()): ?>
                    <div class="destye-obs-slider-track">
                        <?php while ($recent_posts->have_posts()):
                            $recent_posts->the_post(); ?>
                            <a class="destye-obs-slider-slide" href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()): ?>
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'full')); ?>"
                                        alt="<?php echo esc_attr(get_the_title()); ?>">
                                <?php else: ?>
                                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/img/placeholder.png'); ?>"
                                        alt="<?php echo esc_attr(get_the_title()); ?>">
                                <?php endif; ?>

                                <div class="destye-obs-slider-slide-blog-info">
                                    <p><?php echo esc_html(get_the_date('j F')); ?></p>
                                    <p>
                                        <?php
                                        $title = get_the_title();
                                        echo esc_html(mb_substr($title, 0, 28, 'UTF-8') . '…');
                                        ?>
                                    </p>
                                </div>

                                <button class="b-link-standart2">Подробнее
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 11.5H21M21 11.5L17.2642 8M21 11.5L17.2642 15" stroke="#D0043C"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </a>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="destye-obs-progress-container" style="display: none;">
                <div class="destye-obs-progress-bar" style="width: 16.6667%; left: 0%;"></div>
            </div>


        </div>

    </div>


</main>

<?php get_footer(); ?>