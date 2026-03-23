<?php
/**
 * Footer New — Luxury dark footer
 * All data from ACF Options Page (Avida Settings).
 *
 * @package AvidaEstate
 */

// Contact
$phone        = get_field('footer_phone', 'option') ?: '+34 952 766 950';
$email        = get_field('footer_email', 'option') ?: 'info@drumelia.com';
$address      = get_field('footer_address', 'option') ?: '';
$contact_page = get_field('footer_contact_page', 'option');

// Navigation
$nav_links  = get_field('footer_nav', 'option') ?: [];
$col_links  = get_field('footer_collection', 'option') ?: [];

// Social
$linkedin  = get_field('footer_linkedin', 'option') ?: '';
$instagram = get_field('footer_instagram', 'option') ?: '';
$youtube   = get_field('footer_youtube', 'option') ?: '';

// Awards
$awards = get_field('footer_awards', 'option') ?: [];

// Legal
$company      = get_field('footer_company', 'option') ?: 'Drumelia Real Estate';
$terms_link   = get_field('footer_terms_link', 'option');
$cookies_link = get_field('footer_cookies_link', 'option');
$credits      = get_field('footer_credits', 'option') ?: '';

// Subscribe
$subscribe_heading = get_field('footer_subscribe_heading', 'option') ?: 'Subscribe to Our News';
$subscribe_action  = get_field('footer_subscribe_action', 'option') ?: '#';
$privacy_text      = get_field('footer_privacy_text', 'option') ?: 'I agree to receive info by email and I accept the privacy policy';

