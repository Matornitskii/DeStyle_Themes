<?php
get_header();
?>

<main id="main-content">
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
        <div class="news-element-content-sod">
            <?php
            // Выводим содержимое текущей записи, разбив на абзацы автоматически
            the_content();
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>