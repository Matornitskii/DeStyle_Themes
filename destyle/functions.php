<?php
/**
 * @package destyle
 * @version 2.0
 */

// Подключаем style.css
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('destyle-style', get_stylesheet_uri());
});

// Поддержка тегов <title>
add_theme_support('title-tag');

// Поддержка миниатюр
add_theme_support('post-thumbnails');



// Регистрируем группу полей ACF для слайдера на шаблоне Home Page
add_action('acf/init', function () {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_home_slider',
            'title' => 'Home Page Slider',
            'fields' => array(
                array(
                    'key' => 'field_home_slider',
                    'label' => 'Slides',
                    'name' => 'home_slider',
                    'type' => 'repeater',
                    'layout' => 'row',
                    'button_label' => 'Добавить слайд',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_slide_image',
                            'label' => 'Изображение',
                            'name' => 'slide_image',
                            'type' => 'image',
                            'return_format' => 'url',
                            'preview_size' => 'medium',
                        ),
                        array(
                            'key' => 'field_slide_title',
                            'label' => 'Заголовок',
                            'name' => 'slide_title',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_slide_text',
                            'label' => 'Текст',
                            'name' => 'slide_text',
                            'type' => 'textarea',
                        ),
                        array(
                            'key' => 'field_slide_link',
                            'label' => 'Ссылка',
                            'name' => 'slide_link',
                            'type' => 'url',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'home-page.php',
                    ),
                ),
            ),
        ));
    }
});


// В functions.php или подключаемом файле
add_action('acf/init', function () {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_home_about',
            'title' => 'Home Page About',
            'fields' => array(
                array(
                    'key' => 'field_about_title',
                    'label' => 'Заголовок секции',
                    'name' => 'about_title',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_about_accent',
                    'label' => 'Акцентный текст',
                    'name' => 'about_accent',
                    'type' => 'textarea',
                    'instructions' => 'Будет выведено в первом <p> целиком.',
                    'new_lines' => 'none',
                ),
                array(
                    'key' => 'field_about_content',
                    'label' => 'Основной текст',
                    'name' => 'about_content',
                    'type' => 'textarea',
                    'instructions' => 'Будет выведено во втором <p> целиком.',
                    'new_lines' => 'none',
                ),
                array(
                    'key' => 'field_about_link',
                    'label' => 'Ссылка на страницу “О нас”',
                    'name' => 'about_link',
                    'type' => 'url',
                ),
                array(
                    'key' => 'field_about_image',
                    'label' => 'Изображение',
                    'name' => 'about_image',
                    'type' => 'image',
                    'return_format' => 'url',
                    'preview_size' => 'medium',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'home-page.php',
                    ),
                ),
            ),
        ));
    }
});

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group(array(
        'key' => 'group_home_video',
        'title' => 'Home Page Video',
        'fields' => array(
            array(
                'key' => 'field_video_title',
                'label' => 'Заголовок видео-секции',
                'name' => 'video_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_video_file',
                'label' => 'Видео-файл',
                'name' => 'video_file',
                'type' => 'file',
                'return_format' => 'url',
                'library' => 'all',
                'mime_types' => 'mp4,mov,webm',
            ),
            // ← новое поле для заглушки
            array(
                'key' => 'field_video_placeholder',
                'label' => 'Картинка-заглушка',
                'name' => 'video_placeholder',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_video_accent',
                'label' => 'Акцентный текст',
                'name' => 'video_accent',
                'type' => 'textarea',
                'new_lines' => 'none',
            ),
            array(
                'key' => 'field_video_content',
                'label' => 'Основной текст',
                'name' => 'video_content',
                'type' => 'textarea',
                'new_lines' => 'none',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'home-page.php',
                ),
            ),
        ),
    ));
});


add_action('customize_register', 'theme_footer_customize');
function theme_footer_customize(WP_Customize_Manager $wp_customize)
{
    // 1) Добавляем секцию
    $wp_customize->add_section('footer_settings', array(
        'title' => 'Настройка футера темы',
        'priority' => 160,
        'description' => 'Здесь можно задать логотип футера и ссылки на соцсети',
    ));

    // 2) Логотип футера
    $wp_customize->add_setting('footer_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'footer_logo',
        array(
            'label' => 'Логотип футера',
            'section' => 'footer_settings',
            'settings' => 'footer_logo',
        )
    ));

    // 3) Ссылка на Instagram
    $wp_customize->add_setting('instagram_link', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('instagram_link', array(
        'label' => 'Ссылка на Instagram',
        'section' => 'footer_settings',
        'type' => 'url',
        'settings' => 'instagram_link',
    ));

    // 4) Ссылка на ВКонтакте
    $wp_customize->add_setting('vk_link', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('vk_link', array(
        'label' => 'Ссылка на ВКонтакте',
        'section' => 'footer_settings',
        'type' => 'url',
        'settings' => 'vk_link',
    ));
}


add_action('after_setup_theme', 'theme_register_menus');
function theme_register_menus()
{
    register_nav_menus(array(
        'header_menu' => __('Меню шапки', 'your-textdomain'),
        'footer_links' => __('Полезные ссылки футера', 'your-textdomain'),
    ));
}

add_action('customize_register', 'theme_header_customize');
function theme_header_customize(WP_Customize_Manager $wp_customize)
{
    // Секция для шапки
    $wp_customize->add_section('header_settings', array(
        'title' => 'Настройка шапки сайта',
        'priority' => 120,
        'description' => 'Задайте логотип шапки и ссылки на соцсети',
    ));

    // Логотип шапки
    $wp_customize->add_setting('header_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'header_logo',
        array(
            'label' => 'Логотип шапки',
            'section' => 'header_settings',
            'settings' => 'header_logo',
        )
    ));

    // Ссылка на Instagram в шапке
    $wp_customize->add_setting('header_instagram_link', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('header_instagram_link', array(
        'label' => 'Instagram (шапка)',
        'section' => 'header_settings',
        'type' => 'url',
        'settings' => 'header_instagram_link',
    ));

    // Ссылка на ВКонтакте в шапке
    $wp_customize->add_setting('header_vk_link', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('header_vk_link', array(
        'label' => 'ВКонтакте (шапка)',
        'section' => 'header_settings',
        'type' => 'url',
        'settings' => 'header_vk_link',
    ));
}

class Mobile_Walker_Nav_Menu extends Walker_Nav_Menu
{
    // Помечаем элементы, у которых есть дети
    public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
    {
        $id_field = $this->db_fields['id'];
        if (!empty($children_elements[$element->$id_field])) {
            $element->has_children = true;
        }
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    // Открывающий тег <ul> для вложенного списка
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n{$indent}<ul class=\"sub-menu scrollable\" style=\"max-height:0;overflow:hidden;\">\n";
    }

    // Закрывающий тег </ul>
    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "{$indent}</ul>\n";
    }

    // Открывающий тег <li> + <a>
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;

        // добавляем класс и data-state, если есть дети
        $data_state = '';
        if (!empty($item->has_children)) {
            $classes[] = 'menu-item-has-children';
            $data_state = ' data-state="closed"';
        }

        $class_names = implode(' ', array_filter($classes));
        $output .= "{$indent}<li class=\"{$class_names}\"{$data_state}>";

        // формируем атрибуты ссылки
        $atts = array();
        $atts['href'] = !empty($item->url) ? $item->url : '';
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = esc_attr($value);
                $attributes .= " {$attr}=\"{$value}\"";
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $output .= '<a' . $attributes . '>'
            . $args->link_before
            . esc_html($title)
            . $args->link_after
            . '</a>';
    }

    // Закрывающий тег </li>
    public function end_el(&$output, $item, $depth = 0, $args = array())
    {
        $output .= "</li>\n";
    }
}



