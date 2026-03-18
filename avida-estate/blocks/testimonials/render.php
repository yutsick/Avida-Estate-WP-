<?php
/**
 * Testimonials Block Template
 *
 * @package AvidaEstate
 */

$heading      = get_field('test_heading');
$heading_link = get_field('test_heading_link');
$selected_ids = get_field('test_items');
$count        = get_field('test_count') ?: 9;

$anchor = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';

// If specific testimonials selected, use them; otherwise query latest
if ($selected_ids && is_array($selected_ids) && count($selected_ids) > 0) {
    $testimonial_ids = $selected_ids;
} else {
    $query = new WP_Query([
        'post_type'      => 'testimonial',
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'fields'         => 'ids',
    ]);
    $testimonial_ids = $query->posts;
    wp_reset_postdata();
}

if (empty($testimonial_ids)) {
    return;
}

$uid = 'test-' . uniqid();
?>

<section<?php echo $anchor; ?> class="bg-[#101010] py-16 md:py-24">
    <div class="max-w-[1400px] mx-auto px-6">

        <div class="flex items-center justify-between mb-10">
            <?php if ($heading) : ?>
                <h2 class="font-['Noto_Serif_Display'] text-white text-2xl md:text-[32px] font-light uppercase">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php endif; ?>

            <?php if ($heading_link) : ?>
                <a href="<?php echo esc_url($heading_link['url']); ?>" target="<?php echo esc_attr($heading_link['target'] ?: '_self'); ?>" class="flex items-center justify-center w-10 h-10 rounded-full border border-white/30 text-white hover:bg-white hover:text-[#092B23] transition-colors" aria-label="<?php echo esc_attr($heading_link['title'] ?: 'View all'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            <?php endif; ?>
        </div>

        <div id="<?php echo esc_attr($uid); ?>" class="flex gap-5 overflow-x-auto snap-x snap-mandatory scrollbar-hide -mx-6 px-6 pb-2">
            <?php foreach ($testimonial_ids as $t_id) :
                $name     = get_the_title($t_id);
                $text     = get_post_meta($t_id, 'testimonial_text', true);
                $location = get_post_meta($t_id, 'testimonial_location', true);
                $date     = get_the_date('j F, Y', $t_id);
            ?>
                <div class="flex-none w-[320px] md:w-[calc(33.333%-14px)] snap-start">
                    <div class="border !border-white/20 p-6 md:p-8 h-full flex flex-col">
                        <div class="mb-6">
                            <?php if ($name) : ?>
                                <h3 class="font-['Noto_Serif_Display'] text-white text-lg md:text-[26px] uppercase tracking-wide"><?php echo esc_html($name); ?></h3>
                            <?php endif; ?>
                            <p class="text-white/80 !font-light font-helvetica mt-1"><?php echo esc_html($date); ?></p>
                        </div>

                        <?php if ($text) : ?>
                            <p class="text-white !font-light font-helvetica !text-[18px]  leading-relaxed flex-grow">
                                <?php echo esc_html($text); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($testimonial_ids) > 3) : ?>
            <div class="flex justify-center gap-2 mt-8" data-test-dots="<?php echo esc_attr($uid); ?>">
                <?php
                $total_dots = ceil(count($testimonial_ids) / 3);
                for ($i = 0; $i < $total_dots; $i++) : ?>
                    <button class="w-2.5 h-2.5 rounded-full transition-colors <?php echo $i === 0 ? 'bg-white' : 'bg-white/30'; ?>" data-dot="<?php echo $i; ?>" aria-label="Page <?php echo $i + 1; ?>"></button>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

    </div>

    <script>
    (function() {
        var track = document.getElementById('<?php echo esc_js($uid); ?>');
        if (!track) return;
        var cardW = function() { return track.firstElementChild.offsetWidth + 20; };

        var dots = document.querySelectorAll('[data-test-dots="<?php echo esc_js($uid); ?>"] [data-dot]');
        if (dots.length) {
            dots.forEach(function(dot) {
                dot.addEventListener('click', function() {
                    var idx = parseInt(this.dataset.dot);
                    track.scrollTo({ left: idx * cardW() * 3, behavior: 'smooth' });
                });
            });
            track.addEventListener('scroll', function() {
                var active = Math.round(track.scrollLeft / (cardW() * 3));
                dots.forEach(function(d, i) {
                    d.className = d.className.replace(/bg-white(\/30)?/g, '');
                    d.classList.add(i === active ? 'bg-white' : 'bg-white/30');
                });
            });
        }
    })();
    </script>
</section>
