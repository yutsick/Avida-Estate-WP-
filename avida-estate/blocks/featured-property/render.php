<?php
/**
 * Featured Property Block Template
 *
 * @package AvidaEstate
 */

$image       = get_field('fp_image');
$price       = get_field('fp_price');
$title       = get_field('fp_title');
$description = get_field('fp_description');
$link        = get_field('fp_link');

$bg_url = '';
if ($image && isset($image['url'])) {
    $bg_url = esc_url($image['sizes']['2048x2048'] ?? $image['url']);
}

$anchor = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';

$tag       = $link ? 'a' : 'section';
$link_attr = $link ? ' href="' . esc_url($link['url']) . '" target="' . esc_attr($link['target'] ?: '_self') . '"' : '';
?>

<<?php echo $tag; ?><?php echo $anchor; ?><?php echo $link_attr; ?> class="relative block min-h-[80vh] !flex items-end justify-center overflow-hidden group">
    <?php if ($bg_url) : ?>
        <img
            src="<?php echo $bg_url; ?>"
            alt="<?php echo esc_attr($image['alt'] ?? $title ?? ''); ?>"
            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
            loading="lazy"
        />
    <?php endif; ?>

    <div class="absolute inset-x-0 bottom-0 h-full bg-gradient-to-t from-black/80 to-transparent left-0 top-0">  </div>

    <div class="absolute  flex flex-col justify-end z-10 w-full h-full max-w-[1400px] mx-auto px-6 pb-12 md:pb-20 ">
        <?php if ($price) : ?>
            <p class="font-['Noto_Serif_Display']  text-white text-4xl md:text-6xl font-light mb-4">
                <?php echo esc_html($price); ?>
            </p>
        <?php endif; ?>

        <?php if ($title) : ?>
            <h2 class="text-white !text-[18px] tracking-[0.08em] md:!text-[24px] font-medium uppercase tracking-wider max-w-[1060px] mb-4 leading-relaxed font-helvetica !font-light">
                <?php echo esc_html($title); ?>
            </h2>
        <?php endif; ?>

        <?php if ($description) : ?>
            <p class="text-white/80 tracking-[0.08em]  md:text-[18px] max-w-[1060px] leading-relaxed font-helvetica !font-light" >
                <?php echo esc_html($description); ?>
            </p>
        <?php endif; ?>
      
    </div>
</<?php echo $tag; ?>>