add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
});


add_action('acf/init', function () {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_product_cat_accent_texts',
            'title' => 'Тексты для товарной категории',
            'fields' => array(
                array(
                    'key' => 'field_product_cat_accent',
                    'label' => 'Текст акцента',
                    'name' => 'product_cat_accent',
                    'type' => 'textarea',
                    'instructions' => 'Этот текст выводится как акцент (первый абзац).',
                    'new_lines' => 'br', // или 'none' если не нужны <br>
                ),
                array(
                    'key' => 'field_product_cat_subaccent',
                    'label' => 'Подакцентный текст',
                    'name' => 'product_cat_subaccent',
                    'type' => 'textarea',
                    'instructions' => 'Этот текст выводится под акцентом (второй абзац).',
                    'new_lines' => 'br',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'taxonomy',
                        'operator' => '==',
                        'value' => 'product_cat',
                    ),
                ),
            ),
        ));
    }
});

add_action('acf/init', function () {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_product_download_file',
            'title' => 'Файл для скачивания',
            'fields' => array(
                array(
                    'key' => 'field_product_download',
                    'label' => 'Скачать файл',
                    'name' => 'product_download_file',
                    'type' => 'file',
                    'instructions' => 'Загрузите любой файл для скачивания (PDF, DOCX и т.д.).',
                    'return_format' => 'url',
                    'library' => 'all',
                    'mime_types' => '',  // можно ограничить, например: 'pdf,doc,docx'
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'product',
                    ),
                ),
            ),
        ));
    }
});



add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_product_additional_functions',
        'title' => 'Дополнительные функции',
        'fields' => array(
            array(
                'key' => 'field_enable_additional_functions',
                'label' => 'Включить блок дополнительных функций',
                'name' => 'enable_additional_functions',
                'type' => 'true_false',
                'ui' => 1,
                'instructions' => 'Отключите, чтобы скрыть весь блок.',
            ),
            array(
                'key' => 'field_additional_functions',
                'label' => 'Дополнительные функции',
                'name' => 'additional_functions',
                'type' => 'repeater',
                'instructions' => 'Добавьте любую функцию: описание, картинка, ссылки и текст оверлея.',
                'collapsed' => 'field_function_description',
                'min' => 0,
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_function_description',
                        'label' => 'Описание функции',
                        'name' => 'description',
                        'type' => 'textarea',
                        'new_lines' => 'br',
                    ),
                    array(
                        'key' => 'field_function_overlay_text',
                        'label' => 'Текст оверлея',
                        'name' => 'overlay_text',
                        'type' => 'text',
                        'instructions' => 'Будет показан при наведении поверх блока',
                        'default_value' => 'Узнать больше',
                    ),
                    array(
                        'key' => 'field_function_image',
                        'label' => 'Изображение функции',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'url',
                        'preview_size' => 'thumbnail',
                    ),
                    array(
                        'key' => 'field_function_link1',
                        'label' => 'Ссылка 1',
                        'name' => 'link1',
                        'type' => 'url',
                    ),
                    array(
                        'key' => 'field_function_link2',
                        'label' => 'Ссылка 2',
                        'name' => 'link2',
                        'type' => 'url',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
    ));
});


add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group(array(
        'key' => 'group_product_recommended_set',
        'title' => 'Рекомендованная комплектация гарнитура',
        'fields' => array(
            array(
                'key' => 'field_recommended_set',
                'label' => 'Комплектация',
                'name' => 'recommended_set',
                'type' => 'group',
                'sub_fields' => array(
                    array(
                        'key' => 'field_set_image',
                        'label' => 'Изображение комплектации',
                        'name' => 'set_image',
                        'type' => 'image',
                        'return_format' => 'url',
                        'preview_size' => 'medium',
                    ),
                    array(
                        'key' => 'field_set_file',
                        'label' => 'Файл для скачивания',
                        'name' => 'set_file',
                        'type' => 'file',
                        'return_format' => 'url',
                        'library' => 'all',
                        'mime_types' => '', // ограничить при необходимости
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                )
            ),
        ),
    ));
});



add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group(array(
        'key' => 'group_product_legs',
        'title' => 'Ножки для товара',
        'fields' => array(
            // Новое поле true/false для вкл/выкл блока
            array(
                'key' => 'field_enable_product_legs',
                'label' => 'Показывать блок «Ножки»',
                'name' => 'enable_product_legs',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 1,
            ),
            // Существующий репитер
            array(
                'key' => 'field_product_legs',
                'label' => 'Ножки',
                'name' => 'product_legs',
                'type' => 'repeater',
                'instructions' => 'Добавьте любое количество ножек: изображение и название.',
                'layout' => 'block',
                'min' => 0,
                'sub_fields' => array(
                    array(
                        'key' => 'field_leg_image',
                        'label' => 'Изображение ножки',
                        'name' => 'leg_image',
                        'type' => 'image',
                        'return_format' => 'url',
                        'preview_size' => 'thumbnail',
                    ),
                    array(
                        'key' => 'field_leg_text',
                        'label' => 'Название или тип ножки',
                        'name' => 'leg_text',
                        'type' => 'text',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                )
            ),
        ),
    ));
});


