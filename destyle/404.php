<?php
// 404.php
defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main>
        <div class="error404">
            <div class="container-destyle">
                <div class="error404-element">
                    <div>
  <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/image 90.png" alt="">
</div>

                    <div>
                        <p><span>Ошибка 404:</span> Запрашиваемая Вами страница не найдена</p>
                        <a href="/" class="b-link-standart">НА ГЛАВНУЮ
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 12H21M21 12L17.2642 8.5M21 12L17.2642 15.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php
get_footer();
