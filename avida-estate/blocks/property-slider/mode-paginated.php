<?php
/**
 * Property Slider — Mode: Paginated
 * Auto-groups properties by 5: first 4 = small cards in a row, 5th = large featured.
 * Smooth horizontal scroll between pages (scroll-snap).
 * On mobile: simple horizontal scroll, all cards same size.
 *
 * Expects: $properties, $uid, $grayscale, $heading, $heading_link
 */

$pages = array_chunk($properties, 5);
$total_pages = count($pages);
?>

<!-- Heading -->
<div class="flex items-center justify-between mb-10">
    <?php if ($heading) : ?>
        <h2 class="font-['Noto_Serif_Display'] text-[#092B23] text-2xl md:text-[32px] font-light uppercase">
            <?php echo esc_html($heading); ?>
        </h2>
    <?php endif; ?>

    <?php if ($total_pages > 1 || $heading_link) : ?>
        <div class="flex items-center gap-3">
            <?php if ($total_pages > 1) : ?>
                <button data-pg-prev="<?php echo esc_attr($uid); ?>" class="flex items-center justify-center w-10 h-10 rounded-full border border-[#092B23]/20 text-[#092B23] hover:bg-[#092B23] hover:text-white transition-colors" aria-label="Previous">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
            <?php endif; ?>

            <?php if ($heading_link) : ?>
                <a href="<?php echo esc_url($heading_link['url']); ?>" target="<?php echo esc_attr($heading_link['target'] ?: '_self'); ?>" class="flex items-center justify-center w-10 h-10 rounded-full border border-[#092B23]/20 text-[#092B23] hover:bg-[#092B23] hover:text-white transition-colors" aria-label="<?php echo esc_attr($heading_link['title'] ?: 'View all'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            <?php endif; ?>

            <?php if ($total_pages > 1) : ?>
                <button data-pg-next="<?php echo esc_attr($uid); ?>" class="flex items-center justify-center w-10 h-10 rounded-full border border-[#092B23]/20 text-[#092B23] hover:bg-[#092B23] hover:text-white transition-colors" aria-label="Next">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Desktop: horizontal scroll pages (hidden on mobile) -->
