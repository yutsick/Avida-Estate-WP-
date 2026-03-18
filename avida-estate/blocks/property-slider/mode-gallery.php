<?php
/**
 * Property Slider — Mode: Gallery
 * Click thumbnail to show large preview below.
 *
 * Expects: $properties, $uid, $grayscale, $heading, $heading_link
 */

$first = $properties[0];
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

<!-- Thumbnails -->
<div id="<?php echo esc_attr($uid); ?>" class="flex gap-5 overflow-x-auto snap-x snap-mandatory scrollbar-hide -mx-6 px-6 pb-2">
    <?php foreach ($properties as $i => $prop) : ?>
        <button type="button" data-gallery-thumb="<?php echo esc_attr($uid); ?>" data-index="<?php echo $i; ?>"
            class="flex-none w-[280px] md:w-[calc(25%-15px)] snap-start group text-left transition-opacity <?php echo $i === 0 ? 'opacity-100' : 'opacity-60 hover:opacity-90'; ?>">
            <div class="relative aspect-[4/3] overflow-hidden rounded-sm bg-gray-100">
                <?php if ($prop['img_url']) : ?>
                    <img src="<?php echo esc_url($prop['img_url']); ?>" alt="<?php echo esc_attr($prop['title']); ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500<?php echo $grayscale; ?>" loading="lazy" />
                <?php endif; ?>
                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/50 to-transparent p-4 pt-12">
                    <?php if ($prop['title']) : ?><h3 class="font-['Noto_Serif_Display'] text-white text-base md:text-lg uppercase tracking-wide"><?php echo esc_html($prop['title']); ?></h3><?php endif; ?>
                    <?php if ($prop['price']) : ?><p class="text-white/80 text-sm mt-1"><?php echo esc_html($prop['price']); ?></p><?php endif; ?>
                </div>
            </div>
        </button>
    <?php endforeach; ?>
</div>

<!-- Large preview -->
<div id="<?php echo esc_attr($uid); ?>-preview" class="relative mt-6 aspect-[16/7] overflow-hidden rounded-sm bg-gray-100">
    <img id="<?php echo esc_attr($uid); ?>-preview-img" src="<?php echo esc_url($first['img_large']); ?>" alt="<?php echo esc_attr($first['title']); ?>" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500" />
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
    <div class="absolute inset-x-0 bottom-0 p-6 md:p-10 max-w-3xl">
        <p id="<?php echo esc_attr($uid); ?>-preview-price" class="font-['Noto_Serif_Display'] italic text-white text-3xl md:text-5xl font-light mb-3"><?php echo esc_html($first['price']); ?></p>
        <h3 id="<?php echo esc_attr($uid); ?>-preview-title" class="text-white text-sm md:text-base uppercase tracking-wider font-medium mb-3"><?php echo esc_html($first['title']); ?></h3>
        <p id="<?php echo esc_attr($uid); ?>-preview-excerpt" class="text-white/80 text-sm leading-relaxed" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;"><?php echo esc_html($first['excerpt']); ?></p>
        <a id="<?php echo esc_attr($uid); ?>-preview-link" href="<?php echo esc_url($first['permalink']); ?>" class="inline-flex items-center gap-2 text-white text-sm uppercase tracking-widest mt-4 hover:opacity-70 transition-opacity">
            View Property <span class="w-6 h-px bg-white"></span>
        </a>
    </div>
</div>

<script type="application/json" id="<?php echo esc_attr($uid); ?>-data">
    <?php echo wp_json_encode(array_map(function($p) {
        return ['img' => $p['img_large'], 'price' => $p['price'], 'title' => $p['title'], 'excerpt' => $p['excerpt'], 'permalink' => $p['permalink']];
    }, $properties)); ?>
</script>

<script>
(function() {
    var track = document.getElementById('<?php echo esc_js($uid); ?>');
    if (!track) return;
    var cardW = function() { return track.firstElementChild.offsetWidth + 20; };

    var prev = document.querySelector('[data-prev="<?php echo esc_js($uid); ?>"]');
    var next = document.querySelector('[data-next="<?php echo esc_js($uid); ?>"]');
    if (prev) prev.addEventListener('click', function() { track.scrollBy({ left: -cardW(), behavior: 'smooth' }); });
    if (next) next.addEventListener('click', function() { track.scrollBy({ left: cardW(), behavior: 'smooth' }); });

    var dataEl = document.getElementById('<?php echo esc_js($uid); ?>-data');
    if (!dataEl) return;
    var items = JSON.parse(dataEl.textContent);
    var thumbs = document.querySelectorAll('[data-gallery-thumb="<?php echo esc_js($uid); ?>"]');
    var pImg     = document.getElementById('<?php echo esc_js($uid); ?>-preview-img');
    var pPrice   = document.getElementById('<?php echo esc_js($uid); ?>-preview-price');
    var pTitle   = document.getElementById('<?php echo esc_js($uid); ?>-preview-title');
    var pExcerpt = document.getElementById('<?php echo esc_js($uid); ?>-preview-excerpt');
    var pLink    = document.getElementById('<?php echo esc_js($uid); ?>-preview-link');

    thumbs.forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            var item = items[parseInt(this.dataset.index)];
            if (!item) return;
            pImg.style.opacity = '0';
            setTimeout(function() {
                pImg.src = item.img; pImg.alt = item.title;
                pPrice.textContent = item.price;
                pTitle.textContent = item.title;
                pExcerpt.textContent = item.excerpt;
                pLink.href = item.permalink;
                pImg.style.opacity = '1';
            }, 300);
            thumbs.forEach(function(t) { t.classList.remove('opacity-100'); t.classList.add('opacity-60'); });
            this.classList.remove('opacity-60'); this.classList.add('opacity-100');
        });
    });
})();
</script>
