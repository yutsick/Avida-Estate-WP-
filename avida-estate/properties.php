<?php
/*
Template Name: Properties
*/

/**
 * @package WordPress
 * @subpackage Resideo
 */

global $post;
get_header();

// Whitelist only the parameters you want to support
$filter_params = [
    'p_Min',
    'p_Max',
    'p_PropertyTypes',
    'p_Beds',
    'p_Location',
    'p_new_devs'
];

// Collect only these if present
$query_args = [];
foreach ($filter_params as $key) {
    if (isset($_GET[$key]) && $_GET[$key] !== '') {
        $query_args[$key] = sanitize_text_field($_GET[$key]);
    }
}

// Always include pagination (if you want)
$page = max(1, (int)get_query_var('paged'));
$query_args['p_PageNo'] = $page;

// -- API Data Fetch & Robust Parsing --
$api_url = home_url('/wp-json/resales/v1/properties/?' . http_build_query($query_args));
$response = wp_remote_get($api_url);
$base_url = get_permalink();

$api_error = '';
$properties = [];
$total_properties = 0;
$properties_per_page = 0;
$current_page = $page;
$total_pages = 1;
$from = 0;
$to = 0;

if (is_wp_error($response)) {
    $api_error = 'Could not fetch properties. Please try again later.';
} else {
    $response_body = wp_remote_retrieve_body($response);
    $data = json_decode($response_body, true);
    
    if (is_array($data) && isset($data['properties']) && is_array($data['properties']) && isset($data['query'])) {
        $properties = $data['properties'];
        $total_properties = intval($data['query']['PropertyCount']);
        $properties_per_page = intval($data['query']['PropertiesPerPage']);
        $current_page = intval($data['query']['CurrentPage']);
        $total_pages = ($properties_per_page > 0) ? (int) ceil($total_properties / $properties_per_page) : 1;
        $from = ($total_properties > 0) ? (($current_page - 1) * $properties_per_page + 1) : 0;
        $to   = ($total_properties > 0) ? min($from + $properties_per_page - 1, $total_properties) : 0;
    } else {
        $api_error = 'No properties found or there was a problem with the server response. Please try again.';
    }
}
?>

