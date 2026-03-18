<?php
/**
 * Universal Slider Block — Render dispatcher
 * Supports properties and posts. Prepares data, then includes mode partial.
 *
 * Modes: slider | gallery | paginated
 *
 * @package AvidaEstate
 */

$heading      = get_field('ps_heading');
$heading_link = get_field('ps_heading_link');
$post_type    = get_field('ps_post_type') ?: 'property';
$item_ids     = get_field('ps_items');
$count        = get_field('ps_count') ?: 8;
$category     = get_field('ps_category');
$mode         = get_field('ps_mode') ?: 'slider';
$style        = get_field('ps_style') ?: 'color';
$bg_color     = get_field('ps_bg_color') ?: '#ffffff';

$anchor = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';

// If no manual selection — auto-fetch latest
if (!$item_ids || !is_array($item_ids) || empty($item_ids)) {
    $query_args = [
        'post_type'      => $post_type,
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'fields'         => 'ids',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
    if ($post_type === 'post' && $category) {
        $query_args['cat'] = $category;
    }
    $q = new WP_Query($query_args);
    $item_ids = $q->posts;
    wp_reset_postdata();
}

if (empty($item_ids)) {
    return;
}

$uid       = 'ps-' . uniqid();
$grayscale = $style === 'grayscale' ? ' grayscale group-hover:grayscale-[0]' : '';

// Build universal item data array
$properties = [];
foreach ($item_ids as $item_id) {
    $item_post_type = get_post_type($item_id);
    $title     = get_the_title($item_id);
    $permalink = get_permalink($item_id);
    $excerpt   = wp_trim_words(get_the_excerpt($item_id) ?: get_post_field('post_content', $item_id), 40, '…');

    $price    = '';
    $city     = '';
    $img_url  = '';
    $img_large = '';

    if ($item_post_type === 'property') {
        // Property-specific data
        $price_raw = get_post_meta($item_id, 'property_price', true);
        $price     = $price_raw ? '€' . number_format((float) $price_raw, 0, ',', ',') : '';
        $city      = get_post_meta($item_id, 'locality', true);

        $gallery_str = get_post_meta($item_id, 'property_gallery', true);
        if ($gallery_str) {
            $gallery_ids = explode(',', $gallery_str);
            $first_id    = intval(trim($gallery_ids[0]));
            if ($first_id) {
                $src = wp_get_attachment_image_src($first_id, 'pxp-gallery');
                if ($src) $img_url = $src[0];
                $src_large = wp_get_attachment_image_src($first_id, 'full');
                if ($src_large) $img_large = $src_large[0];
            }
        }
    }

    // Fallback to featured image (works for both posts and properties)
    if (!$img_url) {
        $img_url   = get_the_post_thumbnail_url($item_id, 'large') ?: '';
        $img_large = get_the_post_thumbnail_url($item_id, 'full') ?: $img_url;
    }
    if (!$img_large) $img_large = $img_url;

    $properties[] = compact('item_id', 'title', 'permalink', 'price', 'city', 'excerpt', 'img_url', 'img_large');
}

// Resolve partial file
$partial = __DIR__ . '/mode-' . $mode . '.php';
if (!file_exists($partial)) {
    $partial = __DIR__ . '/mode-slider.php';
}
?>

<section<?php echo $anchor; ?> class="py-16 md:py-24" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="max-w-[1400px] mx-auto px-6">
        <?php include $partial; ?>
    </div>
</section>
