<?php
/**
 * Properties Listing Block
 *
 * @package AvidaEstate
 */

$anchor = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';
$title  = get_field('properties_title') ?: 'Properties';

/* ── Whitelist filter params ── */
$filter_params = ['p_Min', 'p_Max', 'p_PropertyTypes', 'p_Beds', 'p_Location', 'p_new_devs', 'p_SortBy'];
$query_args = [];
foreach ($filter_params as $key) {
    if (isset($_GET[$key]) && $_GET[$key] !== '') {
        $query_args[$key] = sanitize_text_field($_GET[$key]);
    }
}

$page = max(1, (int) get_query_var('paged'));
$query_args['p_PageNo'] = $page;

/* ── API fetch (direct function call) ── */
$request = new WP_REST_Request('GET', '/resales/v1/properties/');
foreach ($query_args as $k => $v) {
    $request->set_param($k, $v);
}
$api_result = get_resales_properties_api($request);
$base_url   = get_permalink();

$api_error        = '';
$properties       = [];
$total_properties = 0;
$per_page         = 0;
$current_page     = $page;
$total_pages      = 1;
$from = $to       = 0;

if (is_wp_error($api_result)) {
    $api_error = 'Could not fetch properties. Please try again later.';
} else {
    $data = ($api_result instanceof WP_REST_Response) ? $api_result->get_data() : (array) $api_result;

    if (is_array($data) && !empty($data['properties']) && !empty($data['query'])) {
        $properties       = $data['properties'];
        $total_properties = (int) $data['query']['PropertyCount'];
        $per_page         = (int) $data['query']['PropertiesPerPage'];
        $current_page     = (int) $data['query']['CurrentPage'];
        $total_pages      = $per_page > 0 ? (int) ceil($total_properties / $per_page) : 1;
        $from             = $total_properties > 0 ? ($current_page - 1) * $per_page + 1 : 0;
        $to               = $total_properties > 0 ? min($from + $per_page - 1, $total_properties) : 0;
    } else {
        $api_error = 'No properties found or there was a problem with the server response.';
    }
}

/* ── Current filter values ── */
$cur_loc  = $_GET['p_Location']      ?? '';
$cur_type = $_GET['p_PropertyTypes'] ?? '0';
$cur_beds = $_GET['p_Beds']          ?? '0';
$cur_min  = $_GET['p_Min']           ?? '';
$cur_max  = $_GET['p_Max']           ?? '';
$cur_new  = isset($_GET['p_new_devs']) && $_GET['p_new_devs'] === 'only';
$cur_sort = $_GET['p_SortBy']        ?? '';

$locations = [
    "Aloha","Altos de los Monteros","Atalaya","Bahía de Marbella","Bailen Miraflores",
    "Bel Air","Benahavís","Benalmadena","Benalmadena Costa","Benavista","Cabopino","Calahonda",
    "Calanova Golf","Calypso","Campo Mijas","Cancelada","El Madroñal","El Padron","El Paraiso",
    "El Faro","El Rosario","Estepona","Elviria","Guadalmina Alta","Guadalmina Baja","Istán",
    "La Cala de Mijas","La Cala Golf","La Atalaya","La Cala","La Cala Hills","La Quinta",
    "La Zagaleta","Las Brisas","Las Chapas","Las Lagunas","Los Flamingos","Los Monteros",
    "Marbella","Marbesa","Mijas","Mijas Costa","Mijas Golf","Nagüeles","New Golden Mile",
    "Nueva Andalucía","Puerto Banús","Puerto de Cabopino","Reserva de Marbella","Río Real",
    "Riviera del Sol","San Pedro de Alcántara","Selwo","Sierra Blanca","Sotogrande",
    "Sotogrande Alto","Sotogrande Costa","Sotogrande Marina","Sotogrande Playa","The Golden Mile"
];