add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group(array(
        'key' => 'group_product_fabrics',
        'title' => 'Ткани для товара',
        'fields' => array(
            // Переключатель вкл/выкл блока
            array(
                'key' => 'field_enable_product_fabrics',
                'label' => 'Показывать блок «Ткани»',
                'name' => 'enable_product_fabrics',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 1,
            ),
            // Репитер «Ткани»
            array(
                'key' => 'field_product_fabrics',
                'label' => 'Ткани',
                'name' => 'product_fabrics',
                'type' => 'repeater',
                'instructions' => 'Добавьте любое количество тканей: изображение и название.',
                'layout' => 'block',
                'min' => 0,
                'sub_fields' => array(
                    array(
                        'key' => 'field_fabric_image',
                        'label' => 'Изображение ткани',
                        'name' => 'fabric_image',
                        'type' => 'image',
                        'return_format' => 'url',
                        'preview_size' => 'thumbnail',
                    ),
                    array(
                        'key' => 'field_fabric_text',
                        'label' => 'Название или тип ткани',
                        'name' => 'fabric_text',
                        'type' => 'text',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                )
            ),
        ),
    ));
});



add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group(array(
        'key' => 'group_about_main_block',
        'title' => 'About Page — Главный блок',
        'fields' => array(
            array(
                'key' => 'field_about_image',
                'label' => 'Изображение',
                'name' => 'about_image',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_about_title',
                'label' => 'Заголовок (H1)',
                'name' => 'about_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_about_subtitle',
                'label' => 'Подзаголовок (акцент)',
                'name' => 'about_subtitle',
                'type' => 'text',
            ),
            array(
                'key' => 'field_about_accent',
                'label' => 'Краткий акцентный текст',
                'name' => 'about_accent',
                'type' => 'text',
            ),
            array(
                'key' => 'field_about_text',
                'label' => 'Основной текст',
                'name' => 'about_text',
                'type' => 'textarea',
                'new_lines' => 'wpautop',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'about.php',
                ),
            ),
        ),
    ));
});

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group(array(
        'key' => 'group_about_history',
        'title' => 'About Page – История нашей компании',
        'fields' => array(
            array(
                'key' => 'field_history_block_title',
                'label' => 'Заголовок блока',
                'name' => 'history_block_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_history_block_text',
                'label' => 'Текст блока',
                'name' => 'history_block_text',
                'type' => 'textarea',
                'new_lines' => 'wpautop',
            ),
            array(
                'key' => 'field_history_events',
                'label' => 'Этапы истории (год и тексты)',
                'name' => 'history_events',
                'type' => 'repeater',
                'instructions' => 'Добавьте столько лет, сколько нужно: год, текст слева, текст справа.',
                'layout' => 'block',
                'min' => 0,
                'sub_fields' => array(
                    array(
                        'key' => 'field_event_year',
                        'label' => 'Год',
                        'name' => 'event_year',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_event_left',
                        'label' => 'Текст левого блока',
                        'name' => 'event_left',
                        'type' => 'textarea',
                        'new_lines' => 'wpautop',
                    ),
                    array(
                        'key' => 'field_event_right',
                        'label' => 'Текст правого блока',
                        'name' => 'event_right',
                        'type' => 'textarea',
                        'new_lines' => 'wpautop',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'about.php',
                ),
            ),
        ),
    ));
});

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group([
        'key' => 'group_about_features',
        'title' => 'About Page — Возможности',
        'fields' => [
            [
                'key' => 'field_enable_about_features',
                'label' => 'Показывать блок «Возможности»',
                'name' => 'enable_about_features',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 1,
            ],
            [
                'key' => 'field_about_features',
                'label' => 'Список возможностей',
                'name' => 'about_features',
                'type' => 'repeater',
                'instructions' => 'Добавьте любую функцию: изображение и текст.',
                'layout' => 'block',
                'min' => 0,
                'sub_fields' => [
                    [
                        'key' => 'field_about_feature_image',
                        'label' => 'Изображение',
                        'name' => 'feature_image',
                        'type' => 'image',
                        'return_format' => 'url',
                        'preview_size' => 'thumbnail',
                    ],
                    [
                        'key' => 'field_about_feature_text',
                        'label' => 'Текст возможности',
                        'name' => 'feature_text',
                        'type' => 'text',
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'about.php',
                ],
            ],
        ],
    ]);
});



add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group(array(
        'key' => 'group_about_philosophy',
        'title' => 'About Page — Наша философия',
        'fields' => array(
            array(
                'key' => 'field_philosophy_title',
                'label' => 'Заголовок блока',
                'name' => 'philosophy_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_philosophy_image',
                'label' => 'Изображение',
                'name' => 'philosophy_image',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_philosophy_items',
                'label' => 'Элементы философии',
                'name' => 'philosophy_items',
                'type' => 'repeater',
                'instructions' => 'Добавьте любое количество элементов: заголовок и текст.',
                'layout' => 'block',
                'min' => 0,
                'sub_fields' => array(
                    array(
                        'key' => 'field_philosophy_item_heading',
                        'label' => 'Заголовок (H3)',
                        'name' => 'item_heading',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_philosophy_item_text',
                        'label' => 'Текст',
                        'name' => 'item_text',
                        'type' => 'textarea',
                        'new_lines' => 'wpautop',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'about.php',
                ),
            ),
        ),
    ));
});


