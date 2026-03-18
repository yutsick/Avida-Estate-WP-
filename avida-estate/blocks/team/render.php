<?php
/**
 * Team Block Template
 *
 * @package AvidaEstate
 */

$heading         = get_field('team_heading');
$subtitle        = get_field('team_subtitle');
$heading_link    = get_field('team_heading_link');
$display_mode    = get_field('team_display_mode') ?: 'grid';
$show_all        = get_field('team_show_all');
$show_owners     = get_field('team_show_owners');
$owners_title    = get_field('team_owners_title');
$owners_subtitle = get_field('team_owners_subtitle');
$selected        = get_field('team_members'); // relationship field, returns array of IDs

$anchor    = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';
$is_slider = ($display_mode === 'slider');
$slider_id = 'team-' . uniqid();

// Build the list of agent IDs
if ($show_all) {
    // All agents from CPT
    $q = new WP_Query([
        'post_type'      => 'agent',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
        'fields'         => 'ids',
    ]);
    $agent_ids = $q->posts;
    wp_reset_postdata();
} else {
    // Only selected agents from relationship field
    $agent_ids = [];
    if (!empty($selected) && is_array($selected)) {
        foreach ($selected as $item) {
            $agent_ids[] = $item instanceof WP_Post ? $item->ID : (int) $item;
        }
    }
}

// Separate owners into chess-pattern section if toggle is on
$owner_ids  = [];
$member_ids = [];

if ($show_owners && !$show_all) {
    // Split: owners go to separate section, rest to cards
    foreach ($agent_ids as $aid) {
        $type = get_post_meta($aid, 'agent_type', true);
        if ($type === 'owner') {
            $owner_ids[] = $aid;
        } else {
            $member_ids[] = $aid;
        }
    }
} else {
    // All selected agents as cards (no filtering)
    $member_ids = $agent_ids;
}

if (empty($member_ids) && empty($owner_ids)) {
    return;
}
?>

<section<?php echo $anchor; ?> class="bg-[#E9EDE9] py-16 md:py-24">
    <div class="max-w-[1400px] mx-auto px-6">

        <?php
        $has_heading = $heading || $subtitle;
        $has_arrows  = $is_slider && !empty($member_ids);
        ?>

        <?php if ($has_heading || $has_arrows) : ?>
            <div class="flex items-center <?php echo $has_heading ? 'justify-between' : 'justify-end'; ?> mb-10">
                <?php if ($has_heading) : ?>
                    <div>
                        <?php if ($heading) : ?>
                            <h2 class="font-['Noto_Serif_Display'] text-[#092B23] !text-2xl md:!text-[40px] !font-medium uppercase">
                                <?php echo esc_html($heading); ?>
                            </h2>
                        <?php endif; ?>
                        <?php if ($subtitle) : ?>
                            <p class="text-[#092B23]/60 mt-2 text-sm md:text-base tracking-wide">
                                <?php echo esc_html($subtitle); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if ($heading_link || $has_arrows) : ?>
                    <div class="flex items-center gap-3">
                        <?php if ($heading_link) : ?>
                            <a href="<?php echo esc_url($heading_link['url']); ?>" target="<?php echo esc_attr($heading_link['target'] ?: '_self'); ?>" class="flex items-center justify-center w-10 h-10 rounded-full border border-[#092B23]/20 text-[#092B23] hover:bg-[#092B23] hover:text-white transition-colors" aria-label="<?php echo esc_attr($heading_link['title'] ?: 'View all'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        <?php endif; ?>
                        <?php if ($has_arrows) : ?>
                            <button type="button" data-team-prev="<?php echo esc_attr($slider_id); ?>" class="flex items-center justify-center w-10 h-10 rounded-full border border-[#092B23]/20 text-[#092B23] hover:bg-[#092B23] hover:text-white transition-colors" aria-label="Previous">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button type="button" data-team-next="<?php echo esc_attr($slider_id); ?>" class="flex items-center justify-center w-10 h-10 rounded-full border border-[#092B23]/20 text-[#092B23] hover:bg-[#092B23] hover:text-white transition-colors" aria-label="Next">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
        // Owners section (chess-pattern)
        if (!empty($owner_ids)) {
            $owners = $owner_ids;
            include __DIR__ . '/owners.php';
        }
        ?>

        <?php if (!empty($member_ids)) :
            $container_class = $is_slider
                ? 'flex gap-5 overflow-x-auto snap-x snap-mandatory scroll-smooth'
                : 'flex gap-5 overflow-x-auto snap-x snap-mandatory sm:flex-wrap sm:overflow-visible pb-4 sm:pb-0';
            $card_class = 'flex-none w-[85%] sm:w-[calc(50%-10px)] md:w-[calc(33.333%-14px)] lg:w-[calc(25%-15px)] snap-start group';
        ?>
            <div <?php if ($is_slider) echo 'id="' . esc_attr($slider_id) . '"'; ?> class="<?php echo $container_class; ?>" style="scrollbar-width: none; -ms-overflow-style: none;">
                <?php foreach ($member_ids as $member_id) :
                    $name      = get_the_title($member_id);
                    $role      = get_post_meta($member_id, 'agent_title', true);
                    $avatar_id = get_post_meta($member_id, 'agent_avatar', true);
                    $avatar    = $avatar_id ? wp_get_attachment_image_src($avatar_id, 'pxp-agent') : null;
                    $permalink = get_permalink($member_id);
                ?>
                    <a href="<?php echo esc_url($permalink); ?>" class="<?php echo $card_class; ?>">
                        <div class="relative overflow-hidden rounded-sm bg-gray-100 aspect-[4/5]">
                            <?php if ($avatar) : ?>
                                <img
                                    src="<?php echo esc_url($avatar[0]); ?>"
                                    alt="<?php echo esc_attr($name); ?>"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy"
                                />
                            <?php endif; ?>
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black to-transparent px-4 pt-16 pb-4 text-[#E9EDE9] font-helvetica !font-normal">
                                <?php if ($name) : ?>
                                    <h3 class="!text-[22px] uppercase tracking-wide !font-normal"><?php echo esc_html($name); ?></h3>
                                <?php endif; ?>
                                <?php if ($role) : ?>
                                    <p class="!tracking-[0.08em] !font-normal mt-1"><?php echo esc_html($role); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php if ($is_slider && !empty($member_ids)) : ?>
<script>
(function() {
    var track = document.getElementById('<?php echo esc_js($slider_id); ?>');
    if (!track) return;
    var cards = track.querySelectorAll('.snap-start');
    if (!cards.length) return;
    var gap = 20;
    var prev = document.querySelector('[data-team-prev="<?php echo esc_js($slider_id); ?>"]');
    var next = document.querySelector('[data-team-next="<?php echo esc_js($slider_id); ?>"]');
    if (prev) prev.addEventListener('click', function() {
        track.scrollBy({ left: -(cards[0].offsetWidth + gap), behavior: 'smooth' });
    });
    if (next) next.addEventListener('click', function() {
        track.scrollBy({ left: cards[0].offsetWidth + gap, behavior: 'smooth' });
    });
})();
</script>
<?php endif; ?>
