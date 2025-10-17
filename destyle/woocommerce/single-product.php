<?php
/**
 * Override: single-product.php
 * Ваша тема: your-theme/woocommerce/single-product.php
 */

defined('ABSPATH') || exit;

// Подключаем шапку
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
    <?php
    // Получаем объект текущего продукта
    global $product;
    if (!$product) {
      $product = wc_get_product(get_the_ID());
    }

    // 1) Название товара
    $product_name = $product->get_name(); // WooCommerce Product Name :contentReference[oaicite:0]{index=0}
    
    // 2) Основное изображение товара
    $image_id = $product->get_image_id();                  // ID изображения :contentReference[oaicite:1]{index=1}
    $image_url = $image_id
      ? wp_get_attachment_url($image_id)                 // URL изображения :contentReference[oaicite:2]{index=2}
      : wc_placeholder_img_src();                          // Заглушка, если нет картинки
    ?>

    <img class="img-model" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product_name); ?>" />
    <h1 class="classic-title-block product">
      <?php echo esc_html($product_name); ?>
    </h1>

  </div>
  <div class="product-harakt">
    <div class="container-destyle">
      <?php
      global $product;

      // Получаем все атрибуты товара
      $attributes = $product->get_attributes();

      if (!empty($attributes)): ?>
        <div class="product-harakt-sod">
          <?php foreach ($attributes as $attribute):

            // Получаем человекочитаемое название атрибута
            $name = wc_attribute_label($attribute->get_name());

            // Получаем массив значений
            if ($attribute->is_taxonomy()) {
              // атрибут как таксономия
              $values = wc_get_product_terms(
                $product->get_id(),
                $attribute->get_name(),
                array('fields' => 'names')
              );
            } else {
              // кастомный атрибут
              $values = $attribute->get_options();
            }

            // Собираем строку через запятую
            $value = implode(', ', $values);
            ?>
            <div class="product-harakt-sod-element">
              <div class="product-harakt-sod-element-left">
                <p><?php echo esc_html($name); ?></p>
              </div>
              <div class="product-harakt-sod-element-center"></div>
              <div class="product-harakt-sod-element-right">
                <p><?php echo esc_html($value); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <div class="product-harakt-sod2">
        <a href="<?php echo esc_url(get_permalink(175)); ?>" class="clas-button5">
          где купить
        </a>

        <div>
          <?php
          // Получаем URL файла
          $file_url = get_field('product_download_file');

          if ($file_url): ?>
            <a href="<?php echo esc_url($file_url); ?>" class="product-harakt-sod2-gde-kupit" download>
              <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/img/button.png'); ?>" alt="Скачать файл" />
              <p>План модулей для создания модели</p>
            </a>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
  <div class="container-destyle">
    <?php
    global $product;
    // Получаем краткое описание (Short Description)
    $short_desc = $product->get_short_description();

    // Если краткого описания нет — блок не выводится
    if ($short_desc): ?>
      <div class="product-vash-infa">
        <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/img/Group 54.png'); ?>" alt="">
        <p><?php echo wp_kses_post($short_desc); ?></p>
      </div>
    <?php endif; ?>

    <?php
