<?php
/**
 * Shared property card partial.
 *
 * Normalize these vars before including:
 *   $card_id       — unique ID (reference or post ID)
 *   $card_url      — detail page URL
 *   $card_title    — property title
 *   $card_images   — array of image URLs
 *   $card_beds     — bedrooms string
 *   $card_baths    — bathrooms string
 *   $card_size     — built area string
 *   $card_size_unit — m², sq ft, etc.
 *   $card_plot     — plot size string (optional)
 *   $card_price    — formatted price with currency
 *   $card_label    — badge text (Exclusive, Featured…) or empty
 *   $card_location — location/neighbourhood (optional)
 *
 * @package AvidaEstate
 */

if (empty($card_id)) return;

$carousel_id = 'card-carousel-' . esc_attr($card_id);
$images      = !empty($card_images) ? $card_images : ['https://via.placeholder.com/800x600'];
$img_count   = count($images);
?>
<style>
    a:hover{
        text-decoration: none !important;
    }
</style>
<div class="group relative">
    <!-- Carousel ПОЗА посиланням -->
    <div id="<?php echo $carousel_id; ?>" class="relative overflow-hidden carousel slide" data-ride="carousel" data-interval="false">
        <a href="<?php echo esc_url($card_url); ?>" class="block" data-prop="<?php echo esc_attr($card_id); ?>">
            <div class="carousel-inner">
                <?php foreach ($images as $i => $img) : ?>
                    <div class="carousel-item<?php echo $i === 0 ? ' active' : ''; ?>">
                        <div class="w-full aspect-[4/3] bg-cover bg-center bg-[#e9ede9]" style="background-image: url('<?php echo esc_url($img); ?>');"></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </a>
        <?php if ($img_count > 1) : ?>
            <span class="carousel-control-prev absolute left-2 !top-1/2 -translate-y-1/2 !w-8 !h-8 bg-white/85 rounded-full flex items-center justify-center cursor-pointer opacity-0 group-hover:opacity-100 transition z-[2] text-[#002C23] z-100" data-href="#<?php echo $carousel_id; ?>" data-slide="prev" onclick="event.stopPropagation();">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="#002C23" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </span>
            <span class="carousel-control-next absolute right-2 !top-1/2 -translate-y-1/2 !w-8 !h-8 bg-white/85 rounded-full flex items-center justify-center cursor-pointer opacity-0 group-hover:opacity-100 transition z-[2] text-[#002C23] z-100" data-href="#<?php echo $carousel_id; ?>" data-slide="next" onclick="event.stopPropagation();">
               <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="#002C23" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 6 15 12 9 18"/>
                </svg>
            </span>
        <?php endif; ?>
        <?php if (!empty($card_label)) : ?>
            <span class="absolute top-3 right-3 bg-[#092B23]/80 text-white font-helvetica rounded-[22px] text-[12px] tracking-widest py-1 px-3 uppercase z-[2]"><?php echo esc_html($card_label); ?></span>
        <?php endif; ?>
    </div>
            <!-- <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10"></div> -->
        <!-- Details -->
        <a href="<?php echo esc_url($card_url); ?>" class="block !hover:no-underline hover:!decoration-0 pt-4 absolute bottom-[30px] px-4 z-100">
            <div class="flex justify-between items-end">


                <div class="">
                    <div class="font-helvetica text-base font-medium text-[#E9EDE9] tracking-wide mb-1">
                        <span class="uppercase"><?php echo esc_html($card_title); ?></span>
                        <?php if (!empty($card_location)) : ?>
                            <span class="font-light text-[#E9EDE9]">in <?php echo esc_html($card_location); ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($card_price)) : ?>
                        <div class="font-['Noto_Serif_Display'] text-xl font-light text-[#E9EDE9]"><?php echo esc_html($card_price); ?></div>
                    <?php endif; ?>
                </div>
                <div class="font-helvetica text-sm text-[#E9EDE9] tracking-wide mb-1">
                    <?php
                    $meta = [];
                    if (!empty($card_beds))  $meta[] = esc_html($card_beds) . ' BD';
                    if (!empty($card_baths)) $meta[] = esc_html($card_baths) . ' BA';
                    if (!empty($card_size))  $meta[] = esc_html($card_size) . ' ' . esc_html($card_size_unit ?? 'm²');
                    if (!empty($card_plot)) {
                        $pv = is_numeric($card_plot) ? number_format((int)$card_plot) : $card_plot;
                        $meta[] = esc_html($pv) . ' P m²';
                    }
                    echo implode(' <span class="mx-1 text-[#E9EDE9]">|</span> ', $meta);
                    ?>
                </div>
            </div>
        </a>
    </a>
</div>
