<?php
/**
 * Property Slider — Mode: Simple Slider
 * Horizontal scroll, cards link to property page.
 *
 * Expects: $properties, $uid, $grayscale, $heading, $heading_link
 */
?>

<!-- Heading -->
<div class="flex items-center justify-between mb-10">
    <?php if ($heading) : ?>
        <h2 class="font-['Noto_Serif_Display'] text-[#092B23] text-2xl md:text-[32px] font-light uppercase">
            <?php echo esc_html($heading); ?>
        </h2>
    <?php endif; ?>

    <div class="flex items-center gap-3">
        <?php if (count($properties) > 4) : ?>
            <button data-prev="<?php echo esc_attr($uid); ?>" class="flex items-center justify-center w-10 h-10 rounded-full border border-[#092B23]/20 text-[#092B23] hover:bg-[#092B23] hover:text-white transition-colors" aria-label="Previous">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>
        <?php endif; ?>

        <?php if ($heading_link) : ?>
            <a href="<?php echo esc_url($heading_link['url']); ?>" target="<?php echo esc_attr($heading_link['target'] ?: '_self'); ?>" class="flex items-center justify-center w-10 h-10 rounded-full border border-[#092B23]/20 text-[#092B23] hover:bg-[#092B23] hover:text-white transition-colors" aria-label="<?php echo esc_attr($heading_link['title'] ?: 'View all'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        <?php endif; ?>

        <?php if (count($properties) > 4) : ?>
            <button data-next="<?php echo esc_attr($uid); ?>" class="flex items-center justify-center w-10 h-10 rounded-full border border-[#092B23]/20 text-[#092B23] hover:bg-[#092B23] hover:text-white transition-colors" aria-label="Next">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
        <?php endif; ?>
    </div>
</div>

<!-- Cards -->
<div id="<?php echo esc_attr($uid); ?>" class="flex gap-5 overflow-x-hidden snap-x snap-mandatory scrollbar-hide  pb-2">
    <?php foreach ($properties as $prop) : ?>
        <a href="<?php echo esc_url($prop['permalink']); ?>" class="group flex-none w-[280px] md:w-[calc(25%-15px)] snap-start">
            <div class="relative aspect-[4/3] overflow-hidden rounded-sm bg-gray-100">
                <?php if ($prop['img_url']) : ?>
                    <img src="<?php echo esc_url($prop['img_url']); ?>" alt="<?php echo esc_attr($prop['title']); ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 group-hover:grayscale-0 transition-transform duration-500<?php echo $grayscale; ?>" loading="lazy" />
                <?php endif; ?>
                <div class="absolute  h-full items-end inset-x-0 bottom-0 bg-gradient-to-t from-[#101010]/90 to-transparent p-4 pt-12">
     
                </div>
   
            </div>
            <div class="flex flex-col text-[#092B23] font-helvetica mt-1">
                <?php if ($prop['title']) : ?>
                    <h3 class="md:!text-[22px]  text-base font-helvetica uppercase tracking-wide"><?php echo esc_html($prop['title']); ?></h3>
                <?php endif; ?>
                <?php if ($prop['price']) : ?>
                    <p class="  tracking-[0.08em]"><?php echo esc_html($prop['price']); ?></p>
                <?php endif; ?>
            </div>
        </a>
    <?php endforeach; ?>
</div>



<script>
(function() {
    var track = document.getElementById('<?php echo esc_js($uid); ?>');
    if (!track) return;
    var cardW = function() { return track.firstElementChild.offsetWidth + 20; };

    var prev = document.querySelector('[data-prev="<?php echo esc_js($uid); ?>"]');
    var next = document.querySelector('[data-next="<?php echo esc_js($uid); ?>"]');
    if (prev) prev.addEventListener('click', function() { track.scrollBy({ left: -cardW(), behavior: 'smooth' }); });
    if (next) next.addEventListener('click', function() { track.scrollBy({ left: cardW(), behavior: 'smooth' }); });

    var dots = document.querySelectorAll('[data-ps-dots="<?php echo esc_js($uid); ?>"] [data-dot]');
    if (dots.length) {
        dots.forEach(function(dot) {
            dot.addEventListener('click', function() {
                track.scrollTo({ left: parseInt(this.dataset.dot) * cardW() * 4, behavior: 'smooth' });
            });
        });
        track.addEventListener('scroll', function() {
            var active = Math.round(track.scrollLeft / (cardW() * 4));
            dots.forEach(function(d, i) {
                d.className = d.className.replace(/bg-\[#092B23\](\/25)?/g, '');
                d.classList.add(i === active ? 'bg-[#092B23]' : 'bg-[#092B23]/25');
            });
        });
    }
})();
</script>