// Вывод блока "Дополнительные функции" в шаблоне single-product.php или include-файле
if ( get_field( 'enable_additional_functions' ) ) :
    $items = get_field( 'additional_functions' );
    if ( ! empty( $items ) ) : ?>
        <div class="product-dop-functions">
            <h2>Дополнительные функции</h2>
            <div class="product-dop-functions-content">
                <?php foreach ( $items as $item ) :
                    // Подстраховка: значения полей
                    $desc         = ! empty( $item['description'] )  ? $item['description']  : '';
                    $overlay_text = ! empty( $item['overlay_text'] ) ? $item['overlay_text'] : 'Узнать больше';
                    $img          = ! empty( $item['image'] )        ? $item['image']        : '';
                    $link1        = ! empty( $item['link1'] )        ? $item['link1']        : '';
                    $link2        = ! empty( $item['link2'] )        ? $item['link2']        : '';
                    $has_links    = $link1 || $link2;
                    ?>
                    <div class="product-dop-functions-content-element">
                        <!-- Оверлей с текстом при наведении -->
                        <div
                            class="custom-overlay"
                            <?php if ( $has_links ) : ?>
                                style="height: calc(100% - 60px) !important;"
                            <?php endif; ?>
                        >
                            <?php echo esc_html( $overlay_text ); ?>
                        </div>

                        <div
                            class="product-dop-functions-content-element-sod"
                            <?php if ( ! $has_links ) : ?>style="margin-bottom:0 !important;"<?php endif; ?>
                        >
                            <?php if ( $desc ) : ?>
                                <p><?php echo nl2br( esc_html( $desc ) ); ?></p>
                            <?php endif; ?>

                            <?php if ( $img ) : ?>
                                <img src="<?php echo esc_url( $img ); ?>" alt="">
                            <?php endif; ?>
                        </div>

                        <?php if ( $has_links ) : ?>
                            <div class="product-dop-functions-content-element-url">
                                <?php if ( $link1 ) : ?>
                                    <a href="<?php echo esc_url( $link1 ); ?>">
                                        <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/img/button1.png' ); ?>" alt="">
                                    </a>
                                <?php endif; ?>

                                <?php if ( $link2 ) : ?>
                                    <a href="<?php echo esc_url( $link2 ); ?>">
                                        <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/img/button2.png' ); ?>" alt="">
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif;
endif;
?>

    <?php
    global $product;

    // Получаем ID всех изображений галереи (кроме основной)
    $gallery_ids = $product->get_gallery_image_ids();

    if (!empty($gallery_ids)): ?>
      <div class="product-photo-block">
        <?php foreach ($gallery_ids as $image_id):
          // URL изображения
          $image_url = wp_get_attachment_url($image_id);
          // Альт-текст изображения
          $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
          ?>
          <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($alt_text); ?>" />
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php
    $set = get_field('recommended_set');
    if (!empty($set)):
      $img_url = $set['set_image'];
      $file_url = $set['set_file'];
      ?>
      <div class="product-recomend">
        <h2>Рекомендованная комплектация гарнитура</h2>
        <div class="product-recomend-delement">
          <div>
            <?php if ($img_url): ?>
              <img src="<?php echo esc_url($img_url); ?>" alt="">
            <?php endif; ?>
          </div>
          <div>
            <p>План модулей для создания модели</p>
            <?php if ($file_url): ?>
              <a href="<?php echo esc_url($file_url); ?>" download>
                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/img/button.png'); ?>" alt="">
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php
    // Проверяем включён ли блок
    if (get_field('enable_product_legs') && have_rows('product_legs')): ?>
      <div class="product-nogi">
        <h2>Ножки</h2>
        <div class="product-nogi-slider">
          <div class="product-nogi-slider__container">
            <div class="product-nogi-slider__track">
              <?php while (have_rows('product_legs')):
                the_row();
                $img = get_sub_field('leg_image');
                $text = get_sub_field('leg_text');
                ?>
                <div class="product-nogi-slider__slide">
                  <?php if ($img): ?>
                    <div class="product-nogi-slider__slide-imgelement"
                      style="background-image: url(<?php echo esc_url($img); ?>);">

                    </div>
                  <?php endif; ?>
                  <?php if ($text): ?>
                    <p><?php echo esc_html($text); ?></p>
                  <?php endif; ?>
                </div>
              <?php endwhile; ?>
            </div>
          </div>
          <div class="product-nogi-slider__scrollbar">
            <div class="product-nogi-slider__thumb"></div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php
    // Проверяем, включён ли блок «Ткани» и есть ли записи
    if (get_field('enable_product_fabrics') && have_rows('product_fabrics')): ?>
      <div class="product-nogi">
        <h2>Ткани</h2>
        <div class="product-nogi-slider">
          <div class="product-nogi-slider__container">
            <div class="product-nogi-slider__track">
              <?php while (have_rows('product_fabrics')):
                the_row();
                $img = get_sub_field('fabric_image');
                $text = get_sub_field('fabric_text');
                ?>
                <div class="product-nogi-slider__slide">
                  <?php if ($img): ?>
                    <div class="product-nogi-slider__slide-imgelement"
                      style="background-image: url(<?php echo esc_url($img); ?>);">

                    </div>
                  <?php endif; ?>
                  <?php if ($text): ?>
                    <p><?php echo esc_html($text); ?></p>
                  <?php endif; ?>
                </div>
              <?php endwhile; ?>
            </div>
          </div>
          <div class="product-nogi-slider__scrollbar">
            <div class="product-nogi-slider__thumb"></div>
          </div>
        </div>
      </div>
    <?php endif; ?>


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
                <path d="M33 7.5H1M1 7.5L7.64 1M1 7.5L7.64 14" stroke="#1E1E1E" stroke-width="2" stroke-linecap="round" />
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
                  <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
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