<div class="pxp-content">
    <div class="pxp-no-map">
        <div class="pxp-content-side-wrapper mt-100">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-7">
                        <h1 class="pxp-page-header"><?php echo get_the_title(); ?></h1>
                    </div>
                </div>
            </div>

            <!-- Filter form placeholder -->
            <div class="mt-4 mt-md-5">
                <div class="container">
                    <!-- Filter form would go here -->
                    <?php echo resales_property_filter_form(); ?>
                </div>
            </div>

            <div class="container">
                <div class="row pb-4">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <?php if ($api_error): ?>
                            <div class="alert alert-warning" role="alert">
                                <?php echo esc_html($api_error); ?>
                                <button onclick="location.reload();" class="pxp-save-search-btn">Try Again</button>
                            </div>
                        <?php else: ?>
                            <h2 class="pxp-content-side-h2">
                                <?php 
                                if ($total_properties > 0) {
                                    echo "{$from} - {$to} of {$total_properties} Results";
                                } else {
                                    echo "No Results";
                                }
                                ?>
                            </h2>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row pxp-results">
                    <?php
                    if (!$api_error) {
                        if (!empty($properties)) {
                            foreach ($properties as $p) {
                                $carousel_id = 'card-carousel-' . esc_attr($p['Reference']);
                                $pic_list = array();
                                if (!empty($p['Pictures']['Picture']) && is_array($p['Pictures']['Picture'])) {
                                    foreach ($p['Pictures']['Picture'] as $pic) {
                                        if (!empty($pic['PictureURL'])) {
                                            $pic_list[] = esc_url($pic['PictureURL']);
                                        }
                                    }
                                }
                                if (empty($pic_list) && !empty($p['MainImage'])) {
                                    $pic_list[] = esc_url($p['MainImage']);
                                }
                                if (empty($pic_list)) {
                                    $pic_list[] = 'https://via.placeholder.com/350x200';
                                }
                                $pic_count = count($pic_list);
                                $details_url = site_url('property/' . urlencode($p['Reference']));
                                ?>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <a href="<?php echo $details_url; ?>" class="pxp-results-card pxp-results-card-2" data-prop="<?php echo esc_attr($p['Reference']); ?>">
                                        <div id="<?php echo $carousel_id; ?>" class="carousel slide" data-ride="carousel" data-interval="false">
                                            <div class="carousel-inner rounded-lg">
                                                <?php foreach ($pic_list as $pi => $imgurl): ?>
                                                    <div class="carousel-item<?php if ($pi == 0) echo ' active'; ?>" style="background-image: url('<?php echo $imgurl; ?>');"></div>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php if ($pic_count > 1): ?>
                                                <span class="carousel-control-prev" data-href="#<?php echo $carousel_id; ?>" data-slide="prev">
                                                    <span class="fa fa-angle-left" aria-hidden="true"></span>
                                                </span>
                                                <span class="carousel-control-next" data-href="#<?php echo $carousel_id; ?>" data-slide="next">
                                                    <span class="fa fa-angle-right" aria-hidden="true"></span>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (isset($p['OwnProperty']) && $p['OwnProperty'] == "1") {?>
                                            <div class="pxp-results-card-2-featured-label">Exclusive</div>
                                        <?php }; ?>
                                        <div class="pxp-results-card-2-details">
                                            <div class="pxp-results-card-2-details-title">
                                                <?php if (!empty($p['PropertyType']['NameType'])): ?>
                                                <?php echo esc_html($p['PropertyType']['NameType']); ?>
                                                <?php endif; ?>
                                                <?php if (!empty($p['Location'])): ?>
                                                    (<?php echo esc_html($p['Location']); ?>)
                                                <?php endif; ?>
                                            </div>
                                            <div class="pxp-results-card-2-features">
                                                <span>
                                                    <?php
                                                    if (!empty($p['Bedrooms'])) {
                                                        echo esc_html($p['Bedrooms']) . ' BD<span> | </span>';
                                                    }
                                                    if (!empty($p['Bathrooms'])) {
                                                        echo esc_html($p['Bathrooms']) . ' BA';
                                                    }
                                                    if (!empty($p['Built'])) {
                                                        echo '<span> | </span>' . esc_html($p['Built']) . ' m²';
                                                    }
                                                    if (!empty($p['GardenPlot'])) {
                                                        echo '<span> | </span>';
                                                        if (is_numeric($p['GardenPlot'])) {
                                                            echo esc_html(number_format((int) $p['GardenPlot'])) . ' P m²';
                                                        } else {
                                                            echo esc_html($p['GardenPlot'])  . ' P m²';
                                                        }
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="pxp-results-card-2-details-price">
                                                <?php
                                                $price = !empty($p['Price']) ? number_format(floatval($p['Price'])) : 'N/A';
                                                $currency = !empty($p['Currency']) ? esc_html($p['Currency']) : '';
                                                echo '€' . $price;
                                                ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<p>No properties found on this page.</p>';
                            if (isset($data['transaction']) && isset($data['transaction']['status']) && $data['transaction']['status'] === 'error'): ?>
                                <div class="alert alert-danger col-sm-12 col-md-12 col-lg-12">
                                    <strong>There was an error with your request:</strong>
                                    <ul>
                                        <?php foreach ($data['transaction']['errordescription'] as $code => $msg): ?>
                                            <li>Error [<?php echo esc_html($code); ?>]: <?php echo esc_html($msg); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif;
                        }
                    }
                    ?>
                </div>
                <!-- Pagination UI -->
                <?php if (!$api_error) render_smart_pagination($current_page, $total_pages, $base_url); ?>
            </div>
        </div>
    </div>
</div>
                        
<?php  get_footer(); ?>