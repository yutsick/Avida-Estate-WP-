<?php
/**
 * Latest Posts Block Template
 *
 * @package AvidaEstate
 */

$heading      = get_field('lp_heading');
$heading_link = get_field('lp_heading_link');
$count        = get_field('lp_count') ?: 8;
$category     = get_field('lp_category');

$anchor = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';

$args = [
    'post_type'      => 'post',
    'posts_per_page' => $count,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
];

if ($category) {
    $args['cat'] = $category;
}

$query = new WP_Query($args);

if (!$query->have_posts()) {
    wp_reset_postdata();
    return;
}

$uid = 'lp-' . uniqid();
$total = $query->post_count;
?>

<section<?php echo $anchor; ?> class="bg-white py-16 md:py-24">
    <div class="max-w-[1400px] mx-auto px-6">

        <div class="flex items-center justify-between mb-10">
            <?php if ($heading) : ?>
                <h2 class="font-['Noto_Serif_Display'] text-[#092B23] text-2xl md:text-[32px] font-light uppercase">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php endif; ?>

            <div class="flex items-center gap-3">
                <?php if ($total > 4) : ?>
                    <button data-prev="<?php echo esc_attr($uid); ?>" class="flex items-center justify-center w-10 h-10 rounded-full border border-[#092B23]/20 text-[#092B23] hover:bg-[#092B23] hover:text-white transition-colors" aria-label="Previous">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button data-next="<?php echo esc_attr($uid); ?>" class="flex items-center justify-center w-10 h-10 rounded-full border border-[#092B23]/20 text-[#092B23] hover:bg-[#092B23] hover:text-white transition-colors" aria-label="Next">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                <?php endif; ?>

                <?php if ($heading_link) : ?>
                    <a href="<?php echo esc_url($heading_link['url']); ?>" target="<?php echo esc_attr($heading_link['target'] ?: '_self'); ?>" class="flex items-center justify-center w-10 h-10 rounded-full border border-[#092B23]/20 text-[#092B23] hover:bg-[#092B23] hover:text-white transition-colors" aria-label="<?php echo esc_attr($heading_link['title'] ?: 'View all'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div id="<?php echo esc_attr($uid); ?>" class="flex gap-5 overflow-x-auto snap-x snap-mandatory scrollbar-hide -mx-6 px-6 pb-2">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="flex-none w-[280px] md:w-[calc(25%-15px)] snap-start group">
                    <div class="relative aspect-[4/3] overflow-hidden rounded-sm bg-gray-100 mb-4">
                        <?php if (has_post_thumbnail()) : ?>
                            <img
                                src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'pxp-gallery')); ?>"
                                alt="<?php echo esc_attr(get_the_title()); ?>"
                                class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                            />
                        <?php endif; ?>
                    </div>
                    <h3 class="text-[#092B23] text-xs md:text-sm font-medium uppercase tracking-wide leading-snug">
                        <?php the_title(); ?>
                    </h3>
                </a>
            <?php endwhile; ?>
        </div>

    </div>

    <?php wp_reset_postdata(); ?>

    <script>
    (function() {
        var track = document.getElementById('<?php echo esc_js($uid); ?>');
        if (!track) return;
        var cardW = function() { return track.firstElementChild.offsetWidth + 20; };

        var prev = document.querySelector('[data-prev="<?php echo esc_js($uid); ?>"]');
        var next = document.querySelector('[data-next="<?php echo esc_js($uid); ?>"]');

        if (prev) prev.addEventListener('click', function() {
            track.scrollBy({ left: -cardW(), behavior: 'smooth' });
        });
        if (next) next.addEventListener('click', function() {
            track.scrollBy({ left: cardW(), behavior: 'smooth' });
        });
    })();
    </script>
</section>