</main>
<script>
  // ===== product-nogi-slider.js =====
  document.addEventListener('DOMContentLoaded', () => {
    // Инициализируем для каждого .product-nogi-slider на странице
    document.querySelectorAll('.product-nogi-slider').forEach(slider => {
      const container = slider.querySelector('.product-nogi-slider__container');
      const scrollbar = slider.querySelector('.product-nogi-slider__scrollbar');
      const thumb = slider.querySelector('.product-nogi-slider__thumb');
      let isDragging = false;
      let startX = 0;
      let scrollStart = 0;

      // Обновляем thumb
      function updateThumb() {
        if (window.innerWidth > 500) {
          scrollbar.style.display = 'none';
          return;
        }
        const cw = container.clientWidth;
        const sw = container.scrollWidth;
        if (sw <= cw) {
          scrollbar.style.display = 'none';
          return;
        }
        scrollbar.style.display = 'block';
        const trackW = scrollbar.clientWidth;
        const thumbW = Math.max((cw / sw) * trackW, 30);
        const maxTrans = trackW - thumbW;
        const ratio = container.scrollLeft / (sw - cw);
        const tx = maxTrans * ratio;
        thumb.style.width = `${thumbW}px`;
        thumb.style.transform = `translateX(${tx}px)`;
      }

      // Старт перетаскивания
      function startDrag(pageX) {
        if (window.innerWidth > 500) return;
        isDragging = true;
        startX = pageX - container.getBoundingClientRect().left;
        scrollStart = container.scrollLeft;
        container.classList.add('dragging');
      }
      // Движение при drag/touch
      function onDragMove(pageX) {
        if (!isDragging) return;
        const x = pageX - container.getBoundingClientRect().left;
        const walk = x - startX;
        container.scrollLeft = scrollStart - walk;
      }
      // Окончание drag
      function endDrag() {
        isDragging = false;
        container.classList.remove('dragging');
      }

      // Слушатели мыши
      container.addEventListener('mousedown', e => startDrag(e.pageX));
      container.addEventListener('mousemove', e => onDragMove(e.pageX));
      container.addEventListener('mouseup', endDrag);
      container.addEventListener('mouseleave', endDrag);

      // Слушатели тача
      container.addEventListener('touchstart', e => startDrag(e.touches[0].pageX));
      container.addEventListener('touchmove', e => onDragMove(e.touches[0].pageX));
      container.addEventListener('touchend', endDrag);

      // Пересчёт thumb на скролл/resize
      container.addEventListener('scroll', updateThumb);
      window.addEventListener('resize', updateThumb);

      // Инициализация
      updateThumb();
    });
  });

</script>
<script>
  window.addEventListener('load', function () {
    // 1) Параграфы внутри .product-dop-functions-content-element-sod
    const ps = document.querySelectorAll('.product-dop-functions-content-element-sod p');
    let maxP = 0;
    // Сбрось предыдущие инлайн-высоты и замерь
    ps.forEach(p => {
      p.style.height = 'auto';
      maxP = Math.max(maxP, p.offsetHeight);
    });
    // Проставь всем одинаковую высоту
    ps.forEach(p => {
      p.style.height = maxP + 'px';
    });

    // 2) Вся обёртка .product-dop-functions-content-element-sod
    const sods = document.querySelectorAll('.product-dop-functions-content-element-sod');
    let maxSod = 0;
    sods.forEach(el => {
      el.style.height = 'auto';
      maxSod = Math.max(maxSod, el.offsetHeight);
    });
    sods.forEach(el => {
      el.style.height = maxSod + 'px';
    });
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Находим все ссылки с этим классом
    var links = document.querySelectorAll('.product-harakt-sod2-gde-kupit');

    links.forEach(function (link) {
      // внутри ссылки — картинка
      var img = link.querySelector('img');
      if (!img) return;

      // запомним оригинальный src
      var originalSrc = img.src;
      // сформируем hover-src заменой имени файла
      var hoverSrc = originalSrc.replace(/button\.png$/, 'buttonhover.png');

      // при наведении — меняем на hover
      link.addEventListener('mouseenter', function () {
        img.src = hoverSrc;
      });
      // при убирании — возвращаем оригинал
      link.addEventListener('mouseleave', function () {
        img.src = originalSrc;
      });
    });
  });
</script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.custom-overlay').forEach(function (ov) {
      // 1) Определяем, нужен ли скролл
      var needsScroll = ov.scrollHeight > ov.clientHeight;

      if (needsScroll) {
        // 2) Включаем скролл и прижимаем текст к верху
        ov.style.overflowY = 'auto';
        ov.style.alignItems = 'flex-start';
        ov.style.paddingTop = '1em';         // отступ, чтобы текст не упирался вплотную
        ov.style.pointerEvents = 'auto';       // чтобы внутри можно было скроллить
      } else {
        // если влезает — просто скрываем скролл
        ov.style.overflowY = 'hidden';
        // (alignItems остаётся то, что в CSS: center)
      }

      // 3) При наведении сбрасываем прокрутку на самое начало
      var container = ov.closest('.product-dop-functions-content-element');
      if (container) {
        container.addEventListener('mouseenter', function () {
          ov.scrollTop = 0;
        });
      }

      // 4) Перехватываем колесо, чтобы не прокручивалась страница
      ov.addEventListener('wheel', function (e) {
        var delta = e.deltaY;
        var atTop = this.scrollTop === 0;
        var atBottom = this.scrollTop + this.clientHeight >= this.scrollHeight;

        if ((delta < 0 && atTop) || (delta > 0 && atBottom)) {
          e.preventDefault();
        }
        e.stopPropagation();
      }, { passive: false });
    });
  });


</script>

<?php
// Подключаем футер
get_footer();
