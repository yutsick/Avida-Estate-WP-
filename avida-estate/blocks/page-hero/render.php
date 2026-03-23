<?php
/**
 * Page Hero Block — compact banner for inner pages.
 *
 * @package AvidaEstate
 */

$image  = get_field('page_hero_image');
$title    = get_field('page_hero_title') ?: get_the_title();
$subtitle = get_field('page_hero_subtitle');
$anchor   = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';

$bg_url = '';
if ($image && isset($image['url'])) {
    $bg_url = esc_url($image['sizes']['2048x2048'] ?? $image['url']);
}
?>

<section<?php echo $anchor; ?> class="relative !flex items-center justify-center overflow-hidden" style="height: 420px;">
    <?php if ($bg_url) : ?>
        <img
            src="<?php echo $bg_url; ?>"
            alt="<?php echo esc_attr($image['alt'] ?? $title); ?>"
            class="absolute inset-0 w-full h-full object-cover"
            loading="eager"
        />
    <?php endif; ?>

    <div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent "></div>

    <div class="relative z-10 max-w-[1400px] w-full mx-auto px-6">
        <?php if ($title) : ?>
            <h1 class="mt-[100px] font-['Noto_Serif_Display'] text-white  text-[32px] md:text-[48px] tracking-wide !font-medium">
                <?php echo esc_html($title); ?>
            </h1>
        <?php endif; ?>
        <?php if ($subtitle) : ?>
            <p class="text-white/70 mt-3 text-sm md:text-base tracking-wide font-helvetica">
                <?php echo esc_html($subtitle); ?>
            </p>
        <?php endif; ?>
    </div>
</section>
