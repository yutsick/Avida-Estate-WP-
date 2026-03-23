<?php
/**
 * Image + Text Block Template
 *
 * @package AvidaEstate
 */

$heading  = get_field('image_text_heading');
$content  = get_field('image_text_content');
$image_id = get_field('image_text_image');
$layout   = get_field('image_text_layout') ?: 'right';
$spacing  = get_field('image_text_spacing') ?: 'both';

$anchor = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';
$image  = $image_id ? wp_get_attachment_image_src($image_id, 'full') : null;

if (!$heading && !$content && !$image) {
    return;
}

$spacing_classes = match ($spacing) {
    'top'    => 'pt-16 md:pt-24',
    'bottom' => 'pb-16 md:pb-24',
    'none'   => '',
    default  => 'py-16 md:py-24',
};

// Image left = default row (image first, text second)
// Image right = reverse row on desktop (text first, image second)
$flex_direction = ($layout === 'left') ? 'md:flex-row' : 'md:flex-row-reverse';
?>

<section<?php echo $anchor; ?> class="bg-[#E9EDE9] <?php echo $spacing_classes; ?>">
    <div class="max-w-[1400px] mx-auto px-6">
        <div class="flex flex-col <?php echo $flex_direction; ?> gap-10 md:gap-16">

            <!-- Image (always first on mobile via DOM order) -->
            <div class="w-full md:w-3/5">
                <?php if ($image) : ?>
                    <img
                        src="<?php echo esc_url($image[0]); ?>"
                        alt="<?php echo esc_attr($heading); ?>"
                        class="w-full h-auto rounded-sm object-cover"
                        loading="lazy"
                    />
                <?php else : ?>
                    <div class="w-full aspect-[4/3] bg-gray-200 rounded-sm flex items-center justify-center">
                        <span class="text-gray-400 text-sm">No image</span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Text -->
            <div class="w-full md:w-2/5">
                <?php if ($heading) : ?>
                    <h2 style="font-family: 'Noto Serif Display', serif; color: #092B23; font-size: 40px; font-weight: 500; text-transform: uppercase; margin-bottom: 60px;">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($content) : ?>
                    <div class="text-[#092B23] text-sm md:text-base leading-relaxed tracking-wide" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                        <?php echo wp_kses_post($content); ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