$types = [
    '0'   => 'All',
    '1-1' => 'Apartment',
    '1-2' => 'Ground Floor Apartment',
    '1-4' => 'Middle Floor Apartment',
    '1-5' => 'Top Floor Apartment',
    '1-6' => 'Penthouse',
    '1-8' => 'Duplex',
    '2-2' => 'Detached Villa',
    '2-4' => 'Semi-Detached House',
    '2-5' => 'Townhouse',
];
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
    <div class="max-w-[1400px] mx-auto px-6 pt-8">

        <!-- ── FILTER ── -->
        <form class="prop-filter" method="get" action="<?php echo esc_url(get_permalink()); ?>">

            <!-- Mobile toggle -->
            <!-- <button type="button" class="prop-filter__toggle w-full flex items-center gap-2 bg-[#f5f5f5] py-4 px-5 font-helvetica text-xs tracking-widest text-[#002C23] cursor-pointer md:hidden" onclick="this.nextElementSibling.classList.toggle('hidden'); this.nextElementSibling.classList.toggle('grid');">
                <span class="fa fa-sliders"></span> FILTERS
            </button> -->

            <div class="grid grid-cols-1 md:grid-cols-3 hidden md:grid gap-6">
                <!-- Row 1 -->
                <div class="prop-filter__field">
                    <select name="p_Location" class="prop-select">
                        <option value="">NEIGHBORHOOD</option>
                        <?php foreach ($locations as $loc) : ?>
                            <option value="<?php echo esc_attr($loc); ?>"<?php selected($cur_loc, $loc); ?>><?php echo esc_html($loc); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="prop-filter__field">
                    <select name="p_PropertyTypes" class="prop-select">
                        <?php foreach ($types as $val => $label) : ?>
                            <option value="<?php echo esc_attr($val); ?>"<?php selected($cur_type, $val); ?>>
                                <?php echo $val === '0' ? 'TYPE' : esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="prop-filter__field">
                    <select name="p_Beds" class="prop-select">
                        <option value="0"<?php selected($cur_beds, '0'); ?>>BEDS</option>
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <option value="<?php echo $i; ?>"<?php selected($cur_beds, (string) $i); ?>><?php echo $i; ?>+</option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- Row 2 -->
                <div class="prop-filter__field">
                    <select name="p_Min" class="prop-select">
                        <option value=""<?php selected($cur_min, ''); ?>>MIN PRICE</option>
                        <option value="100000"<?php selected($cur_min, '100000'); ?>>€100,000</option>
                        <option value="200000"<?php selected($cur_min, '200000'); ?>>€200,000</option>
                        <option value="500000"<?php selected($cur_min, '500000'); ?>>€500,000</option>
                        <option value="1000000"<?php selected($cur_min, '1000000'); ?>>€1,000,000</option>
                        <option value="2000000"<?php selected($cur_min, '2000000'); ?>>€2,000,000</option>
                        <option value="5000000"<?php selected($cur_min, '5000000'); ?>>€5,000,000</option>
                    </select>
                </div>
                <div class="prop-filter__field">
                    <select name="p_Max" class="prop-select">
                        <option value=""<?php selected($cur_max, ''); ?>>MAX PRICE</option>
                        <option value="300000"<?php selected($cur_max, '300000'); ?>>€300,000</option>
                        <option value="600000"<?php selected($cur_max, '600000'); ?>>€600,000</option>
                        <option value="1000000"<?php selected($cur_max, '1000000'); ?>>€1,000,000</option>
                        <option value="5000000"<?php selected($cur_max, '5000000'); ?>>€5,000,000</option>
                        <option value="10000000"<?php selected($cur_max, '10000000'); ?>>€10,000,000</option>
                    </select>
                </div>
                <div class="flex items-stretch border-1 border-[#092B23] rounded-[10px]">
                    <button type="submit" class="!focus:outline-none !focus:ring-0 w-full    font-helvetica text-xs tracking-widest text-[#092B23] bg-transparent cursor-pointer transition ">
                        SEARCH
                    </button>
                </div>
            </div>

            <!-- New dev checkbox -->
            <!-- <div class="hidden md:block bg-[#f5f5f5] border-b border-[#e0e0e0] py-3 px-5">
                <label class="inline-flex items-center gap-2 font-helvetica text-xs tracking-wider text-[#002C23] cursor-pointer">
                    <input type="checkbox" name="p_new_devs" value="only"<?php checked($cur_new); ?> class="w-4 h-4">
                    <span>New Development</span>
                </label>
            </div> -->
        </form>

        <!-- ── TOP BAR ── -->
        <?php if (!$api_error) : ?>
        <div class="flex items-center justify-between py-6">
            <div class="font-helvetica text-xs tracking-wider text-[#002C23]">
                <?php if ($total_properties > 0) : ?>
                    <?php echo "{$from} - {$to} OF {$total_properties} RESULTS"; ?>
                <?php else : ?>
                    NO RESULTS
                <?php endif; ?>
            </div>
            <div>
                <select class="prop-sort" onchange="var u=new URL(window.location);u.searchParams.set('p_SortBy',this.value);window.location=u;">
                    <option value=""<?php selected($cur_sort, ''); ?>>DEFAULT SORT</option>
                    <option value="price-asc"<?php selected($cur_sort, 'price-asc'); ?>>PRICE: LOW TO HIGH</option>
                    <option value="price-desc"<?php selected($cur_sort, 'price-desc'); ?>>PRICE: HIGH TO LOW</option>
                    <option value="date-desc"<?php selected($cur_sort, 'date-desc'); ?>>NEWEST FIRST</option>
                </select>
            </div>
        </div>
        <?php endif; ?>

        <!-- ── ERROR ── -->
        <?php if ($api_error) : ?>
            <div class="text-center py-12">
                <p class="text-[#666] mb-4"><?php echo esc_html($api_error); ?></p>
                <button onclick="location.reload();" class="border border-[#002C23] rounded-full py-2 px-8 text-xs tracking-wider text-[#002C23] bg-transparent cursor-pointer">Try Again</button>
            </div>
        <?php endif; ?>

        <!-- ── GRID ── -->
        <?php if (!$api_error) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <?php
            if (!empty($properties)) {
                foreach ($properties as $p) {
                    // Normalize for shared card
                    $card_id    = $p['Reference'];
                    $card_url   = site_url('property/' . urlencode($p['Reference']));
                    $card_title = $p['PropertyType']['NameType'] ?? '';
                    $card_location = $p['Location'] ?? '';
                    $card_beds  = $p['Bedrooms'] ?? '';
                    $card_baths = $p['Bathrooms'] ?? '';
                    $card_size  = $p['Built'] ?? '';
                    $card_size_unit = 'm²';
                    $card_plot  = $p['GardenPlot'] ?? '';
                    $card_price = !empty($p['Price']) ? '€' . number_format(floatval($p['Price'])) : '';
                    $card_label = (isset($p['OwnProperty']) && $p['OwnProperty'] == '1') ? 'Exclusive' : '';

                    $card_images = [];
                    if (!empty($p['Pictures']['Picture']) && is_array($p['Pictures']['Picture'])) {
                        foreach ($p['Pictures']['Picture'] as $pic) {
                            if (!empty($pic['PictureURL'])) $card_images[] = $pic['PictureURL'];
                        }
                    }
                    if (empty($card_images) && !empty($p['MainImage'])) $card_images[] = $p['MainImage'];

                    include get_template_directory() . '/template-parts/property-card.php';
                }
            } else {
                echo '<p class="text-center py-12 text-[#666]" style="grid-column:1/-1;">No properties found.</p>';
                if (isset($data['transaction']['status']) && $data['transaction']['status'] === 'error') {
                    echo '<div class="bg-red-50 border border-red-200 p-4 rounded-lg text-sm" style="grid-column:1/-1;"><strong>Error:</strong><ul>';
                    foreach ($data['transaction']['errordescription'] as $code => $msg) {
                        echo '<li>[' . esc_html($code) . '] ' . esc_html($msg) . '</li>';
                    }
                    echo '</ul></div>';
                }
            }
            ?>
        </div>
        <?php endif; ?>

        <!-- ── PAGINATION ── -->
        <?php if (!$api_error) render_smart_pagination($current_page, $total_pages, $base_url); ?>
    </div>
</section>
