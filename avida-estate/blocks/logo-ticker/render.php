<?php
/**
 * Logo Ticker Block Template
 *
 * @package AvidaEstate
 */

$logos    = get_field('ticker_logos');
$bg      = get_field('ticker_background') ?: '#002C23';
$speed   = get_field('ticker_speed') ?: 30;

$anchor = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';

$has_logos = false;
if ($logos && is_array($logos)) {
    foreach ($logos as $row) {
        if (!empty($row['logo'])) { $has_logos = true; break; }
    }
}

$uid = 'ticker-' . uniqid();
?>

<section<?php echo $anchor; ?> class="overflow-hidden py-10 md:py-14" style="background-color: <?php echo esc_attr($bg); ?>;">
    <div class="relative flex w-full justify-around" aria-hidden="true">
        <?php for ($i = 0; $i < 5; $i++) : ?>
            <div class="flex shrink-0 items-center gap-16 animate-marquee" style="animation-duration: <?php echo esc_attr($speed); ?>s;">
                <?php if ($has_logos) : ?>
                    <?php foreach ($logos as $row) :
                        $logo = $row['logo'] ?? null;
                        if (!$logo) continue;
                    ?>
                        <img
                            src="<?php echo esc_url($logo['sizes']['medium'] ?? $logo['url']); ?>"
                            alt="<?php echo esc_attr($logo['alt'] ?? ''); ?>"
                            class="h-6 md:h-8 w-auto opacity-50 object-contain"
                            loading="lazy"
                        />
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php for ($j = 0; $j < 5; $j++) : ?>
                        <p class="text-white text-sm md:text-base whitespace-nowrap opacity-50 last:mr-10">Logotype</p>
                    <?php endfor; ?>
                <?php endif; ?>
                
            </div>

        <?php endfor; ?>
    </div>

    <style>
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }
        .animate-marquee {
            animation: marquee linear infinite;
        }
    </style>
</section>