add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group(array(
        'key' => 'group_about_production',
        'title' => 'About Page — Наше производство',
        'fields' => array(
            array(
                'key' => 'field_about_production_image',
                'label' => 'Изображение',
                'name' => 'about_production_image',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_about_production_title',
                'label' => 'Заголовок блока',
                'name' => 'about_production_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_about_production_text',
                'label' => 'Текст описания',
                'name' => 'about_production_text',
                'type' => 'textarea',
                'new_lines' => 'wpautop',
            ),
            array(
                'key' => 'field_about_production_pluses',
                'label' => 'Плюсы производства',
                'name' => 'about_production_pluses',
                'type' => 'repeater',
                'instructions' => 'Добавьте любое количество плюсов: заголовок и текст.',
                'layout' => 'block',
                'min' => 0,
                'sub_fields' => array(
                    array(
                        'key' => 'field_production_plus_title',
                        'label' => 'Заголовок плюса (H3)',
                        'name' => 'production_plus_title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_production_plus_text',
                        'label' => 'Текст плюса',
                        'name' => 'production_plus_text',
                        'type' => 'textarea',
                        'new_lines' => 'wpautop',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'about.php',
                ),
            ),
        ),
    ));
});


add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group(array(
        'key' => 'group_about_quality',
        'title' => 'About Page — Качество и технологии',
        'fields' => array(
            // Заголовок блока
            array(
                'key' => 'field_quality_title',
                'label' => 'Заголовок блока',
                'name' => 'quality_title',
                'type' => 'text',
            ),
            // Повторитель элементов
            array(
                'key' => 'field_quality_items',
                'label' => 'Элементы',
                'name' => 'quality_items',
                'type' => 'repeater',
                'instructions' => 'Добавьте любое количество элементов: "выделенный текст" и обычный текст.',
                'layout' => 'block',
                'min' => 0,
                'sub_fields' => array(
                    array(
                        'key' => 'field_quality_item_highlight',
                        'label' => 'Выделенный текст (line1)',
                        'name' => 'item_highlight',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_quality_item_text',
                        'label' => 'Обычный текст (line2)',
                        'name' => 'item_text',
                        'type' => 'text',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'about.php',
                ),
            ),
        ),
    ));
});

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group(array(
        'key' => 'group_about_map_block',
        'title' => 'About Page — Карта',
        'fields' => array(
            array(
                'key' => 'field_about_map_title',
                'label' => 'Заголовок блока',
                'name' => 'about_map_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_about_map_text',
                'label' => 'Текст под заголовком',
                'name' => 'about_map_text',
                'type' => 'textarea',
                'new_lines' => 'wpautop',
            ),
            array(
                'key' => 'field_about_map_iframe',
                'label' => 'Код iframe карты',
                'name' => 'about_map_iframe',
                'type' => 'textarea',
                'instructions' => 'Вставьте полный HTML-код `<iframe src="…"></iframe>`.',
                'new_lines' => 'none',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'about.php',
                ),
            ),
        ),
    ));
});


add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group([
        'key' => 'group_contacts_commercial',
        'title' => 'Contacts Page — Коммерческий отдел',
        'fields' => [
            [
                'key' => 'field_commercial_block_title',
                'label' => 'Заголовок блока',
                'name' => 'commercial_block_title',
                'type' => 'text',
            ],
            [
                'key' => 'field_commercial_contacts',
                'label' => 'Сотрудники отдела',
                'name' => 'commercial_contacts',
                'type' => 'repeater',
                'instructions' => 'Добавьте столько сотрудников, сколько нужно.',
                'layout' => 'block',
                'min' => 0,
                'sub_fields' => [
                    [
                        'key' => 'field_contact_image',
                        'label' => 'Фото/иконка сотрудника',
                        'name' => 'contact_image',
                        'type' => 'image',
                        'return_format' => 'url',
                        'preview_size' => 'thumbnail',
                    ],
                    [
                        'key' => 'field_contact_title',
                        'label' => 'Должность / название отдела',
                        'name' => 'contact_title',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_contact_extra_blocks',
                        'label' => 'Доп. блоки с контактами',
                        'name' => 'contact_extra_blocks',
                        'type' => 'repeater',
                        'instructions' => 'В каждом блоке можно задать список e-mail и телефонов.',
                        'layout' => 'block',
                        'min' => 0,
                        'sub_fields' => [
                            [
                                'key' => 'field_extra_emails',
                                'label' => 'E-mail адреса',
                                'name' => 'extra_emails',
                                'type' => 'repeater',
                                'instructions' => 'Добавьте сколько угодно e-mail.',
                                'layout' => 'table',
                                'sub_fields' => [
                                    [
                                        'key' => 'field_email',
                                        'label' => 'E-mail',
                                        'name' => 'email',
                                        'type' => 'email',
                                    ],
                                ],
                            ],
                            [
                                'key' => 'field_extra_phones',
                                'label' => 'Телефоны',
                                'name' => 'extra_phones',
                                'type' => 'repeater',
                                'instructions' => 'Добавьте сколько угодно телефонов.',
                                'layout' => 'table',
                                'sub_fields' => [
                                    [
                                        'key' => 'field_phone',
                                        'label' => 'Телефон',
                                        'name' => 'phone',
                                        'type' => 'text',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'contacts.php',
                ],
            ],
        ],
    ]);
});



add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group([
        'key' => 'group_contacts_legal_info',
        'title' => 'Contacts Page — Юридическая информация',
        'fields' => [
            [
                'key' => 'field_legal_info_title',
                'label' => 'Заголовок блока',
                'name' => 'legal_info_title',
                'type' => 'text',
            ],
            [
                'key' => 'field_legal_info_text',
                'label' => 'Текст (каждый энтер → <br>)',
                'name' => 'legal_info_text',
                'type' => 'textarea',
                'new_lines' => 'br',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'contacts.php',
                ],
            ],
        ],
    ]);
});



add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group([
        'key' => 'group_contacts_map_block',
        'title' => 'Contacts Page — Блок карты',
        'fields' => [
            [
                'key' => 'field_contacts_map_iframe',
                'label' => 'Код iframe карты',
                'name' => 'contacts_map_iframe',
                'type' => 'textarea',
                'instructions' => 'Вставьте полный HTML-код `<iframe …></iframe>`.',
                'new_lines' => 'none',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'contacts.php',
                ],
            ],
        ],
    ]);
});



