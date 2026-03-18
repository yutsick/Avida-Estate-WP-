<?php
/**
 * Statistic Block Template
 *
 * @package AvidaEstate
 */

$items  = get_field('statistic_items');
$anchor = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';

if (empty($items)) {
    return;
}
?>

<section<?php echo $anchor; ?> class="bg-[#092B23] py-16 md:py-24">
    <div class="max-w-[1400px] mx-auto px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 md:gap-6 text-center">
            <?php foreach ($items as $item) : ?>
                <div>
                    <?php if (!empty($item['value'])) : ?>
                        <p class="font-['Noto_Serif_Display'] text-white !text-5xl md:!text-6xl !font-light">
                            <?php echo esc_html($item['value']); ?>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($item['label'])) : ?>
                        <p class="text-white/40 mt-3 text-sm md:text-base tracking-wide">
                            <?php echo esc_html($item['label']); ?>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