<div id="<?php echo esc_attr($uid); ?>-track" class="hidden md:flex overflow-hidden snap-x snap-mandatory scrollbar-hide" style="scroll-behavior: smooth;">
    <?php foreach ($pages as $page_idx => $page_items) :
        $featured = $page_items[count($page_items) - 1];
        $has_thumbs = count($page_items) > 1;
        $thumbs = $has_thumbs ? array_slice($page_items, 0, count($page_items) - 1) : [];
    ?>
        <div class="w-full flex-none" data-pg-page="<?php echo $page_idx; ?>">

            <?php if ($has_thumbs) : ?>
                <div class="grid gap-5 mb-5" style="grid-template-columns: repeat(<?php echo count($thumbs); ?>, minmax(0, 1fr))">
                    <?php foreach ($thumbs as $prop) : ?>
                        <a href="<?php echo esc_url($prop['permalink']); ?>" class="group">
                            <div class="relative aspect-[4/3] overflow-hidden rounded-sm bg-gray-100">
                                <?php if ($prop['img_url']) : ?>
                                    <img src="<?php echo esc_url($prop['img_url']); ?>" alt="<?php echo esc_attr($prop['title']); ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500<?php echo $grayscale; ?>" loading="lazy" />
                                <?php endif; ?>
                                <div class="h-full flex flex-col justify-end absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#101010]/90 to-transparent p-[20px] ">
                                    <?php if ($prop['title']) : ?><h3 class=" text-white <?php echo ($post_type == 'property' ? 'md:!text-[18px] text-base font-helvetica' : '!text-base !font-normal') ?> uppercase tracking-wide"><?php echo esc_html($prop['title']); ?></h3><?php endif; ?>
                                    <?php if ($prop['price']) : ?><div class="text-white/80 !font-light font-helvetica tracking-[0.08em] "><?php echo esc_html($prop['price']); ?></div><?php endif; ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Large featured card -->
            <a href="<?php echo esc_url($featured['permalink']); ?>" class="block group">
                <div class="relative aspect-[16/7] overflow-hidden rounded-sm bg-gray-100">
                    <?php if ($featured['img_large']) : ?>
                        <img src="<?php echo esc_url($featured['img_large']); ?>" alt="<?php echo esc_attr($featured['title']); ?>" class="absolute inset-0 w-full h-full max-h-[545px] object-cover group-hover:scale-105 transition-transform duration-700<?php echo $grayscale; ?>" loading="lazy" />
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#101010] to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-6 md:p-10 max-w-3xl">
                        <?php if ($featured['price']) : ?>
                            <p class="font-['Noto_Serif_Display']  text-white text-4xl md:text-6xl font-light mb-4"><?php echo esc_html($featured['price']); ?></p>
                        <?php endif; ?>
                        <?php if ($featured['title']) : ?>
                            <h3 class="text-white !text-[18px] tracking-[0.08em] md:!text-[24px] font-medium uppercase tracking-wider max-w-[1060px] mb-4 leading-relaxed font-helvetica !font-light"><?php echo esc_html($featured['title']); ?></h3>
                        <?php endif; ?>
                        <?php if ($featured['excerpt']) : ?>
                            <p class="text-white/80 tracking-[0.08em]  md:text-[18px] max-w-[1060px] leading-relaxed font-helvetica !font-light"><?php echo esc_html($featured['excerpt']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>


<!-- Mobile: simple horizontal scroll (hidden on desktop) -->
<div class="md:hidden">
    <div id="<?php echo esc_attr($uid); ?>-mobile" class="flex gap-4 overflow-x-auto snap-x snap-mandatory scrollbar-hide -mx-6 px-6 pb-2">
        <?php foreach ($properties as $prop) : ?>
            <a href="<?php echo esc_url($prop['permalink']); ?>" class="flex-none w-[280px] snap-start group">
                <div class="relative aspect-[4/3] overflow-hidden rounded-sm bg-gray-100">
                    <?php if ($prop['img_url']) : ?>
                        <img src="<?php echo esc_url($prop['img_url']); ?>" alt="<?php echo esc_attr($prop['title']); ?>" class="absolute inset-0 w-full h-full object-cover<?php echo $grayscale; ?>" loading="lazy" />
                    <?php endif; ?>
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/50 to-transparent p-4 pt-12">
                        <?php if ($prop['title']) : ?><h3 class="font-['Noto_Serif_Display'] text-white text-base uppercase tracking-wide"><?php echo esc_html($prop['title']); ?></h3><?php endif; ?>
                        <?php if ($prop['price']) : ?><p class="text-white/80 text-sm mt-1"><?php echo esc_html($prop['price']); ?></p><?php endif; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<script>
(function() {
    var track = document.getElementById('<?php echo esc_js($uid); ?>-track');
    if (!track) return;

    var dots = document.querySelectorAll('[data-pg-dots="<?php echo esc_js($uid); ?>"] [data-pg-dot]');
    var total = <?php echo $total_pages; ?>;

    function scrollToPage(idx) {
        track.scrollTo({ left: idx * track.offsetWidth, behavior: 'smooth' });
    }

    function updateDots() {
        var idx = Math.round(track.scrollLeft / track.offsetWidth);
        dots.forEach(function(d, i) {
            d.className = d.className.replace(/bg-\[#092B23\](\/25)?/g, '');
            d.classList.add(i === idx ? 'bg-[#092B23]' : 'bg-[#092B23]/25');
        });
    }

    // Arrow buttons
    var prev = document.querySelector('[data-pg-prev="<?php echo esc_js($uid); ?>"]');
    var next = document.querySelector('[data-pg-next="<?php echo esc_js($uid); ?>"]');
    if (prev) prev.addEventListener('click', function() {
        var idx = Math.round(track.scrollLeft / track.offsetWidth);
        scrollToPage(idx <= 0 ? total - 1 : idx - 1);
    });
    if (next) next.addEventListener('click', function() {
        var idx = Math.round(track.scrollLeft / track.offsetWidth);
        scrollToPage(idx >= total - 1 ? 0 : idx + 1);
    });

    // Dot clicks
    dots.forEach(function(dot) {
        dot.addEventListener('click', function() {
            scrollToPage(parseInt(this.dataset.pgDot));
        });
    });

    // Update dots on scroll
    track.addEventListener('scroll', updateDots);
})();
</script>
