<?php
/**
 * Template Name: about Page
 * Template Post Type: page
 *
 * @package destyle
 * @version 2.0
 */
get_header();
?>


<main>

    <?php
    $image = get_field('about_image');
    $title = get_field('about_title');
    $subtitle = get_field('about_subtitle');
    $accent = get_field('about_accent');
    $text = get_field('about_text');
    $shop_url = get_permalink(wc_get_page_id('shop'));
    ?>

    <div class="about-block-1-destely">
        <div class="container-destyle">
            <div class="about-block-1-destely-content">

                <?php if ($image): ?>
                    <div class="about-block-1-destely-content-left">
                        <img src="<?php echo esc_url($image); ?>" alt="" data-no-retina>
                    </div>
                <?php endif; ?>

                <div class="about-block-1-destely-content-right">

                    <?php if ($title): ?>
                        <h1><?php echo esc_html($title); ?></h1>
                    <?php endif; ?>

                    <?php if ($subtitle): ?>
                        <p class="about-block-1-destely-content-right-text1">
                            <?php echo esc_html($subtitle); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($accent): ?>
                        <p class="about-block-1-destely-content-right-text2">
                            <?php echo esc_html($accent); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($text): ?>
                        <div class="about-block-1-destely-content-right-text3">
                            <?php echo wp_kses_post($text); ?>
                        </div>
                    <?php endif; ?>

                    <a href="<?php echo esc_url($shop_url); ?>" class="b-link-standart">
                        <span>Посмотреть каталог</span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 11.5H21M21 11.5L17.2642 8M21 11.5L17.2642 15" stroke="white" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </a>

                </div>
            </div>
        </div>
    </div>


    <?php
    $title = get_field('history_block_title');
    $text = get_field('history_block_text');
    $rows = get_field('history_events');
    ?>
    <div class="about-block2-destyle">
        <div class="container-destyle">
            <div class="about-block-title">
                <?php if ($title): ?>
                    <h2><?php echo esc_html($title); ?></h2><?php endif; ?>
                <?php if ($text): ?>
                    <div class="about-usblock-destely-text">
                        <?php echo wp_kses_post($text); ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($rows): ?>
                <div class="about-time-line">
                    <?php foreach ($rows as $i => $row):
                        // классы preline и lpreline
                        $is_first = $i === 0;
                        $is_last = $i === count($rows) - 1;
                        ?>
                        <div class="about-time-line-element">

                            <div class="about-time-line-element-left">
                                <div class="about-time-line-element-left-content">
                                    <div class="about-time-line-element-top-line-text">
                                        <div class="about-time-line-element-top-line-text-left"></div>
                                        <div class="about-time-line-element-top-line-text-right"></div>
                                    </div>
                                    <?php
                                    // Уже содержит <p>…</p>, поэтому не надо добавлять свой <p>
                                    echo wp_kses_post($row['event_left']);
                                    ?>
                                </div>

                                <div class="about-time-line-element-right-content mobil-version">
                                    <div class="about-time-line-element-top-line-text">
                                        <div class="about-time-line-element-top-line-text-left"></div>
                                        <div class="about-time-line-element-top-line-text-right"></div>
                                    </div>
                                    <?php
                                    // Тоже без дополнительного <p>
                                    echo wp_kses_post($row['event_right']);
                                    ?>
                                </div>
                            </div>

                            <div class="about-time-line-element-center">
                                <?php if ($is_first): ?>
                                    <div class="about-time-line-element-center-preline"></div>
                                <?php endif; ?>

                                <div class="about-time-line-element-center-time-line">
                                    <p><?php echo esc_html($row['event_year']); ?></p>
                                </div>

                                <?php if ($is_last): ?>
                                    <div class="about-time-line-element-center-lpreline"></div>
                                <?php endif; ?>
                            </div>

                            <div class="about-time-line-element-right">
                                <div class="about-time-line-element-right-content">
                                    <div class="about-time-line-element-top-line-text">
                                        <div class="about-time-line-element-top-line-text-left"></div>
                                        <div class="about-time-line-element-top-line-text-right"></div>
                                    </div>
                                    <?php
                                    // И здесь тоже
                                    echo wp_kses_post($row['event_right']);
                                    ?>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <?php if (get_field('enable_about_features') && have_rows('about_features')): ?>
        <div class="about-usblock-destely">
            <div class="container-destyle">
                <div class="about-usblock-destely-sod">
                    <?php while (have_rows('about_features')):
                        the_row();
                        $img = get_sub_field('feature_image');
                        $text = get_sub_field('feature_text');
                        ?>
                        <div class="about-usblock-destely-sod-element">
                            <?php if ($img): ?>
                                <img src="<?php echo esc_url($img); ?>" alt="" data-no-retina>
                            <?php endif; ?>
                            <?php if ($text): ?>
                                <p><?php echo esc_html($text); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php
    $title = get_field('philosophy_title');
    $image = get_field('philosophy_image');
    $items = get_field('philosophy_items');
    if ($title || $image || $items): ?>
        <div class="about-filosof-block">
            <div class="container-destyle">
                <div class="about-block-title title-for-js">
                    <?php if ($title): ?>
                        <h2><?php echo esc_html($title); ?></h2>
                    <?php endif; ?>
                </div>
            </div>

            <div class="about-filosof-block-content">
                <?php if ($image): ?>
                    <div class="about-filosof-block-content-left">
                        <img src="<?php echo esc_url($image); ?>" alt="" class="js-margin">
                    </div>
                <?php endif; ?>

                <?php if ($items): ?>
                    <div class="about-filosof-block-content-right">
                        <div class="about-filosof-block-content-right-sod">
                            <?php foreach ($items as $item): ?>
                                <?php if ($item['item_heading']): ?>
                                    <h3><?php echo esc_html($item['item_heading']); ?></h3>
                                <?php endif; ?>
                                <?php if ($item['item_text']): ?>
                                    <?php echo wp_kses_post($item['item_text']); ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <script>
        // Функция, которая выставляет margin-left у .js-margin
        function alignWithTitle() {
            // Находим элементы
            const titleBlock = document.querySelector('.about-block-title');
            const targetBlock = document.querySelector('.js-margin');
            if (!titleBlock || !targetBlock) return;

            // Получаем отступ от левого края viewport плюс прокрутка
            const titleRect = titleBlock.getBoundingClientRect();
            const titleLeft = titleRect.left + window.pageXOffset;

            // Устанавливаем margin-left в пикселях
            targetBlock.style.marginLeft = `${titleLeft}px`;
        }

        // Вызываем при загрузке страницы
        window.addEventListener('DOMContentLoaded', alignWithTitle);

        // А также при изменении ширины окна
        window.addEventListener('resize', alignWithTitle);

    </script>


    <?php
    $image = get_field('about_production_image');
    $title = get_field('about_production_title');
    $text = get_field('about_production_text');
    $pluses = get_field('about_production_pluses');
    ?>

    <?php if ($image || $title || $text || $pluses): ?>
        <div class="about-last-block-destaly">
            <div class="container-destyle">
                <div class="about-last-block-destaly-content">

                    <?php if ($image): ?>
                        <div class="about-last-block-destaly-content-left">
                            <img src="<?php echo esc_url($image); ?>" alt="" data-no-retina>
                        </div>
                    <?php endif; ?>

                    <div class="about-last-block-destaly-content-right">

                        <?php if ($title): ?>
                            <h2><?php echo esc_html($title); ?></h2>
                        <?php endif; ?>

                        <?php if ($text): ?>

                            <?php echo wp_kses_post($text); ?>

                        <?php endif; ?>

                        <?php if ($pluses): ?>
                            <div class="about-last-block-destaly-content-right-red-block">
                                <?php foreach ($pluses as $plus): ?>
                                    <div class="about-last-block-destaly-content-right-red-block-element">
                                        <?php if ($plus['production_plus_title']): ?>
                                            <h3><?php echo esc_html($plus['production_plus_title']); ?></h3>
                                        <?php endif; ?>
                                        <?php if ($plus['production_plus_text']): ?>
                                            <?php echo wp_kses_post($plus['production_plus_text']); ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div> <!-- .about-last-block-destaly-content-right -->

                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php
    $title = get_field('quality_title');
    $items = get_field('quality_items');
    if ($title || $items): ?>
        <div class="about-kachestvo">
            <div class="container-destyle">
                <div class="about-block-title title-for-js">
                    <?php if ($title): ?>
                        <h2><?php echo esc_html($title); ?></h2>
                    <?php endif; ?>
                </div>
                <?php if ($items): ?>
                    <div class="about-kachestvo-block">
                        <?php foreach ($items as $item): ?>
                            <div class="about-kachestvo-block-element">
                                <?php if ($item['item_highlight']): ?>
                                    <div class="about-kachestvo-block-element-line1">
                                        <?php echo esc_html($item['item_highlight']); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($item['item_text']): ?>
                                    <div class="about-kachestvo-block-element-line2">
                                        <?php echo esc_html($item['item_text']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>


    <?php
    $title = get_field('about_map_title');
    $text = get_field('about_map_text');
    $iframe = get_field('about_map_iframe');
    if ($title || $text || $iframe): ?>
        <div class="about-map-block">
            <div class="container-destyle">
                <div class="about-block-title">
                    <?php if ($title): ?>
                        <h2><?php echo esc_html($title); ?></h2>
                    <?php endif; ?>

                    <?php if ($text): ?>
                        <div class="about-usblock-destely-text">
                            <?php echo wp_kses_post($text); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($iframe): ?>
                <div class="container-destyle map-element">
                    <?php
                    // Выводим необработанный HTML iframe
                    echo $iframe;
                    ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const listItems = document.querySelectorAll(
                ".about-block2-destyle-sod-element ul li"
            );

            listItems.forEach((li) => {
                const svg = document.createElementNS(
                    "http://www.w3.org/2000/svg",
                    "svg"
                );
                svg.setAttribute("width", "16");
                svg.setAttribute("height", "16");
                svg.setAttribute("viewBox", "0 0 16 16");
                svg.setAttribute("fill", "none");
                svg.style.position = "absolute";
                svg.style.left = "0";

                svg.innerHTML = `
              <path d="M1 9L5.78947 15L14 2" stroke="#D0043C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            `;

                li.style.position = "relative";
                li.prepend(svg);
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.getElementById("scrollContainer");
            const thumb = document.getElementById("fakeThumb");
            const scrollbar = document.querySelector(
                ".about-block2-destyle-fake-scrollbar"
            );

            function updateThumb() {
                const containerWidth = container.clientWidth;
                const contentWidth = container.scrollWidth;

                // Если прокрутка не нужна — скрываем скроллбар и выходим
                if (contentWidth <= containerWidth) {
                    scrollbar.style.display = "none";
                    return;
                }

                scrollbar.style.display = "block";

                const scrollLeft = container.scrollLeft;
                const thumbWidth = Math.max(
                    (containerWidth / contentWidth) * scrollbar.clientWidth,
                    30
                );
                const maxTranslate = scrollbar.clientWidth - thumbWidth;
                const scrollRatio = scrollLeft / (contentWidth - containerWidth);
                const translateX = maxTranslate * scrollRatio;

                thumb.style.width = `${thumbWidth}px`;
                thumb.style.transform = `translateX(${translateX}px)`;
            }

            container.addEventListener("scroll", updateThumb);
            window.addEventListener("resize", updateThumb);

            updateThumb(); // Инициализация
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const blocks = document.querySelectorAll(".about-like-block");

            blocks.forEach((block) => {
                const scrollWrapper = block.querySelector(
                    ".about-like-block-scroll-wrapper"
                );
                const thumb = block.querySelector(".about-like-fake-thumb");
                const scrollbar = block.querySelector(".about-like-fake-scrollbar");

                if (!scrollWrapper || !thumb || !scrollbar) return;

                function updateThumb() {
                    if (window.innerWidth > 600) {
                        scrollbar.style.display = "none";
                        return;
                    }

                    const visibleWidth = scrollWrapper.clientWidth;
                    const totalWidth = scrollWrapper.scrollWidth;

                    if (totalWidth <= visibleWidth) {
                        scrollbar.style.display = "none";
                        return;
                    }

                    scrollbar.style.display = "block";

                    const scrollLeft = scrollWrapper.scrollLeft;
                    const thumbWidth = Math.max(
                        (visibleWidth / totalWidth) * scrollbar.clientWidth,
                        30
                    );
                    const maxTranslate = scrollbar.clientWidth - thumbWidth;
                    const scrollRatio = scrollLeft / (totalWidth - visibleWidth);
                    const translateX = maxTranslate * scrollRatio;

                    thumb.style.width = `${thumbWidth}px`;
                    thumb.style.transform = `translateX(${translateX}px)`;
                }

                scrollWrapper.addEventListener("scroll", updateThumb);
                window.addEventListener("resize", updateThumb);

                updateThumb();
            });
        });
    </script>
</main>



<?php get_footer(); ?>