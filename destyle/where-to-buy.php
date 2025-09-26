<?php
/**
 * Template Name: Где купить Page
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
            <?php yoast_breadcrumb(
                '<nav class="breadcrumbs" aria-label="breadcrumb"><ul><li>',
                '</li></ul></nav>'
            ); ?>
        <?php endif; ?>

        <h1 class="classic-title-block">Где купить</h1>

        <?php
        $countries = get_field('purchase_countries');
        if ($countries): ?>
            <div class="pred-spis-element">
                <div class="vipad-spis">
                    <div class="selected"></div>
                    <ul class="options-list">
                        <?php foreach ($countries as $idx => $country): ?>
                            <li data-index="<?php echo esc_attr($idx); ?>">
                                <?php echo esc_html($country['country_name']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="content-sod-vipad-spis">
                    <?php foreach ($countries as $idx => $country): ?>
                        <div class="content-sod-vipad-spis-element"
                            style="display: <?php echo $idx === 0 ? 'block' : 'none'; ?>;">
                            <div class="content-sod-vipad-spis-element-sod">
                                <?php if (!empty($country['country_cities'])): ?>
                                    <?php foreach ($country['country_cities'] as $city): ?>
                                        <div class="content-sod-vipad-spis-element-sod-el">
                                            <?php if (!empty($city['city_name'])): ?>
                                                <p class="content-sod-vipad-spis-element-sod-el-title">
                                                    <?php echo esc_html($city['city_name']); ?>
                                                </p>
                                            <?php endif; ?>
                                            <?php if (!empty($city['city_contact'])): ?>
                                                <p class="content-sod-vipad-spis-element-sod-el-adr">
                                                    <?php echo wp_kses_post($city['city_contact']); ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const vipad = document.querySelector('.vipad-spis');
                    const selected = vipad.querySelector('.selected');
                    const options = Array.from(vipad.querySelectorAll('.options-list li'));
                    const contents = Array.from(document.querySelectorAll('.content-sod-vipad-spis-element'));

                    function selectByIndex(idx) {
                        const li = options[idx];
                        if (!li) return;
                        selected.textContent = li.textContent.trim();
                        options.forEach((o, i) => o.classList.toggle('active', i === idx));
                        contents.forEach((c, i) => {
                            c.style.display = (i === idx) ? 'block' : 'none';
                        });
                    }

                    // открыть/закрыть список
                    selected.addEventListener('click', () => {
                        vipad.classList.toggle('open');
                    });

                    // выбор пункта
                    options.forEach((li, idx) => {
                        li.addEventListener('click', () => {
                            selectByIndex(idx);
                            vipad.classList.remove('open');
                        });
                    });

                    // клик вне — закрыть
                    document.addEventListener('click', e => {
                        if (!vipad.contains(e.target)) {
                            vipad.classList.remove('open');
                        }
                    });

                    // deep link ?id=
                    const params = new URLSearchParams(window.location.search);
                    const idParam = parseInt(params.get('id'), 10);
                    const defaultIdx = (!isNaN(idParam) && idParam >= 1 && idParam <= options.length)
                        ? idParam - 1
                        : 0;

                    selectByIndex(defaultIdx);
                });
            </script>
        <?php endif; ?>
    </div>


    <?php
    // получаем iframe-код
    $iframe = get_field('purchase_map_iframe');
    if ($iframe): ?>
        <div class="container-destyle map-element">
            <?php
            // выводим «сырой» код iframe
            echo $iframe;
            ?>
        </div>
    <?php endif; ?>

    <?php
    // поля ACF
    $bg = get_field('wtb_form_bg');
    $text = get_field('wtb_form_text');
    $shortcode = get_field('wtb_form_shortcode');

    if ($shortcode): ?>
        <div class="contact-block-pole" style="background-image: url(<?php echo esc_url($bg); ?>);">
            <div class="container-destyle">
                <div class="contact-block-pole-element">
                    <?php if ($text): ?>
                        <div class="contact-block-pole-element-left">
                            <?php echo wp_kses_post($text); ?>
                        </div>
                    <?php endif; ?>

                    <div class="contact-block-pole-element-right">
                        <div class="contact-block-pole-element-right-form">
                            <?php echo do_shortcode($shortcode); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</main>



<?php get_footer(); ?>