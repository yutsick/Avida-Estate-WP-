<?php
/**
 * Intro Block Template
 *
 * @package AvidaEstate
 */

$heading     = get_field('intro_heading');
$description = get_field('intro_description');
$theme       = get_field('intro_theme');

$anchor = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';
?>

<section<?php echo $anchor; ?> class="  <?= ($theme == 'dark') ? 'bg-[#002C23]' : 'bg-[#E9EDE9]' ;?>  py-20 md:pt-40 md:pb-30">
    <div class="max-w-[1400px] mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-20">
            <?php if ($heading) : ?>
                <h2 class="font-helvetica <?= ($theme == 'dark') ? 'text-white' : 'text-[#002C23]' ;?> text-[28px] md:text-[32px] !font-normal uppercase leading-snug">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php endif; ?>

            <?php if ($description) : ?>
                <p class=" <?= ($theme == 'dark') ? 'text-white' : 'text-[#002C23]' ;?> text-base md:!text-[18px] !font-light leading-relaxed   font-helvetica">
                    <?php echo esc_html($description); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>