add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group([
        'key' => 'group_contacts_form',
        'title' => 'Contacts Page — Форма связи',
        'fields' => [
            [
                'key' => 'field_contact_form_bg',
                'label' => 'Фон (изображение)',
                'name' => 'contact_form_bg',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_contact_form_text',
                'label' => 'Текст над формой',
                'name' => 'contact_form_text',
                'type' => 'textarea',
                'new_lines' => 'wpautop',
            ],
            [
                'key' => 'field_contact_form_shortcode',
                'label' => 'Shortcode формы CF7',
                'name' => 'contact_form_shortcode',
                'type' => 'text',
                'instructions' => 'Вставьте шорткод, например: [contact-form-7 id="123" title="Связаться"]',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'contacts.php',
                ],
            ],
        ],
    ]);
});


// Отключаем автогенерацию <p> и <br> вокруг полей CF7
add_filter('wpcf7_autop_or_not', '__return_false', 20);

// Убираем <p> только вокруг одиночных элементов CF7 (input, textarea, select, span–обёртка)
add_filter('wpcf7_form_elements', 'cf7_remove_p_around_fields', 20);
function cf7_remove_p_around_fields($content)
{
    return preg_replace_callback(
        // Ловим любой <p>…</p>
        '/<p>([\s\S]*?)<\/p>/i',
        function ($matches) {
            $inner = trim($matches[1]);
            // Если внутри только span.wpcf7-form-control-wrap…</span> или одиночный input/textarea/select
            if (
                preg_match('/^<span[^>]+class=["\']wpcf7-form-control-wrap[^>]*>.*<\/span>$/is', $inner)
                || preg_match('/^<(?:input|textarea|select)[^>]+>$/i', $inner)
            ) {
                // Вернём содержимое без <p>-обёртки
                return $inner;
            }
            // Во всех остальных случаях оставляем <p> как есть
            return $matches[0];
        },
        $content
    );
}




add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group([
        'key' => 'group_where_to_buy',
        'title' => 'Where to Buy — Страны и города',
        'fields' => [
            [
                'key' => 'field_purchase_countries',
                'label' => 'Страны',
                'name' => 'purchase_countries',
                'type' => 'repeater',
                'instructions' => 'Добавьте столько стран, сколько нужно.',
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'key' => 'field_country_name',
                        'label' => 'Название страны',
                        'name' => 'country_name',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_country_cities',
                        'label' => 'Города',
                        'name' => 'country_cities',
                        'type' => 'repeater',
                        'instructions' => 'Добавьте города для этой страны.',
                        'layout' => 'block',
                        'sub_fields' => [
                            [
                                'key' => 'field_city_name',
                                'label' => 'Город',
                                'name' => 'city_name',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'field_city_contact',
                                'label' => 'Контактная информация (каждый энтер → <br>)',
                                'name' => 'city_contact',
                                'type' => 'textarea',
                                'new_lines' => 'br',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'where-to-buy.php',
                ],
            ],
        ],
    ]);
});


add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    // Если группа уже есть, можно её откорректировать, но для простоты — новая:
    acf_add_local_field_group(array(
        'key' => 'group_where_to_buy_map',
        'title' => 'Where to Buy — Карта',
        'fields' => array(
            array(
                'key' => 'field_purchase_map_iframe',
                'label' => 'Код iframe карты',
                'name' => 'purchase_map_iframe',
                'type' => 'textarea',
                'instructions' => 'Вставьте полный HTML-код <iframe>…</iframe> для карты.',
                'new_lines' => 'none',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'where-to-buy.php',
                ),
            ),
        ),
    ));
});


add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group([
        'key' => 'group_where_to_buy_contact_form',
        'title' => 'Where to Buy — Форма связи',
        'fields' => [
            [
                'key' => 'field_wtb_form_bg',
                'label' => 'Фон формы (изображение)',
                'name' => 'wtb_form_bg',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_wtb_form_text',
                'label' => 'Текст над формой',
                'name' => 'wtb_form_text',
                'type' => 'textarea',
                'new_lines' => 'wpautop',
            ],
            [
                'key' => 'field_wtb_form_shortcode',
                'label' => 'Shortcode формы CF7',
                'name' => 'wtb_form_shortcode',
                'type' => 'text',
                'instructions' => 'Например: [contact-form-7 id="123" title="Связаться"]',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'where-to-buy.php',
                ],
            ],
        ],
    ]);
});


add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group'))
        return;

    acf_add_local_field_group([
        'key' => 'group_category_image',
        'title' => 'Изображение рубрики',
        'fields' => [
            [
                'key' => 'field_category_image',
                'label' => 'Изображение рубрики',
                'name' => 'category_image',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'medium',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'category',
                ],
            ],
        ],
    ]);
});


// 2.2 AJAX-колбэк (и для гостей, и для залогиненных)
add_action('wp_ajax_nopriv_load_more_news', 'load_more_news_callback');
add_action('wp_ajax_load_more_news', 'load_more_news_callback');

function load_more_news_callback()
{
    // проверяем nonce
    check_ajax_referer('load_more_news', 'nonce');

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $per_page = isset($_POST['per_page']) ? intval($_POST['per_page']) : 9;

    $query = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => $per_page,
        'paged' => $paged,
    ]);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <a class="destye-obs-slider-slide" href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('full'); ?>
                <?php else: ?>
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/img/placeholder.png'); ?>" alt="">
                <?php endif; ?>

                <div class="destye-obs-slider-slide-blog-info">
                    <p><?php echo esc_html(get_the_date('j F Y')); ?></p>
                    <p><?php echo esc_html(get_the_title()); ?></p>
                </div>

                <button class="b-link-standart">Подробнее
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 12H21M21 12L17.2642 8.5M21 12L17.2642 15.5" stroke="white" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </a>
        <?php }
        wp_reset_postdata();
    }

    wp_die();
}


