<?php
/**
 * Template Name: Home Page
 * Template Post Type: page
 *
 * @package destyle
 * @version 2.0
 */
get_header();
?>

<main>
    <?php
    // Получаем слайды из ACF
    $slides = array();
    if (have_rows('home_slider')):
        while (have_rows('home_slider')):
            the_row();
            $slides[] = array(
                'img' => get_sub_field('slide_image'),
                'title' => get_sub_field('slide_title'),
                'text' => get_sub_field('slide_text'),
                'link' => get_sub_field('slide_link'),
            );
        endwhile;
    endif;

    // Если слайдов нет — не выводим ничего
    if (empty($slides)) {
        return;
    }
    ?>
    <div class="container-destyle home-slider-block">
        <div class="destyle-slider-block">
            <div class="destyle-slider-block-left">
                <img src="" alt="">
            </div>
            <div class="destyle-slider-block-right">
                <div class="destyle-slider-block-right-lvl1">
                    <div class="destyle-slider-block-right-lvl1-left">
                        <!-- Здесь JS подставит номера -->
                    </div>
                    <div class="destyle-slider-block-right-lvl1-left-mobi-dots-container"></div>
                    <div class="destyle-slider-block-right-lvl1-right">
                        <h2></h2>
                        <p></p>
                    </div>
                </div>
                <div class="destyle-slider-block-right-lvl2">
                    <button id="destyle-slider-block-right-lvl2-left">
                        <svg width="34" height="15" viewBox="0 0 34 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M33 7.5H1M1 7.5L7.64151 1M1 7.5L7.64151 14" stroke="#1E1E1E" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button id="destyle-slider-block-right-lvl2-right">
                        <svg width="34" height="15" viewBox="0 0 34 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 7.5H33M33 7.5L26.3585 1M33 7.5L26.3585 14" stroke="#1E1E1E" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <a href="#" class="destyle-slider-block-right-lvl2-link"></a>
                </div>
                <div class="destyle-slider-block-right-very-smoll-mobyle"></div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const sliderRoot = document.querySelector(".destyle-slider-block");
            if (!sliderRoot) return;

            // Динамический массив слайдов из PHP
            const slides = <?php echo wp_json_encode($slides, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;

            // 🔄 Предзагрузка всех изображений
            slides.forEach(slide => {
                const img = new Image();
                img.src = slide.img;
            });

            let current = 0;
            let isAnimating = false;

            const imgEl = sliderRoot.querySelector(".destyle-slider-block-left img");
            const titleEl = sliderRoot.querySelector(".destyle-slider-block-right-lvl1-right h2");
            const textEl = sliderRoot.querySelector(".destyle-slider-block-right-lvl1-right p");
            const linkEl = sliderRoot.querySelector(".destyle-slider-block-right-lvl2-link");
            const numbersContainer = sliderRoot.querySelector(".destyle-slider-block-right-lvl1-left");
            const dotsContainerMain = sliderRoot.querySelector(".destyle-slider-block-right-lvl1-left-mobi-dots-container");
            const dotsContainerSm = sliderRoot.querySelector(".destyle-slider-block-right-very-smoll-mobyle");

            function createSlideNumbers() {
                numbersContainer.innerHTML = "";
                slides.forEach((_, i) => {
                    const p = document.createElement("p");
                    p.classList.add("destyle-slider-block-right-lvl1-left-text");
                    if (i === current) p.classList.add("active");
                    p.textContent = i === current ? `_${String(i + 1).padStart(2, "0")}` : String(i + 1).padStart(2, "0");
                    p.addEventListener("click", () => {
                        if (isAnimating || i === current) return;
                        updateSlide(i);
                    });
                    numbersContainer.appendChild(p);
                });
            }

            function createDots(container, activeIndex) {
                container.innerHTML = "";
                slides.forEach((_, i) => {
                    const dot = document.createElement("div");
                    dot.classList.add("destyle-slider-block-right-lvl1-left-mobi-dots");
                    dot.innerHTML = i === activeIndex
                        ? `<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                       <rect y="5.65674" width="8" height="8" transform="rotate(-45 0 5.65674)" fill="#D0043C"/>
                   </svg>`
                        : `<svg width="8" height="8" viewBox="0 0 8 8" fill="none">
                       <circle cx="4" cy="4" r="4" fill="#BAC0C4" />
                   </svg>`;
                    dot.addEventListener("click", () => {
                        if (isAnimating || i === current) return;
                        updateSlide(i);
                    });
                    container.appendChild(dot);
                });
            }

            function updateDots(index) {
                createDots(dotsContainerMain, index);
                createDots(dotsContainerSm, index);
            }

            function updateSlide(index) {
                if (isAnimating) return;
                isAnimating = true;

                const transition = 'opacity 0.3s ease';
                [imgEl, titleEl, textEl, linkEl].forEach(el => {
                    el.style.transition = transition;
                    el.style.opacity = 0;
                });

                const numberEls = sliderRoot.querySelectorAll(".destyle-slider-block-right-lvl1-left-text");
                numberEls[current]?.classList.remove("active");
                numberEls[current].textContent = String(current + 1).padStart(2, '0');
                numberEls[index]?.classList.add("active");
                numberEls[index].textContent = `_${String(index + 1).padStart(2, '0')}`;

                updateDots(index);

                setTimeout(() => {
                    const slide = slides[index];

                    imgEl.src = slide.img;
                    imgEl.alt = slide.title;    // ← вот это
                    imgEl.title = slide.title;    // ← и/или вот это

                    titleEl.textContent = slide.title;
                    textEl.textContent = slide.text;
                    linkEl.href = slide.link;
                    linkEl.textContent = "Узнать подробнее";

                    [imgEl, titleEl, textEl, linkEl].forEach(el => {
                        el.style.opacity = 1;
                    });

                    current = index;
                    isAnimating = false;
                }, 300);

            }

            // Кнопки
            sliderRoot.querySelector("#destyle-slider-block-right-lvl2-right")
                ?.addEventListener("click", () => {
                    if (isAnimating) return;
                    updateSlide((current + 1) % slides.length);
                });
            sliderRoot.querySelector("#destyle-slider-block-right-lvl2-left")
                ?.addEventListener("click", () => {
                    if (isAnimating) return;
                    updateSlide((current - 1 + slides.length) % slides.length);
                });

            // Свайп
            let touchStartX = 0, touchStartY = 0;
            sliderRoot.addEventListener("touchstart", e => {
                if (e.target.closest("button") || e.target.closest("a")) return;
                touchStartX = e.changedTouches[0].screenX;
                touchStartY = e.changedTouches[0].screenY;
            });
            sliderRoot.addEventListener("touchend", e => {
                if (isAnimating) return;
                const dx = e.changedTouches[0].screenX - touchStartX;
                const dy = e.changedTouches[0].screenY - touchStartY;
                if (Math.abs(dx) < 30 || Math.abs(dx) < Math.abs(dy)) return;
                if (dx < 0) updateSlide((current + 1) % slides.length);
                else updateSlide((current - 1 + slides.length) % slides.length);
            });

            // Инициализация
            createSlideNumbers();
            updateDots(current);
            updateSlide(current);
        })();
    </script>



    <div class="container-destyle">
        <?php
        // Получаем 6 самых популярных товаров
        $popular_products = wc_get_products(array(
            'status' => 'publish',
            'limit' => 6,
            'orderby' => 'popularity',
        ));

        if ($popular_products): ?>
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
                        <?php foreach ($popular_products as $prod):
                            $prod_id = $prod->get_id();
                            $prod_link = get_permalink($prod_id);
                            $prod_title = $prod->get_name();
                            $img_id = $prod->get_image_id();
                            $img_src = $img_id
                                ? wp_get_attachment_url($img_id)
                                : wc_placeholder_img_src();
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

                <div class="destye-obs-progress-container" style="display: none;">
                    <div class="destye-obs-progress-bar"></div>
                </div>

                <div class="mode-block-lvl3">
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="b-link-standart2">
                        Все модели
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 11.5H21M21 11.5L17.2642 8M21 11.5L17.2642 15" stroke="#D0043C" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <?php
    // В начале шаблона home-page.php
    $about_title = get_field('about_title');
    $about_accent = get_field('about_accent');
    $about_content = get_field('about_content');
    $about_link = get_field('about_link');
    $about_image = get_field('about_image');

    // Если ничего не задано — ничего не выводим
    if (empty($about_title) && empty($about_accent) && empty($about_content) && empty($about_link) && empty($about_image)) {
        return;
    }
    ?>
    <div class="container-destyle">
        <?php if ($about_title): ?>
            <div class="about-block-title">
                <h2><?php echo esc_html($about_title); ?></h2>
            </div>
        <?php endif; ?>

        <div class="about-block">
            <div class="about-block-right">
                <?php if ($about_accent): ?>
                    <p><?php echo nl2br(esc_html($about_accent)); ?></p>
                <?php endif; ?>

                <?php if ($about_content): ?>
                    <p><?php echo nl2br(esc_html($about_content)); ?></p>
                <?php endif; ?>

                <?php if ($about_link): ?>
                    <a href="<?php echo esc_url($about_link); ?>" class="b-link-standart2">
                        Узнать о нас больше
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 11.5H21M21 11.5L17.2642 8M21 11.5L17.2642 15" stroke="#D0043C" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($about_image): ?>
                <div class="about-block-left">
                    <img src="<?php echo esc_url($about_image); ?>" alt="<?php echo esc_attr($about_title); ?>">
                </div>
            <?php endif; ?>
        </div>
    </div>


    <?php
    // Получаем поля
    $video_title = get_field('video_title');
    $video_file = get_field('video_file');
    $video_placeholder = get_field('video_placeholder'); // ← тут
    $video_accent = get_field('video_accent');
    $video_content = get_field('video_content');

    if (empty($video_title) && empty($video_file) && empty($video_accent) && empty($video_content)) {
        return;
    }
    ?>
    <div class="blac-back">
        <div class="container-destyle">
            <div class="blac-back-content">

                <?php if ($video_title): ?>
                    <h2><?php echo esc_html($video_title); ?></h2>
                <?php endif; ?>

                <div class="blac-back-content-l">

                    <?php if ($video_file): ?>
                        <div class="blac-back-content-l-left">
                            <div class="video-container">
                                <!-- теперь src берётся из ACF -->
                                <?php if ($video_placeholder): ?>
                                    <img class="video-placeholder" src="<?php echo esc_url($video_placeholder); ?>"
                                        alt="<?php echo esc_attr($prod_title); ?>">
                                <?php endif; ?>

                                <video class="video-element" src="<?php echo esc_url($video_file); ?>" preload="metadata"
                                    muted playsinline>
                                </video>

                                <button class="video-stop" aria-label="Остановить видео">■</button>

                                <div class="video-overlay">
                                    <svg width="120" height="120" viewBox="0 0 120 120" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M88.9572 63.469C91.6352 61.9316 91.6352 58.0684 88.9572 56.531L46.9915 32.4396C44.3248 30.9087 41 32.8337 41 35.9086V84.0914C41 87.1663 44.3248 89.0913 46.9915 87.5605L88.9572 63.469Z"
                                            fill="white" />
                                        <circle cx="60" cy="60" r="58" stroke="white" stroke-width="4" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="blac-back-content-l-right">
                        <?php if ($video_accent): ?>
                            <p><?php echo esc_html($video_accent); ?></p>
                        <?php endif; ?>

                        <?php if ($video_content): ?>
                            <p><?php echo esc_html($video_content); ?></p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>





    <div class="container-destyle">
        <div class="mode-block">
            <div class="mode-block-lvl1">
                <div class="mode-block-lvl1-left">
                    <h2>Последние новости</h2>
                </div>
                <div class="mode-block-lvl1-right">
                    <button class="btn-prev" disabled="">
                        <svg viewBox="0 0 34 15" xmlns="http://www.w3.org/2000/svg">
                            <path d="M33 7.5H1M1 7.5L7.64 1M1 7.5L7.64 14" stroke="#1E1E1E" stroke-width="2"
                                stroke-linecap="round"></path>
                        </svg>
                    </button>
                    <button class="btn-next">
                        <svg viewBox="0 0 34 15" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 7.5H33M33 7.5L26.36 1M33 7.5L26.36 14" stroke="#1E1E1E" stroke-width="2"
                                stroke-linecap="round"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="destye-obs-slider-wrap">
                <?php
                // Запрос 6 самых свежих записей
                $recent_posts = new WP_Query([
                    'post_type' => 'post',
                    'posts_per_page' => 6,
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

            <div class="mode-block-lvl3">
                <a href="<?php echo esc_url(get_category_link(21)); ?>" class="b-link-standart">
                    Все новости
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 12H21M21 12L17.2642 8.5M21 12L17.2642 15.5" stroke="white" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>

        </div>
    </div>
</main>

<?php get_footer(); ?>