$phone_clean = preg_replace('/\s+/', '', $phone);
?>

    <!-- Footer New -->
    <footer class="bg-[#1a1a1a] text-[#c5c5b8]">

        <!-- Top: CTA + Subscribe -->
        <div class="max-w-[1400px] mx-auto px-6 pt-16 md:pt-24 pb-14 grid grid-cols-1 lg:grid-cols-2 gap-16">

            <!-- GET IN TOUCH -->
            <div>
                <h2 class="font-['Noto_Serif_Display'] text-white text-2xl md:text-[32px] font-light uppercase mb-8">Get in Touch</h2>
                <a href="tel:<?php echo esc_attr($phone_clean); ?>" class="flex items-center justify-between w-full max-w-md border border-white/20 px-6 py-4 mb-4 text-white text-sm uppercase tracking-widest hover:bg-white/5 transition-colors">
                    <span>Call Us</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
                <?php
                $message_url = $contact_page ? $contact_page['url'] : 'mailto:' . $email;
                $message_target = $contact_page && !empty($contact_page['target']) ? $contact_page['target'] : '_self';
                ?>
                <a href="<?php echo esc_url($message_url); ?>" target="<?php echo esc_attr($message_target); ?>" class="flex items-center justify-between w-full max-w-md bg-[#111] border border-white/20 px-6 py-4 text-white text-sm uppercase tracking-widest hover:bg-white/5 transition-colors">
                    <span>Message Us</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- SUBSCRIBE -->
            <div>
                <h2 class="font-['Noto_Serif_Display'] text-white text-2xl md:text-[32px] font-light uppercase mb-8"><?php echo esc_html($subscribe_heading); ?></h2>
                <form class="mb-6" action="<?php echo esc_url($subscribe_action); ?>" method="post">
                    <div class="flex items-center border-b border-white/30 pb-2 mb-4">
                        <input type="email" name="footer_email_input" placeholder="ENTER YOUR EMAIL" required
                               class="flex-1 bg-transparent text-white text-sm tracking-wider placeholder:text-white/40 focus:outline-none" />
                        <button type="submit" class="text-white text-sm uppercase tracking-widest hover:opacity-70 transition-opacity ml-4">Subscribe</button>
                    </div>
                    <label class="flex items-start gap-3 text-xs text-white/50 cursor-pointer">
                        <input type="checkbox" name="footer_consent" class="mt-0.5 accent-[#092B23]" required />
                        <span><?php echo esc_html($privacy_text); ?></span>
                    </label>
                </form>

                <?php if ($awards && is_array($awards)) : ?>
                    <div class="flex items-center gap-4 mt-8">
                        <?php foreach ($awards as $award) :
                            $img = $award['image'] ?? null;
                            if (!$img) continue;
                        ?>
                            <img
                                src="<?php echo esc_url($img['sizes']['thumbnail'] ?? $img['url']); ?>"
                                alt="<?php echo esc_attr($img['alt'] ?? 'Award'); ?>"
                                class="w-16 h-16 rounded-full object-contain opacity-60"
                                loading="lazy"
                            />
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Divider -->
        <div class="max-w-[1400px] mx-auto px-6"><hr class="border-white/10" /></div>

        <!-- Navigation columns -->
        <div class="max-w-[1400px] mx-auto px-6 py-14 grid grid-cols-2 md:grid-cols-4 gap-10">

            <!-- NAVIGATION -->
            <?php if ($nav_links) : ?>
                <div>
                    <h3 class="text-white/50 text-xs uppercase tracking-[0.2em] mb-6">Navigation</h3>
                    <ul class="space-y-3">
                        <?php foreach ($nav_links as $row) :
                            $link = $row['link'] ?? null;
                            if (!$link) continue;
                        ?>
                            <li><a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ?: '_self'); ?>" class="text-sm !text-[#c5c5b8] hover:text-white transition-colors"><?php echo esc_html($link['title']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- COLLECTION -->
            <?php if ($col_links) : ?>
                <div>
                    <h3 class="text-white/50 text-xs uppercase tracking-[0.2em] mb-6">Collection</h3>
                    <ul class="space-y-3">
                        <?php foreach ($col_links as $row) :
                            $link = $row['link'] ?? null;
                            if (!$link) continue;
                        ?>
                            <li><a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ?: '_self'); ?>" class="text-sm !text-[#c5c5b8] hover:text-white transition-colors"><?php echo esc_html($link['title']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- CONTACT -->
            <div>
                <h3 class="text-white/50 text-xs uppercase tracking-[0.2em] mb-6">Contact</h3>
                <ul class="space-y-3">
                    <li><a href="mailto:<?php echo esc_attr($email); ?>" class="text-sm !text-[#c5c5b8] hover:text-white transition-colors"><?php echo esc_html($email); ?></a></li>
                    <li><a href="tel:<?php echo esc_attr($phone_clean); ?>" class="text-sm !text-[#c5c5b8] hover:text-white transition-colors"><?php echo esc_html($phone); ?></a></li>
                </ul>
            </div>

            <!-- ADDRESS -->
            <?php if ($address) : ?>
                <div class="col-span-2 md:col-span-1">
                    <div class="text-sm text-[#c5c5b8] leading-relaxed whitespace-pre-line"><?php echo esc_html($address); ?></div>
                    <p class="mt-3 text-sm"><a href="tel:<?php echo esc_attr($phone_clean); ?>" class="!text-[#c5c5b8] hover:text-white transition-colors"><?php echo esc_html($phone); ?></a></p>
                    <p class="text-sm"><a href="mailto:<?php echo esc_attr($email); ?>" class="!text-[#c5c5b8] hover:text-white transition-colors"><?php echo esc_html($email); ?></a></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Divider -->
        <div class="max-w-[1400px] mx-auto px-6"><hr class="border-white/10" /></div>

        <!-- Bottom bar -->
        <div class="max-w-[1400px] mx-auto px-6 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-xs text-white/40 text-center md:text-left">
                &copy; <?php echo date('Y'); ?> <?php echo esc_html($company); ?>.
                <?php if ($terms_link) : ?>
                    <a href="<?php echo esc_url($terms_link['url']); ?>" class="hover:text-white transition-colors"><?php echo esc_html($terms_link['title'] ?: 'Terms of use'); ?></a> &middot;
                <?php endif; ?>
                <?php if ($cookies_link) : ?>
                    <a href="<?php echo esc_url($cookies_link['url']); ?>" class="hover:text-white transition-colors"><?php echo esc_html($cookies_link['title'] ?: 'Cookies Policy'); ?></a> &middot;
                <?php endif; ?>
                <?php if ($credits) : ?>
                    Built by <?php echo esc_html($credits); ?>
                <?php endif; ?>
            </p>
            <div class="flex items-center gap-6">
                <?php if ($linkedin) : ?>
                    <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener" class="text-xs !text-[#c5c5b8] underline hover:text-white transition-colors">Linkedin</a>
                <?php endif; ?>
                <?php if ($instagram) : ?>
                    <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener" class="text-xs !text-[#c5c5b8] underline hover:text-white transition-colors">Instagram</a>
                <?php endif; ?>
                <?php if ($youtube) : ?>
                    <a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener" class="text-xs !text-[#c5c5b8] underline hover:text-white transition-colors">Youtube</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sticky bottom bar -->
        <div class="max-w-[1400px] mx-auto px-6 pb-6 flex items-center justify-center gap-8">
            <a href="tel:<?php echo esc_attr($phone_clean); ?>" class="text-xs !text-white uppercase tracking-widest hover:opacity-70 transition-opacity">Call Us</a>
            <?php if ($contact_page) : ?>
                <a href="<?php echo esc_url($contact_page['url']); ?>" class="text-xs !text-white uppercase tracking-widest hover:opacity-70 transition-opacity">Contact</a>
            <?php endif; ?>
        </div>

    </footer>

    <?php wp_footer(); ?>
</body>
</html>
