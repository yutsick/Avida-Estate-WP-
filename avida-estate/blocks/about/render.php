<?php
/**
 * About Block Template
 *
 * @package AvidaEstate
 */

$text   = get_field('about_text');
$cta    = get_field('about_cta');
$anchor = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';
?>

<section<?php echo $anchor; ?> class="bg-[#E9EDE9] pb-16">
    <div class="mx-auto max-w-[1400px]  p-5 lg:p-10  flex flex-col lg:flex-row lg:justify-between lg:items-end gap-10 lg:gap-20">

        <div class=" max-w-[840px] lg:flex-1 text-[#1a1a1a] font-light text-base md:text-lg leading-relaxed" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; text-align: justify;">
            <?php if ($text) : ?>
                <?php echo $text; ?>
            <?php else : ?>
                <p>Add your company description here.</p>
            <?php endif; ?>
        </div>

        <?php if ($cta) : ?>
            <div class="lg:flex-shrink-0">
                <a
                    href="<?php echo esc_url($cta['url']); ?>"
                    <?php echo !empty($cta['target']) ? 'target="' . esc_attr($cta['target']) . '"' : ''; ?>
                    class="border-1 rounded-[10px] px-10.5 py-3 border-[#092B23] gap-3 text-base !font-[300]  uppercase font-helvetica !text-[#092B23]  transition-colors hover:!no-underline"
                >
                    <?php echo esc_html($cta['title']); ?>
                    
                </a>
            </div>
        <?php endif; ?>

    </div>
</section>
