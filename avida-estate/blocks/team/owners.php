<?php
/**
 * Team Block — Owners Section (chess-pattern layout)
 *
 * Expected variables:
 * @var array  $owners        Array of owner post IDs
 * @var string $owners_title  Section title (can be empty)
 * @var string $owners_subtitle Section subtitle (can be empty)
 *
 * @package AvidaEstate
 */

if (empty($owners)) {
    return;
}
?>

<div class="mb-16 md:mb-24">
    <?php if ($owners_title || $owners_subtitle) : ?>
        <div class="mb-10 md:mb-14">
            <?php if ($owners_title) : ?>
                <h2 class="font-['Noto_Serif_Display'] text-[#092B23] !text-2xl md:!text-[40px] !font-medium uppercase">
                    <?php echo esc_html($owners_title); ?>
                </h2>
            <?php endif; ?>
            <?php if ($owners_subtitle) : ?>
                <p class="text-[#092B23]/60 mt-2 text-sm md:text-base tracking-wide uppercase">
                    <?php echo esc_html($owners_subtitle); ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="flex flex-col gap-10 md:gap-16">
        <?php foreach ($owners as $index => $owner_id) :
            $name        = get_the_title($owner_id);
            $title       = get_post_meta($owner_id, 'agent_title', true);
            $description = get_the_content(null, false, $owner_id);
            $avatar_id   = get_post_meta($owner_id, 'agent_avatar', true);
            $avatar_src  = $avatar_id ? wp_get_attachment_image_src($avatar_id, 'pxp-agent') : null;
            $permalink   = get_permalink($owner_id);
            $is_even     = ($index % 2 === 0);
        ?>
            <div class="flex flex-col <?php echo $is_even ? 'md:flex-row' : 'md:flex-row-reverse'; ?> gap-6 md:gap-12 items-stretch">
                <!-- Photo -->
                <div class="w-full md:w-1/2 flex-shrink-0">
                    <?php if ($avatar_src) : ?>
                        <img
                            src="<?php echo esc_url($avatar_src[0]); ?>"
                            alt="<?php echo esc_attr($name); ?>"
                            class="w-full h-full object-cover rounded-sm aspect-[4/5] md:aspect-auto"
                            loading="lazy"
                        />
                    <?php else : ?>
                        <div class="w-full h-full bg-gray-200 rounded-sm aspect-[4/5] md:aspect-auto flex items-center justify-center">
                            <span class="text-gray-400 text-sm">No photo</span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Text content -->
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <?php if ($title) : ?>
                        <p class="text-[#092B23]/50 text-xs md:text-sm tracking-[0.15em] uppercase mb-2">
                            <?php echo esc_html($title); ?>
                        </p>
                    <?php endif; ?>

                    <div class="w-12 h-px bg-[#092B23]/20 mb-6"></div>

                    <?php if ($name) : ?>
                        <h3 class="font-['Noto_Serif_Display'] text-[#092B23] !text-xl md:!text-3xl !font-medium uppercase mb-4">
                            <?php echo esc_html($name); ?>
                        </h3>
                    <?php endif; ?>

                    <?php if ($description) : ?>
                        <div class="text-[#092B23]/70 text-sm md:text-base leading-relaxed tracking-wide mb-6">
                            <?php echo wp_kses_post($description); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($permalink) : ?>
                        <a href="<?php echo esc_url($permalink); ?>" class="inline-flex items-center gap-2 text-[#092B23] text-xs md:text-sm tracking-[0.15em] uppercase hover:opacity-70 transition-opacity">
                            View Full Profile
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
