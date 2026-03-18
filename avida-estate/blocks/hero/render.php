<?php
/**
 * Hero Block Template
 *
 * @package AvidaEstate
 */

$image     = get_field('hero_image');
$tagline   = get_field('hero_tagline');
$button_1  = get_field('hero_button_1');
$button_2  = get_field('hero_button_2');

$bg_url = '';
if ($image && isset($image['url'])) {
    $bg_url = esc_url($image['sizes']['2048x2048'] ?? $image['url']);
}

$anchor = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';
?>

<section<?php echo $anchor; ?> class="relative min-h-screen flex items-end overflow-hidden">
    <?php if ($bg_url) : ?>
        <img
            src="<?php echo $bg_url; ?>"
            alt="<?php echo esc_attr($image['alt'] ?? ''); ?>"
            class="absolute inset-0 w-full h-full object-cover"
        />
    <?php endif; ?>

    <div class="absolute inset-0 bg-[#000000]/10">

    <div class="relative z-10 w-full flex justify-end items-center h-full flex-col max-w-[1400px] mx-auto px-6 pb-16 md:pb-20">
        <?php if ($tagline) : ?>
            <h1 class="text-white !font-light text-center !text-[20px] md:!text-[22px] !regular max-w-xl mb-8 font-helvetica">
                <?php echo esc_html($tagline); ?>
            </h1>
        <?php endif; ?>

        <div class="flex flex-wrap gap-6 mt-10">
            <?php if ($button_1) : ?>
                <a
                    href="<?php echo esc_url($button_1['url']); ?>"
                    target="<?php echo esc_attr($button_1['target'] ?: '_self'); ?>"
                    class="group inline-flex items-center  border border-[#E9EDE9] !text-[#E9EDE9] rounded-full px-9 py-1.5 text-[18px]  tracking-wide hover:bg-gray-100 hover:!no-underline transition-colors uppercase"
                >
                    <?php echo esc_html($button_1['title']); ?>
                  
          
                </a>
            <?php endif; ?>

            <?php if ($button_2) : ?>
                <a
                    href="<?php echo esc_url($button_2['url']); ?>"
                    target="<?php echo esc_attr($button_2['target'] ?: '_self'); ?>"
                    class="group inline-flex items-center border border-[#E9EDE9] !text-[#E9EDE9] rounded-full px-9 py-1.5 text-[18px]  tracking-wide hover:bg-white/10 hover:!no-underline transition-colors uppercase"
                >
                    <?php echo esc_html($button_2['title']); ?>
                    
                </a>
            <?php endif; ?>
        </div>
    </div>
    </div>
</section>