add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_where_to_buy2_flags_map',
        'title' => 'Флаги на странице Where to Buy 2',
        'fields' => array(
            array(
                'key' => 'field_where_to_buy2_flags',
                'label' => 'Список стран и ссылок',
                'name' => 'flags_map',
                'type' => 'repeater',
                'instructions' => 'Добавьте любое количество стран: картинка, название и URL',
                'min' => 0,
                'layout' => 'block',
                'button_label' => 'Добавить страну',
                'sub_fields' => array(
                    array(
                        'key' => 'field_where_to_buy2_flag_image',
                        'label' => 'Картинка (флаг)',
                        'name' => 'flag_image',
                        'type' => 'image',
                        'return_format' => 'url',
                        'preview_size' => 'thumbnail',
                    ),
                    array(
                        'key' => 'field_where_to_buy2_flag_link',
                        'label' => 'Ссылка',
                        'name' => 'flag_link',
                        'type' => 'url',
                    ),
                    array(
                        'key' => 'field_where_to_buy2_flag_country',
                        'label' => 'Название страны',
                        'name' => 'flag_country',
                        'type' => 'text',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'where-to-buy2.php',
                ),
            ),
        ),
    ));
});




/**
 * BRX Schema Graph — WebSite, WebPage, Organization/LocalBusiness
 * Вставить целиком в functions.php
 *
 * Поддержка источников:
 * - ACF (опции: см. список внизу)
 * - WooCommerce (адрес магазина, методы оплаты)
 * - Yoast SEO (имя компании, соцсети)
 *
 * Фильтры:
 * - brx_schema_enable               (bool) вкл/выкл вывод графа
 * - brx_schema_graph               (array) финальный граф
 * - brx_schema_org_type            (string) тип организации
 * - brx_schema_org_name            (string) имя организации
 * - brx_schema_contact_points      (array) массив ContactPoint
 * - brx_schema_sameas              (array) массив ссылок sameAs
 * - brx_schema_payment_methods     (array) массив acceptedPaymentMethod
 * - brx_schema_organization        (array) финальный Organization/LocalBusiness
 */

add_action('wp_head', 'brx_schema_print_graph', 20);
function brx_schema_print_graph() {
    if (!apply_filters('brx_schema_enable', true)) return;

    $graph = brx_schema_build_graph();
    if (empty($graph)) return;

    $graph = brx_array_remove_empty($graph);
    if (empty($graph)) return;

    echo "\n" . '<script type="application/ld+json">' . "\n";
    echo wp_json_encode(
        array('@context' => 'https://schema.org', '@graph' => $graph),
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
    );
    echo "\n" . '</script>' . "\n";
}

/** =========================
 *        GRAPH BUILDER
 * ========================= */

function brx_schema_build_graph() {
    $site_url  = home_url('/');
    $site_name = get_bloginfo('name');
    $page_url  = brx_current_url();
    $lang      = get_bloginfo('language');

    $website_id = trailingslashit($site_url) . '#website';
    $webpage_id = trailingslashit($page_url) . '#webpage';
    $org_id     = trailingslashit($site_url) . '#organization';

    // WebSite
    $website = array(
        '@type'       => 'WebSite',
        '@id'         => $website_id,
        'url'         => $site_url,
        'name'        => $site_name,
        'inLanguage'  => $lang,
        'publisher'   => array('@id' => $org_id),
        'potentialAction' => array(
            array(
                '@type'        => 'SearchAction',
                'target'       => esc_url(home_url('/?s={search_term_string}')),
                'query-input'  => 'required name=search_term_string'
            )
        )
    );

    // WebPage (общий; Product/Article и т.п. пусть выводятся отдельными блоками)
    $webpage = array(
        '@type'       => 'WebPage',
        '@id'         => $webpage_id,
        'url'         => $page_url,
        'name'        => brx_schema_page_title(),
        'isPartOf'    => array('@id' => $website_id),
        'inLanguage'  => $lang,
        'primaryImageOfPage' => array('@id' => brx_schema_primary_image_id_for_page($page_url)),
        // По умолчанию мейн-энтити — организация; на товарах/статьях это переопределяют их JSON-LD
        'mainEntity'  => array('@id' => $org_id),
    );

    // Organization / LocalBusiness
    $org = brx_schema_build_organization($org_id);

    $graph = array($website, $webpage, $org);

    return apply_filters('brx_schema_graph', $graph);
}

/** =========================
 *     ORGANIZATION BUILDER
 * ========================= */

function brx_schema_build_organization($org_id) {
    $site_url  = home_url('/');
    $site_name = get_bloginfo('name');
    $tagline   = get_bloginfo('description');

    // Тип можно задать в ACF options (org_schema_type) или фильтром
    $type = apply_filters('brx_schema_org_type', brx_acf_get('org_schema_type', 'option') ?: 'Organization');

    $logo_obj = brx_schema_get_logo_imageobject();
    $address  = brx_schema_get_postal_address();

    // Если есть нормальный адрес, по умолчанию повышаем до LocalBusiness
    if ($address && $type === 'Organization') {
        $type = 'LocalBusiness';
    }

    list($phones, $emails) = brx_schema_get_contacts();
    $contact_points  = brx_schema_get_contact_points($phones, $emails);
    $same_as         = brx_schema_get_sameas();
    $accepted_methods= brx_schema_get_wc_payment_methods();
    $opening_hours   = brx_schema_get_opening_hours();
    $return_policy   = brx_schema_get_return_policy();
    $geo             = brx_schema_get_geo();

    $org = array(
        '@type'        => $type,
        '@id'          => $org_id,
        'url'          => $site_url,
        'name'         => apply_filters('brx_schema_org_name', brx_schema_get_legal_name() ?: $site_name),
        'legalName'    => brx_schema_get_legal_name() ?: null,
        'description'  => $tagline ?: null,
        'logo'         => $logo_obj ?: null,
        'image'        => $logo_obj ?: null,
        'address'      => $address ?: null,
        'geo'          => $geo ?: null,
        'telephone'    => !empty($phones) ? reset($phones) : null,
        'email'        => !empty($emails) ? reset($emails) : null,
        'contactPoint' => !empty($contact_points) ? $contact_points : null,
        'sameAs'       => !empty($same_as) ? array_values(array_unique($same_as)) : null,
        'acceptedPaymentMethod'      => !empty($accepted_methods) ? $accepted_methods : null,
        'openingHoursSpecification'  => $opening_hours ?: null,
        'hasMerchantReturnPolicy'    => $return_policy ?: null,
    );

    return apply_filters('brx_schema_organization', brx_array_remove_empty($org));
}

/** =========================
 *           HELPERS
 * ========================= */

