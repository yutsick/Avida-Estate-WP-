<?php
/**
 * Rental Properties Listing Block
 *
 * @package AvidaEstate
 */

$anchor = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';
$title  = get_field('rentals_title') ?: 'Rental Properties';

/* ── Settings ── */
$general_settings    = get_option('resideo_general_settings');
$appearance_settings = get_option('resideo_appearance_settings');
$fields_settings     = get_option('resideo_prop_fields_settings');

$p_price_enabled = isset($fields_settings['resideo_p_price_field']) ? $fields_settings['resideo_p_price_field'] : '';
$p_beds_enabled  = isset($fields_settings['resideo_p_beds_field']) ? $fields_settings['resideo_p_beds_field'] : '';

$currency            = isset($general_settings['resideo_currency_symbol_field']) ? $general_settings['resideo_currency_symbol_field'] : '';
$currency_pos        = isset($general_settings['resideo_currency_symbol_pos_field']) ? $general_settings['resideo_currency_symbol_pos_field'] : '';
$decimals            = isset($general_settings['resideo_decimals_field']) ? $general_settings['resideo_decimals_field'] : '';
$decimal_separator   = isset($general_settings['resideo_decimal_separator_field']) && $general_settings['resideo_decimal_separator_field'] != '' ? $general_settings['resideo_decimal_separator_field'] : '.';
$thousands_separator = isset($general_settings['resideo_thousands_separator_field']) && $general_settings['resideo_thousands_separator_field'] != '' ? $general_settings['resideo_thousands_separator_field'] : ',';
$unit                = isset($general_settings['resideo_unit_field']) ? $general_settings['resideo_unit_field'] : '';
$beds_label          = isset($general_settings['resideo_beds_label_field']) ? $general_settings['resideo_beds_label_field'] : 'BD';
$baths_label         = isset($general_settings['resideo_baths_label_field']) ? $general_settings['resideo_baths_label_field'] : 'BA';

/* ── Query ── */
$searched_posts = resideo_search_properties();
$total_p        = $searched_posts->found_posts;

$per_p   = isset($appearance_settings['resideo_properties_per_page_field']) && $appearance_settings['resideo_properties_per_page_field'] != '' ? intval($appearance_settings['resideo_properties_per_page_field']) : 10;
$page_no = get_query_var('paged') ? get_query_var('paged') : 1;
$from_p  = ($page_no == 1) ? 1 : $per_p * ($page_no - 1) + 1;
$to_p    = ($total_p - ($page_no - 1) * $per_p > $per_p) ? $per_p * $page_no : $total_p;

$sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'newest';

/* ── Current filter values ── */
$cur_type   = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';
$cur_beds   = isset($_GET['beds']) ? sanitize_text_field($_GET['beds']) : '';
$cur_max    = isset($_GET['max_price']) ? sanitize_text_field($_GET['max_price']) : '';
$cur_search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
$cur_status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';

/* ── Taxonomies ── */
$property_types    = get_terms(['taxonomy' => 'property_type', 'hide_empty' => true]);
$property_statuses = get_terms(['taxonomy' => 'property_status', 'hide_empty' => true]);
?>

<style>
       a:hover{
        text-decoration:  !important;
    }
.prop-select {
    appearance: none;
    -webkit-appearance: none;

    border-radius: 10px;
    background-color: white;
    padding: 1rem 30px 1rem 30px;
    font-family: var(--font-helvetica, "Helvetica Neue", sans-serif);
    font-size: 0.8rem;
    font-weight: 400;
    letter-spacing: 0.1em;
    color: #092B23;
    cursor: pointer;
    outline: none;
    width: 100%;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='7' fill='none'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23092B23' stroke-width='1.2'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.5rem center;
}

.prop-sort {
    appearance: none;
    -webkit-appearance: none;
    border: none;
    border-radius: 20px;
    background-color: #fff;
    padding: 15px 30px;
    font-family: var(--font-helvetica, "Helvetica Neue", sans-serif);
    font-size: 0.8rem;
    font-weight: 400;
    letter-spacing: 0.1em;
    color: #092B23;
    cursor: pointer;
    outline: none;
    width: auto;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='7' fill='none'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23092B23' stroke-width='1.2'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: center 30px ;
    padding-right: 60px;
}
button:focus {
  outline: none !important;
}
</style>

