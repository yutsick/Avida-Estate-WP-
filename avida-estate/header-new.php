<?php
/**
 * Header New — Transparent, white on scroll
 *
 * @package AvidaEstate
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php if (function_exists('resideo_get_social_meta')) {
        resideo_get_social_meta();
    }
    wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$custom_logo_id = get_theme_mod('custom_logo');
$logo           = wp_get_attachment_image_src($custom_logo_id, 'pxp-full');

$second_logo_id = get_theme_mod('resideo_second_logo');
// $second_logo    = wp_get_attachment_image_src($second_logo_id, 'pxp-full');
$second_logo    = wp_get_attachment_image_src($custom_logo_id, 'pxp-full');
?>

<header id="site-header" class="fixed h-[70px] left-0 right-0 z-50 transition-all duration-300" data-header-scroll>
    <div class="max-w-[1400px] mx-auto px-6 flex items-center justify-between">

        <!-- Left nav -->
        <nav class="hidden lg:!flex items-center gap-8">
            <?php wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'walker'         => new class extends Walker_Nav_Menu {
                    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                        $output .= '<a href="' . esc_url($item->url) . '" class="!text-white uppercase tracking-widest !font-[200] transition-colors header-link font-helvetica">' . esc_html($item->title) . '</a>';
                    }
                },
            ]); ?>
        </nav>

        <!-- Logo (center) -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex-shrink-0">
            <?php if ($logo) : ?>
                <img
                    src="<?php echo esc_url($logo[0]); ?>"
                    alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                    class="h-[70px] header-logo transition-opacity duration-300"
                    data-logo-default="<?php echo esc_url($logo[0]); ?>"
                    <?php if ($second_logo) : ?>
                        data-logo-scrolled="<?php echo esc_url($second_logo[0]); ?>"
                    <?php endif; ?>
                />
            <?php else : ?>
                <span class="text-xl font-['Noto_Serif_Display'] uppercase tracking-wider header-link"><?php echo esc_html(get_bloginfo('name')); ?></span>
            <?php endif; ?>
        </a>

        <!-- Right nav -->
        <div class="hidden lg:!flex items-center gap-8">
            <?php wp_nav_menu([
                'theme_location' => 'primary_2',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'walker'         => new class extends Walker_Nav_Menu {
                    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                        $output .= '<a href="' . esc_url($item->url) . '" class="!text-white  uppercase tracking-widest !font-[200] transition-colors header-link font-helvetica">' . esc_html($item->title) . '</a>';
                    }
                },
            ]); ?>
        </div>

        <!-- Mobile burger -->
        <button id="mobile-menu-toggle" class="lg:hidden flex flex-col gap-1.5 p-2" aria-label="Menu">
            <span class="block w-6 h-px header-burger transition-all duration-300"></span>
            <span class="block w-6 h-px header-burger transition-all duration-300"></span>
            <span class="block w-6 h-px header-burger transition-all duration-300"></span>
        </button>

    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="lg:hidden hidden bg-white px-6 pb-6 shadow-lg">
        <?php wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false,
            'items_wrap'     => '<nav class="flex flex-col gap-4 pt-4 border-t border-gray-100">%3$s</nav>',
            'walker'         => new class extends Walker_Nav_Menu {
                function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                    $output .= '<a href="' . esc_url($item->url) . '" class="text-sm uppercase tracking-widest text-[#092B23]">' . esc_html($item->title) . '</a>';
                }
            },
        ]); ?>
        <?php wp_nav_menu([
            'theme_location' => 'primary_2',
            'container'      => false,
            'items_wrap'     => '<nav class="flex flex-col gap-4 mt-4 pt-4 border-t border-gray-100">%3$s</nav>',
            'walker'         => new class extends Walker_Nav_Menu {
                function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                    $output .= '<a href="' . esc_url($item->url) . '" class="text-sm uppercase tracking-widest text-[#092B23]">' . esc_html($item->title) . '</a>';
                }
            },
        ]); ?>
    </div>
</header>

<script>
(function() {
    var header = document.getElementById('site-header');
    var logo   = header.querySelector('.header-logo');
    var links  = header.querySelectorAll('.header-link');
    var bars   = header.querySelectorAll('.header-burger');

    var lastY  = 0;
    var state  = 'top'; // 'top' | 'hidden' | 'solid'

    function setTop() {
        // Transparent, white text, visible
        header.style.transform = 'translateY(0)';
        header.classList.remove('bg-[#092B23]/70', 'shadow-sm');
        header.classList.add('bg-transparent');
        // links.forEach(function(l) { l.classList.add('!text-white'); l.classList.remove('!text-[#092B23]'); });
        // bars.forEach(function(b) { b.classList.add('!bg-white'); b.classList.remove('!bg-[#092B23]'); });
        if (logo && logo.dataset.logoDefault) logo.src = logo.dataset.logoDefault;
        state = 'top';
    }

    function setHidden() {
        // Slide up, hide
        header.style.transform = 'translateY(-100%)';
        state = 'hidden';
    }

    function setSolid() {
        // White bg, dark text, visible
        header.style.transform = 'translateY(0)';
        header.classList.add('bg-[#092B23]/70', 'shadow-sm');
        header.classList.remove('bg-transparent');
        // links.forEach(function(l) { l.classList.remove('!text-white'); l.classList.add('!text-[#092B23]'); });
        // bars.forEach(function(b) { b.classList.remove('!bg-white'); b.classList.add('!bg-[#092B23]'); });
        if (logo && logo.dataset.logoScrolled) logo.src = logo.dataset.logoScrolled;
        state = 'solid';
    }

    function onScroll() {
        var y = window.scrollY;
        var goingUp = y < lastY;

        if (y <= 50) {
            // At the very top
            if (state !== 'top') setTop();
        } else if (goingUp) {
            // Scrolling up — show with white bg
            if (state !== 'solid') setSolid();
        } else {
            // Scrolling down — hide
            if (state !== 'hidden') setHidden();
        }

        lastY = y;
    }

    // Initial state
    setTop();

    window.addEventListener('scroll', onScroll, { passive: true });

    // Mobile toggle
    var toggle = document.getElementById('mobile-menu-toggle');
    var menu   = document.getElementById('mobile-menu');
    if (toggle && menu) {
        toggle.addEventListener('click', function() {
            menu.classList.toggle('hidden');
        });
    }
})();
</script>
