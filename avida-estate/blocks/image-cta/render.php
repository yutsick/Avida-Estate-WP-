<?php
/**
 * Image CTA Block Template
 *
 * @package AvidaEstate
 */

$heading     = get_field('image_cta_heading');
$subtitle    = get_field('image_cta_subtitle');
$image_id    = get_field('image_cta_image');
$button_text = get_field('image_cta_button_text') ?: 'Call Us';
$form_id     = get_field('image_cta_form_id');

$anchor   = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';
$modal_id = 'cta-modal-' . uniqid();
$image    = $image_id ? wp_get_attachment_image_src($image_id, 'full') : null;

if (!$heading && !$image) {
    return;
}
?>

<section<?php echo $anchor; ?> class="bg-[#E9EDE9] ">
    <div class="overflow-hidden w-full max-w-[1400px] mx-auto px-6 pb-30">
        <div class="relative w-full h-auto">

        
            <?php if ($image) : ?>
                <img
                    src="<?php echo esc_url($image[0]); ?>"
                    alt="<?php echo esc_attr($heading); ?>"
                    class="absolute inset-0 w-full h-full object-cover"
                    loading="lazy"
                />
                <div class="absolute inset-0 bg-black/40"></div>
            <?php else : ?>
                <div class="absolute inset-0 bg-[#092B23]"></div>
            <?php endif; ?>
        
            <div class="relative py-20 md:py-28 px-6 md:px-12 lg:px-20">
                <?php if ($heading) : ?>
                    <h2 class="font-['Noto_Serif_Display'] text-white !text-xl md:!text-3xl !font-medium uppercase max-w-2xl">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($subtitle) : ?>
                    <p class="text-white/60 mt-4 text-sm md:text-base tracking-wide max-w-xl">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <a href="tel:+34952766950" class="flex items-center justify-between w-fit border border-white/20 px-6 py-4 mb-4 text-white text-sm uppercase tracking-widest hover:bg-white/5 transition-colors">
                    <span>Call Us</span>
   
                </a>
            </div>
        </div>
    </div>    
</section>