<section<?php echo $anchor; ?> class="pb-16 bg-[#E9EDE9]">
    <div class="max-w-[1400px] mx-auto px-6">

        <!-- ── FILTER ── -->
        <form method="get" action="<?php echo esc_url(get_permalink()); ?>">

            <!-- Mobile toggle -->
            <button type="button" class="w-full flex items-center gap-2 bg-[#f5f5f5] py-4 px-5 font-helvetica text-xs tracking-widest text-[#002C23] cursor-pointer md:hidden" onclick="this.nextElementSibling.classList.toggle('hidden'); this.nextElementSibling.classList.toggle('grid'); this.parentElement.querySelector('.rental-filter-row2').classList.toggle('hidden'); this.parentElement.querySelector('.rental-filter-row2').classList.toggle('flex');">
                <span class="fa fa-sliders"></span> FILTERS
            </button>

            <div class="grid grid-cols-1 md:grid-cols-4 hidden md:grid gap-6">
                <div>
                    <select name="status" class="prop-select w-full bg-[#f5f5f5] font-helvetica text-xs tracking-widest text-[#002C23] cursor-pointer py-4 px-5 outline-none ">
                        <option value="">ALL</option>
                        <?php if (!is_wp_error($property_statuses)) :
                            foreach ($property_statuses as $st) : ?>
                                <option value="<?php echo esc_attr($st->slug); ?>"<?php selected($cur_status, $st->slug); ?>><?php echo esc_html($st->name); ?></option>
                            <?php endforeach;
                        endif; ?>
                    </select>
                </div>
                <div>
                    <select name="type" class="prop-select w-full bg-[#f5f5f5] font-helvetica text-xs tracking-widest text-[#002C23] cursor-pointer py-4 px-5 outline-none  rounded-[10px]">
                        <option value="">TYPE</option>
                        <?php if (!is_wp_error($property_types)) :
                            foreach ($property_types as $pt) : ?>
                                <option value="<?php echo esc_attr($pt->slug); ?>"<?php selected($cur_type, $pt->slug); ?>><?php echo esc_html($pt->name); ?></option>
                            <?php endforeach;
                        endif; ?>
                    </select>
                </div>
                <div>
                    <select name="beds" class="prop-select w-full bg-[#f5f5f5] font-helvetica text-xs tracking-widest text-[#002C23] cursor-pointer py-4 px-5 outline-none ">
                        <option value="">BEDS</option>
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <option value="<?php echo $i; ?>"<?php selected($cur_beds, (string) $i); ?>><?php echo $i; ?>+</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div>
                    <select name="max_price" class="prop-select w-full bg-[#f5f5f5] font-helvetica text-xs tracking-widest text-[#002C23] cursor-pointer py-4 px-5 outline-none ">
                        <option value="">MAX PRICE</option>
                        <option value="1000"<?php selected($cur_max, '1000'); ?>>€1,000 /mo</option>
                        <option value="2000"<?php selected($cur_max, '2000'); ?>>€2,000 /mo</option>
                        <option value="3000"<?php selected($cur_max, '3000'); ?>>€3,000 /mo</option>
                        <option value="5000"<?php selected($cur_max, '5000'); ?>>€5,000 /mo</option>
                        <option value="10000"<?php selected($cur_max, '10000'); ?>>€10,000 /mo</option>
                        <option value="20000"<?php selected($cur_max, '20000'); ?>>€20,000 /mo</option>
                    </select>
                </div>
            </div>

            <!-- Row 2: Search + Button -->
            <div class="grid grid-cols-1 md:grid-cols-4 hidden md:grid gap-6 mt-6">
                <div class="md:col-span-3 flex items-center bg-[#ffffff] px-5 rounded-[10px]">
                    <input
                        type="text"
                        name="search"
                        value="<?php echo esc_attr($cur_search); ?>"
                        placeholder="SEARCH BY NEIGHBOURHOOD"
                        class="w-full bg-transparent font-helvetica text-xs tracking-widest text-[#002C23] py-3 outline-none  "
                    />
                </div>

                <div class=" md:col-span-1 flex items-stretch border-1 border-[#092B23] rounded-[10px] ">
                    <button type="submit" class="!focus:outline-none w-full    font-helvetica text-xs tracking-widest text-[#092B23] bg-transparent cursor-pointer transition ">
                        SEARCH
                    </button>
                </div>
            </div>
        </form>

        <!-- ── TOP BAR ── -->
        <div class="flex items-center justify-between py-6">
            <div class="font-helvetica text-xs tracking-wider text-[#002C23]">
                <?php if ($total_p > 0) : ?>
                    <?php echo esc_html($from_p) . ' - ' . esc_html($to_p) . ' OF ' . esc_html($total_p) . ' RESULTS'; ?>
                <?php else : ?>
                    NO RESULTS
                <?php endif; ?>
            </div>
            <div>
                <select class="prop-select w-full bg-[#f5f5f5] font-helvetica text-xs tracking-widest text-[#002C23] cursor-pointer з-3 outline-none  rounded-[10px]" onchange="var u=new URL(window.location);u.searchParams.set('sort',this.value);window.location=u;">
                    <option value="newest"<?php selected($sort, 'newest'); ?>>DEFAULT SORT</option>
                    <?php if ($p_price_enabled == 'enabled') : ?>
                        <option value="price_lo"<?php selected($sort, 'price_lo'); ?>>PRICE: LOW TO HIGH</option>
                        <option value="price_hi"<?php selected($sort, 'price_hi'); ?>>PRICE: HIGH TO LOW</option>
                    <?php endif; ?>
                    <?php if ($p_beds_enabled == 'enabled') : ?>
                        <option value="beds"<?php selected($sort, 'beds'); ?>>BEDS</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <!-- ── GRID ── -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <?php
            if ($searched_posts->have_posts()) {
                while ($searched_posts->have_posts()) {
                    $searched_posts->the_post();
                    $prop_id = get_the_ID();

                    // Normalize for shared card
                    $card_id    = $prop_id;
                    $card_url   = get_permalink($prop_id);
                    $card_title = get_the_title();
                    $card_location = '';
                    $card_beds  = get_post_meta($prop_id, 'property_beds', true);
                    $card_baths = get_post_meta($prop_id, 'property_baths', true);
                    $card_size  = get_post_meta($prop_id, 'property_size', true);
                    $card_size_unit = $unit;
                    $card_plot  = '';

                    $raw_price = get_post_meta($prop_id, 'property_price', true);
                    $p_price_label = get_post_meta($prop_id, 'property_price_label', true);
                    $card_price = '';
                    if (is_numeric($raw_price)) {
                        $formatted = ($decimals == '1')
                            ? number_format($raw_price, 2, $decimal_separator, $thousands_separator)
                            : number_format($raw_price, 0, $decimal_separator, $thousands_separator);
                        $card_price = ($currency_pos == 'before')
                            ? $currency . $formatted
                            : $formatted . $currency;
                        if ($p_price_label) $card_price .= ' ' . $p_price_label;
                    }

                    $p_featured = get_post_meta($prop_id, 'property_featured', true);
                    $card_label = ($p_featured == '1') ? 'Featured' : '';

                    $gallery = get_post_meta($prop_id, 'property_gallery', true);
                    $photos  = explode(',', $gallery);
                    $card_images = [];
                    if ($photos[0] != '') {
                        foreach ($photos as $photo_id) {
                            $img = wp_get_attachment_image_src($photo_id, 'pxp-gallery');
                            if ($img) $card_images[] = $img[0];
                        }
                    }

                    include get_template_directory() . '/template-parts/property-card.php';
                }
                wp_reset_postdata();
            } else {
                echo '<p class="text-center py-12 text-[#666]" style="grid-column:1/-1;">No rental properties found.</p>';
            }
            ?>
        </div>

        <!-- ── PAGINATION ── -->
        <?php resideo_pagination($searched_posts->max_num_pages); ?>
    </div>
</section>