function brx_current_url() {
    $scheme = is_ssl() ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? parse_url(home_url(), PHP_URL_HOST);
    $uri    = $_SERVER['REQUEST_URI'] ?? '/';
    return esc_url("$scheme://$host$uri");
}

function brx_schema_page_title() {
    if (is_front_page())  return get_bloginfo('name');
    if (is_home())        return get_the_title(get_option('page_for_posts')) ?: __('Blog', 'destyle');
    if (is_singular())    return wp_strip_all_tags(get_the_title());
    if (is_archive())     return wp_strip_all_tags(get_the_archive_title());
    if (is_search())      return sprintf(__('Search results for “%s”','destyle'), get_search_query());
    if (is_404())         return __('Page not found','destyle');
    return get_bloginfo('name');
}

function brx_schema_primary_image_id_for_page($page_url) {
    // просто детерминированный @id для привязки primaryImageOfPage
    return trailingslashit($page_url) . '#primaryimage';
}

function brx_array_remove_empty($input) {
    if (!is_array($input)) return $input;
    $out = array();
    foreach ($input as $k => $v) {
        if (is_array($v)) {
            $v = brx_array_remove_empty($v);
            if (!empty($v)) $out[$k] = $v;
        } else {
            if ($v === '' || $v === null || $v === false) continue;
            $out[$k] = $v;
        }
    }
    return $out;
}

/** ===== Data Getters (ACF/Woo/Yoast/Customizer) ===== */

function brx_acf_get($key, $scope = null) {
    return function_exists('get_field') ? get_field($key, $scope) : '';
}

function brx_schema_get_logo_imageobject() {
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $img = wp_get_attachment_image_src($custom_logo_id, 'full');
        if ($img && !empty($img[0])) {
            return array(
                '@type'  => 'ImageObject',
                'url'    => $img[0],
                'width'  => isset($img[1]) ? (int)$img[1] : null,
                'height' => isset($img[2]) ? (int)$img[2] : null,
            );
        }
    }
    if (function_exists('has_site_icon') && has_site_icon()) {
        $icon_url = get_site_icon_url(512);
        if ($icon_url) return array('@type'=>'ImageObject','url'=>$icon_url);
    }
    return null;
}

function brx_schema_get_legal_name() {
    $acf = brx_acf_get('org_legal_name', 'option');
    if ($acf) return wp_strip_all_tags($acf);
    if (class_exists('WPSEO_Options')) {
        $yoast = get_option('wpseo_titles');
        if (!empty($yoast['company_name'])) return (string)$yoast['company_name'];
    }
    return '';
}

function brx_schema_get_postal_address() {
    $street  = (string) brx_acf_get('org_street_address', 'option');
    $local   = (string) brx_acf_get('org_address_locality', 'option');
    $region  = (string) brx_acf_get('org_address_region', 'option');
    $postal  = (string) brx_acf_get('org_postal_code', 'option');
    $country = (string) brx_acf_get('org_address_country', 'option');

    if ($street || $local || $region || $postal || $country) {
        return array(
            '@type'           => 'PostalAddress',
            'streetAddress'   => $street ?: null,
            'addressLocality' => $local ?: null,
            'addressRegion'   => $region ?: null,
            'postalCode'      => $postal ?: null,
            'addressCountry'  => $country ?: null,
        );
    }

    if (class_exists('WooCommerce')) {
        $street  = trim(get_option('woocommerce_store_address'));
        $street2 = trim(get_option('woocommerce_store_address_2'));
        $city    = trim(get_option('woocommerce_store_city'));
        $postcode= trim(get_option('woocommerce_store_postcode'));
        $country_state = get_option('woocommerce_default_country');
        $country = null; $region = null;
        if ($country_state) {
            $parts = explode(':', $country_state);
            $country = $parts[0] ?? null;
            $region  = $parts[1] ?? null;
        }
        $street_full = trim($street . ' ' . $street2);
        if ($street_full || $city || $postcode || $country || $region) {
            return array(
                '@type'           => 'PostalAddress',
                'streetAddress'   => $street_full ?: null,
                'addressLocality' => $city ?: null,
                'addressRegion'   => $region ?: null,
                'postalCode'      => $postcode ?: null,
                'addressCountry'  => $country ?: null,
            );
        }
    }
    return null;
}

function brx_schema_get_geo() {
    $lat = brx_acf_get('org_lat', 'option');
    $lng = brx_acf_get('org_lng', 'option');
    if ($lat !== '' && $lng !== '') {
        return array(
            '@type'     => 'GeoCoordinates',
            'latitude'  => (float)$lat,
            'longitude' => (float)$lng,
        );
    }
    return null;
}

function brx_schema_get_contacts() {
    $phones = array();
    $emails = array();

    $acf_phones = brx_acf_get('org_phones', 'option');
    if (is_array($acf_phones)) {
        foreach ($acf_phones as $row) {
            $p = is_array($row) ? ($row['phone'] ?? '') : $row;
            $p = brx_schema_normalize_phone($p);
            if ($p) $phones[] = $p;
        }
    } else {
        $p = brx_schema_normalize_phone((string) brx_acf_get('org_phone', 'option'));
        if ($p) $phones[] = $p;
    }

    $acf_emails = brx_acf_get('org_emails', 'option');
    if (is_array($acf_emails)) {
        foreach ($acf_emails as $row) {
            $e = is_array($row) ? ($row['email'] ?? '') : $row;
            $e = sanitize_email($e);
            if ($e) $emails[] = $e;
        }
    } else {
        $e = sanitize_email((string) brx_acf_get('org_email', 'option'));
        if ($e) $emails[] = $e;
    }

    if (empty($emails)) {
        $adm = sanitize_email(get_option('admin_email'));
        if ($adm) $emails[] = $adm;
    }

    $phones = array_values(array_unique(array_filter($phones)));
    $emails = array_values(array_unique(array_filter($emails)));

    $phones = apply_filters('brx_schema_org_phones', $phones);
    $emails = apply_filters('brx_schema_org_emails', $emails);

    return array($phones, $emails);
}

