<?php
/**
 * Template Name: Где купить (по флагам)
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
        <h1 class="classic-title-block">
            <?php echo esc_html(get_the_title()); ?>
        </h1>

        <?php if (have_rows('flags_map')): ?>
            <div class="flagi-map">
                <?php while (have_rows('flags_map')):
                    the_row();
                    $img = get_sub_field('flag_image');
                    $link = get_sub_field('flag_link');
                    $country = get_sub_field('flag_country');
                    ?>
                    <a href="<?php echo esc_url($link); ?>" class="flagi-map-element">
                        <?php if ($img): ?>
                            <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($country); ?>">
                        <?php endif; ?>
                        <?php if ($country): ?>
                            <p><?php echo esc_html($country); ?></p>
                        <?php endif; ?>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>




    </div>


</main>



<?php get_footer(); ?>