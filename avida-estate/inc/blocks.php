<?php
/**
 * Register Gutenberg blocks and their SCF fields.
 *
 * @package AvidaEstate
 */

add_filter('block_categories_all', function ($categories) {
    array_unshift($categories, [
        'slug'  => 'avidaestate',
        'title' => 'Avida Estate',
        'icon'  => 'building',
    ]);
    return $categories;
});

/**
 * Enable REST API for CPTs registered by the plugin so SCF
 * relationship / taxonomy fields can query them in the editor.
 */
add_filter('register_post_type_args', function ($args, $post_type) {
    if (in_array($post_type, ['property', 'testimonial'], true)) {
        $args['show_in_rest'] = true;
    }
    return $args;
}, 20, 2);

add_filter('register_taxonomy_args', function ($args, $taxonomy) {
    if (in_array($taxonomy, ['property_type', 'property_status'], true)) {
        $args['show_in_rest'] = true;
    }
    return $args;
}, 20, 2);

add_action('init', function () {
    if (!function_exists('register_block_type')) {
        return;
    }

    $blocks = [
        'hero',
        'intro',
        'logo-ticker',
        'team',
        'featured-property',
        'property-slider',
        'testimonials',
        'about',
        'statistic',
        'image-cta',
    ];

    foreach ($blocks as $block) {
        register_block_type(get_template_directory() . '/blocks/' . $block);
    }
});

add_action('enqueue_block_editor_assets', function () {
    wp_enqueue_style(
        'avidaestate-editor',
        get_template_directory_uri() . '/css/override.css',
        [],
        filemtime(get_template_directory() . '/css/override.css')
    );
});

add_action('acf/init', function () {
    $fields = [
        'hero',
        'intro',
        'logo-ticker',
        'team',
        'featured-property',
        'property-slider',
        'testimonials',
        'about',
        'statistic',
        'image-cta',
    ];

    foreach ($fields as $block) {
        require_once get_template_directory() . '/blocks/' . $block . '/fields.php';
    }
});
