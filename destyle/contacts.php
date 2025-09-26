<?php
/**
 * Template Name: Contacts Page
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


        <?php
        $title = get_field('commercial_block_title');
        $contacts = get_field('commercial_contacts');

        if ($title || $contacts): ?>
            <div class="cont-element-pravitel">
                <?php if ($title): ?>
                    <h2><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($contacts): ?>
                    <div class="cont-element-pravitel-sod">
                        <?php foreach ($contacts as $contact):
                            $img = $contact['contact_image'];
                            $role = $contact['contact_title'];
                            $blocks = $contact['contact_extra_blocks'];
                            ?>
                            <div class="cont-element-pravitel-sod-element">
                                <div class="cont-element-pravitel-sod-element-left"
                                    style="<?php echo $img ? 'background-image:url(' . esc_url($img) . ')' : ''; ?>">
                                </div>
                                <div class="cont-element-pravitel-sod-element-right">
                                    <?php if ($role): ?>
                                        <p class="cont-element-pravitel-sod-element-right-title">
                                            <?php echo esc_html($role); ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if ($blocks): ?>
                                        <?php foreach ($blocks as $blk):
                                            $emails = $blk['extra_emails'];
                                            $phones = $blk['extra_phones'];
                                            ?>
                                            <div class="cont-element-pravitel-sod-element-right-dop-sod">
                                                <?php if ($emails): ?>
                                                    <?php foreach ($emails as $e): ?>
                                                        <p class="cont-element-pravitel-sod-element-right-dop-sod-p1">
                                                            <?php echo esc_html($e['email']); ?>
                                                        </p>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>

                                                <?php if ($phones): ?>
                                                    <?php foreach ($phones as $p): ?>
                                                        <p class="cont-element-pravitel-sod-element-right-dop-sod-p2">
                                                            <?php echo esc_html($p['phone']); ?>
                                                        </p>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>


        <?php
        $title = get_field('legal_info_title');
        $text = get_field('legal_info_text');

        if ($title || $text): ?>
            <div class="contact-yr-info-sect">
                <?php if ($title): ?>
                    <h3><?php echo esc_html($title); ?></h3>
                <?php endif; ?>

                <?php if ($text): ?>
                    <p><?php echo wp_kses_post($text); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>


    </div>

    <?php
    $iframe = get_field('contacts_map_iframe');
    if ($iframe): ?>
        <div class="container-destyle map-element">
            <?php
            // Выводим чистый HTML-код iframe
            echo $iframe;
            ?>
        </div>
    <?php endif; ?>

    <?php
    // получаем ACF-поля
    $bg = get_field('contact_form_bg');
    $txt = get_field('contact_form_text');
    $sc = get_field('contact_form_shortcode');
    ?>

    <?php if ($sc): ?>
        <div class="contact-block-pole" style="background-image: url(<?php echo esc_url($bg); ?>);">
            <div class="container-destyle">
                <div class="contact-block-pole-element">
                    <?php if ($txt): ?>
                        <div class="contact-block-pole-element-left">
                            <?php echo wp_kses_post($txt); ?>
                        </div>
                    <?php endif; ?>

                    <div class="contact-block-pole-element-right">
                        <div class="contact-block-pole-element-right-form">
                            <?php echo do_shortcode($sc); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


</main>



<?php get_footer(); ?>