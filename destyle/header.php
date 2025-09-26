<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/css/style.css">
</head>

<body <?php body_class(); ?>>
    <header class="destyle-header">
        <div class="container-destyle">
            <div class="destyle-header-block">
                <div class="destyle-header-block-mobil-block">
                    <button id="destyle-header-block-mobil-block-button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4H20" stroke="#535D62" stroke-width="2" stroke-linecap="round" />
                            <path d="M4 12H15" stroke="#D0043C" stroke-width="2" stroke-linecap="round" />
                            <path d="M4 20H20" stroke="#535D62" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php if (get_theme_mod('header_logo')): ?>
                        <img src="<?php echo esc_url(get_theme_mod('header_logo')); ?>" alt="<?php bloginfo('name'); ?>"
                            data-no-retina>
                    <?php else: ?>
                        <!-- fallback-логотип -->
                        <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/img/default-logo.png'); ?>"
                            alt="<?php bloginfo('name'); ?>" data-no-retina>
                    <?php endif; ?>
                </a>
                <?php if (has_nav_menu('header_menu')): ?>
                    <nav class="destyle-header-block-menu">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'header_menu',
                            'container' => false,
                            'menu_class' => 'main-menu',
                            'depth' => 2,           // если нужны вложенные только до второго уровня
                            'fallback_cb' => false,
                            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        ));
                        ?>
                    </nav>
                <?php endif; ?>


                <div class="destyle-header-social-block">
                    <?php if (get_theme_mod('header_instagram_link')): ?>
                        <a href="<?php echo esc_url(get_theme_mod('header_instagram_link')); ?>" target="_blank"
                            rel="noopener">
                            <!-- SVG Instagram -->
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2.5" y="2.5" width="19" height="19" rx="4.5" stroke="#535D62" />
                                <circle cx="12" cy="12" r="5.5" stroke="#535D62" />
                                <circle cx="17" cy="6" r="1" fill="#535D62" />
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php if (get_theme_mod('header_vk_link')): ?>
                        <a href="<?php echo esc_url(get_theme_mod('header_vk_link')); ?>" target="_blank" rel="noopener">
                            <!-- SVG VK -->
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 7C5 9.72727 6.48235 15.1818 12.4118 15.1818V11.0909
                             M12.4118 7V11.0909
                             M12.4118 11.0909C14.3333 11.3636 18.3412 10.9273 19 7
                             M12.4118 11.0909C13.7843 11.0909 17.0235 12.0727 19 16" stroke="#535D62" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="header-destyle-mobil-menu-element" style="display: none;">
            <div class="header-destyle-mobil-menu-element-sod">
                <?php if ( has_nav_menu( 'header_menu' ) ) : ?>
    <?php
    wp_nav_menu( array(
        'theme_location' => 'header_menu',
        'container'      => false,
        'items_wrap'     => '<ul id="menu-menu-2" class="mobile-menu">%3$s</ul>',
        'walker'         => new Mobile_Walker_Nav_Menu(),
    ) );
    ?>
<?php endif; ?>

            </div>

        </div>
    </header>