function brx_schema_get_contact_points($phones, $emails) {
    $points = array();

    $acf_points = brx_acf_get('org_contact_points', 'option');
    if (is_array($acf_points) && !empty($acf_points)) {
        foreach ($acf_points as $row) {
            $cp = array(
                '@type'             => 'ContactPoint',
                'contactType'       => isset($row['contactType']) ? (string)$row['contactType'] : null,
                'telephone'         => !empty($row['telephone']) ? brx_schema_normalize_phone($row['telephone']) : null,
                'email'             => !empty($row['email']) ? sanitize_email($row['email']) : null,
                'areaServed'        => !empty($row['areaServed']) ? (string)$row['areaServed'] : null,
                'availableLanguage' => !empty($row['availableLanguage']) ? (array)$row['availableLanguage'] : null,
            );
            $cp = brx_array_remove_empty($cp);
            if (!empty($cp)) $points[] = $cp;
        }
    }

    if (empty($points) && (!empty($phones) || !empty($emails))) {
        $points[] = brx_array_remove_empty(array(
            '@type'             => 'ContactPoint',
            'contactType'       => 'customer service',
            'telephone'         => !empty($phones) ? reset($phones) : null,
            'email'             => !empty($emails) ? reset($emails) : null,
            'availableLanguage' => array(get_bloginfo('language')),
        ));
    }

    return apply_filters('brx_schema_contact_points', $points);
}

function brx_schema_get_sameas() {
    $links = array();

    // ACF
    $sameas = brx_acf_get('org_sameas', 'option');
    if (is_array($sameas)) {
        foreach ($sameas as $row) {
            $url = is_array($row) ? ($row['url'] ?? '') : $row;
            $url = esc_url_raw($url);
            if ($url) $links[] = $url;
        }
    }
    $socials = brx_acf_get('org_socials', 'option');
    if (is_array($socials)) {
        foreach ($socials as $row) {
            $url = is_array($row) ? ($row['link'] ?? '') : $row;
            $url = esc_url_raw($url);
            if ($url) $links[] = $url;
        }
    }

    // Customizer
    $keys = array(
        'instagram','instagram_url','insta','insta_url',
        'vk','vk_url','vk_link',
        'facebook','facebook_url','fb','fb_url',
        'ok','ok_url',
        'youtube','youtube_url','yt','yt_url',
        'tiktok','tiktok_url',
        'linkedin','linkedin_url',
        'telegram','telegram_url',
        'x_url','twitter_url','twitter',
    );
    foreach ($keys as $key) {
        $val = get_theme_mod($key);
        if ($val) {
            $url = esc_url_raw($val);
            if ($url) $links[] = $url;
        }
    }

    // Yoast Social
    if (class_exists('WPSEO_Options')) {
        $social = get_option('wpseo_social');
        $yoast_keys = array('facebook_site','instagram_url','twitter_url','linkedin_url','youtube_url','pinterest_url');
        if (is_array($social)) {
            foreach ($yoast_keys as $yk) {
                if (!empty($social[$yk])) {
                    $url = esc_url_raw($social[$yk]);
                    if ($url) $links[] = $url;
                }
            }
        }
    }

    $links = array_values(array_unique(array_filter($links)));
    return apply_filters('brx_schema_sameas', $links);
}

function brx_schema_get_wc_payment_methods() {
    if (!class_exists('WooCommerce') || !function_exists('WC')) return array();

    $methods  = array();
    $gateways = WC()->payment_gateways() ? WC()->payment_gateways->get_available_payment_gateways() : array();
    if (empty($gateways)) return array();

    $map = array(
        'cod'        => 'https://schema.org/Cash',
        'bacs'       => 'https://schema.org/ByBankTransferInAdvance',
        'cheque'     => 'https://schema.org/CheckInAdvance',
        'paypal'     => 'https://schema.org/PayPal',
        'stripe'     => 'https://schema.org/CreditCard',
        'klarna'     => 'https://schema.org/CreditCard',
        'przelewy24' => 'https://schema.org/CreditCard',
        'paysera'    => 'https://schema.org/CreditCard',
        'yookassa'   => 'https://schema.org/CreditCard',
    );

    foreach ($gateways as $id => $gw) {
        $id = strtolower($id);
        if (isset($map[$id])) {
            $methods[] = $map[$id];
        } else {
            $methods[] = isset($gw->method_title) ? sanitize_text_field($gw->method_title) : ucfirst($id);
        }
    }

    $methods = array_values(array_unique(array_filter($methods)));
    return apply_filters('brx_schema_payment_methods', $methods);
}

function brx_schema_get_opening_hours() {
    // ACF repeater org_opening_hours: dayOfWeek[] (Monday..Sunday), opens "HH:MM", closes "HH:MM", validFrom, validThrough
    $rows = brx_acf_get('org_opening_hours', 'option');
    $out = array();
    if (is_array($rows)) {
        foreach ($rows as $r) {
            $spec = array(
                '@type'        => 'OpeningHoursSpecification',
                'dayOfWeek'    => !empty($r['dayOfWeek']) ? array_values((array)$r['dayOfWeek']) : null,
                'opens'        => !empty($r['opens']) ? $r['opens'] : null,
                'closes'       => !empty($r['closes']) ? $r['closes'] : null,
                'validFrom'    => !empty($r['validFrom']) ? $r['validFrom'] : null,
                'validThrough' => !empty($r['validThrough']) ? $r['validThrough'] : null,
            );
            $spec = brx_array_remove_empty($spec);
            if (!empty($spec)) $out[] = $spec;
        }
    }
    return !empty($out) ? $out : null;
}

function brx_schema_get_return_policy() {
    $url = brx_acf_get('org_return_policy_url', 'option');
    if ($url) {
        return array('@type'=>'MerchantReturnPolicy','url'=>esc_url_raw($url));
    }
    // Поиск типовых страниц «возврат»
    $candidates = array('return', 'refund', 'vozvrat', 'vozvrat-tovara', 'policy-returns');
    foreach ($candidates as $slug) {
        $page = get_page_by_path($slug);
        if ($page && !is_wp_error($page)) {
            return array('@type'=>'MerchantReturnPolicy', 'url'=>get_permalink($page->ID));
        }
    }
    return null;
}

function brx_schema_normalize_phone($phone) {
    $phone = trim((string)$phone);
    if ($phone === '') return '';
    return preg_replace('/[^\d\+]/', '', $phone);
}


