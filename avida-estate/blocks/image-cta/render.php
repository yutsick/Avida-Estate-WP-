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

<section<?php echo $anchor; ?> class=" overflow-hidden w-full max-w-[1400px] mx-auto px-6">
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

        <button
            type="button"
            data-modal-open="<?php echo esc_attr($modal_id); ?>"
            class="mt-8 inline-block border border-white/40 text-white text-xs md:text-sm tracking-[0.15em] uppercase px-8 py-3 hover:bg-white hover:text-[#092B23] transition-colors"
        >
            <?php echo esc_html($button_text); ?>
        </button>
    </div>
    </div>
</section>

<!-- Modal -->
<div id="<?php echo esc_attr($modal_id); ?>" class="fixed inset-0 z-50 hidden items-center justify-center" data-modal>
    <div class="absolute inset-0 bg-black/60" data-modal-backdrop></div>
    <div class="relative bg-white rounded-sm w-full max-w-xl mx-4 p-6 md:p-10 max-h-[90vh] overflow-y-auto">
        <button type="button" data-modal-close class="absolute top-4 right-4 text-[#092B23]/60 hover:text-[#092B23] transition-colors" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <?php if ($form_id) : ?>
            <div class="mt-4">
                <?php echo do_shortcode($form_id); ?>
            </div>
        <?php else : ?>
            <p class="text-[#092B23]/60 text-sm">No form configured.</p>
        <?php endif; ?>
    </div>
</div>

<script>
(function() {
    var openBtn = document.querySelector('[data-modal-open="<?php echo esc_js($modal_id); ?>"]');
    var modal = document.getElementById('<?php echo esc_js($modal_id); ?>');
    if (!openBtn || !modal) return;

    function open() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function close() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    openBtn.addEventListener('click', open);
    modal.querySelector('[data-modal-backdrop]').addEventListener('click', close);
    modal.querySelector('[data-modal-close]').addEventListener('click', close);
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) close();
    });
})();
</script>
