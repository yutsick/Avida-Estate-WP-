<?php
global $post;


// 1. Get the reference from query vars
$ref = get_query_var('property_ref');

if (!$ref) {
    get_header();
    echo '<div class="container"><div class="alert alert-danger mt-5">No property reference found in the URL.</div></div>';
    get_footer();
    exit;
}

// 2. Build API endpoint for detail
$api_url = home_url('/wp-json/resales/v1/property-detail/?P_RefId=' . urlencode($ref));

// 3. Fetch property data
$response = wp_remote_get($api_url, array('timeout' => 10));
if (is_wp_error($response)) {
    get_header();
    echo '<div class="container"><div class="alert alert-danger mt-5">Could not fetch property detail. Please try again.</div></div>';
    get_footer();
    exit;
}

$body = wp_remote_retrieve_body($response);
$data = json_decode($body, true);

$property = isset($data['property']) ? $data['property'] : null;

if ($property) $GLOBALS['current_property_data'] = $property;

if (!$property) {
    get_header();
    echo '<div class="container"><div class="alert alert-warning mt-5">Property not found.</div></div>';
    get_footer();
    exit;
}

get_header();

// 4. Display property info
?>

<div class="pxp-content">
    <!-- Top Title Section -->
    <div class="pxp-single-property-top pxp-content-wrapper mt-100">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <h1 class="pxp-sp-top-title"><?php echo esc_html($property['PropertyType']['NameType']); ?> in <?php echo esc_html($property['Location']); ?></h1>
                </div>
                <div class="col-sm-12 col-md-7">
                            <div class="pxp-sp-top-btns mt-2 mt-md-0">
                                <?php
                                // Safely get the property title
                                $propertyTitle = isset($property['PropertyType']['NameType']) ? $property['PropertyType']['NameType'] : '';
                                $propertyTitleUrlEncoded = urlencode($propertyTitle);

                                // Build the property URL using WordPress's home_url()
                                $propertyUrl = home_url('/property/' . urlencode($property['Reference']) . '/');
                                $propertyUrlEncoded = urlencode($propertyUrl);
                                // WhatsApp text includes both title and link, double URL-encode for best compatibility
                                $whatsAppText = $propertyUrl;
                                ?>
                                <div class="dropdown">                                    
                                    <a class="pxp-sp-top-btn" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="fa fa-share-alt"></span> Share
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="https://wa.me/?text=<?= $whatsAppText ?>" target="_blank">
                                            <span class="fa fa-whatsapp"></span> WhatsApp
                                        </a>
                                        <?php $subject = rawurlencode('Check out this property: ' . $propertyTitle); $body = rawurlencode( "I thought you might be interested in this property:\n\n" . $propertyTitle . "\n" . $propertyUrl ); $href = 'mailto:?subject=' . $subject . '&body=' . $body; ?>
                <a class="dropdown-item" href="<?php echo esc_attr($href); ?>"><span class="fa fa-envelope"></span> Email</a>
                                        <a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u=<?= $propertyUrlEncoded ?>" onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank">
                                            <span class="fa fa-facebook"></span> Facebook
                                        </a>
                                        <a class="dropdown-item" href="https://twitter.com/share?url=<?= $propertyUrlEncoded ?>&amp;text=<?= $propertyTitleUrlEncoded ?>" onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank">
                                            <span class="fa fa-twitter"></span> Twitter
                                        </a>
                                        <a class="dropdown-item" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?= $propertyUrlEncoded ?>&amp;title=<?= $propertyTitleUrlEncoded ?>" target="_blank">
                                            <span class="fa fa-linkedin"></span> LinkedIn
                                        </a>
                                    </div>
                                </div>
                            </div>
                    <div class="clearfix d-block d-xl-none"></div>
                    <div class="pxp-sp-top-feat mt-3 mt-md-0">
                        <div><?php echo esc_html($property['Bedrooms']); ?> <span>BD</span></div>
                        <div><?php echo esc_html($property['Bathrooms']); ?> <span>BA</span></div>
                        <div><?php echo esc_html($property['Built']); ?> <span>m²</span></div>
                        <?php
                        if (!empty($property['GardenPlot'])) {
                            echo '<div>';
                            if (is_numeric($property['GardenPlot'])) {
                                echo esc_html(number_format((int) $property['GardenPlot'])) . ' <span>P m²</span>';
                            } else {
                                echo esc_html($property['GardenPlot']);
                            }
                            echo '</div>';
                        }
                        ?> 
                    </div>
                    <div class="pxp-sp-top-price mt-3 mt-md-0">
                        €<?php echo number_format(floatval($property['Price'])) ; ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Section (5 Placeholders) -->
    <div class="pxp-single-property-gallery-container mt-4 mt-md-5">
        <div class="pxp-single-property-gallery main-gallery" itemscope itemtype="http://schema.org/ImageGallery" data-pswp-uid="1">
        <?php
        if (!empty($property['Pictures']['Picture']) && is_array($property['Pictures']['Picture'])) {
            foreach ($property['Pictures']['Picture'] as $i => $pic) {
                // Full size
                $img_url = esc_url($pic['PictureURL']);
                // Thumbnail or same as full size if not available
                $thumb_url = esc_url($pic['PictureURL']); // Use your actual thumbnail if available

                // Class logic
                $class = '';
                if ($i === 0) $class = 'pxp-is-half ';    // First is half
                elseif ($i > 4) $class = ' d-none';      // After 5th is hidden
                // Second to fifth get no extra class

                // data-size example: image size (change as needed)
                $data_size = '1200x800'; // Or pull from your data if available

                ?>
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="<?php echo esc_attr($class); ?>">
                    <a href="<?php echo $img_url; ?>"
                       itemprop="contentUrl"
                       data-size="<?php echo esc_attr($data_size); ?>"
                       class="pxp-cover"
                       style="background-image: url('<?php echo $thumb_url; ?>');"></a>
                    <figcaption itemprop="caption description"></figcaption>
                </figure>
                <?php
            }
        }
        ?>
        </div>
        <a href="javascript:void(0);" class="pxp-sp-gallery-btn">View Photos</a>
        <div class="clearfix"></div>
    </div>
<div class="container mt-100">
    <div class="row">
        <div class="col-lg-8">
            <div class="pxp-single-property-section">
                <h3>Key Details</h3>
                <div class="row mt-3 mt-md-4">
                <?php  
                    $details = [
                        'Reference' => 'Reference',
                        'Community_Fees_Year' => 'Community Fees / Year',
                        'Basura_Tax_Year' => 'Waste Tax / Year',  // << English
                        'IBI_Fees_Year' => 'IBI Fees / Year',
                        'Terrace' => 'Terrace',
                        'BuiltYear' => 'Build Year',
                    ];

                    $currencyFields = [
                        'Community_Fees_Year',
                        'Basura_Tax_Year',
                        'IBI_Fees_Year',
                    ];

                    foreach ($details as $key => $label) {
                        if (!empty($property[$key]) && $property[$key] != 0 && $property[$key] != 'Unknown') {
                            $value = (in_array($key, $currencyFields) ? '€' : '') . htmlspecialchars($property[$key]);
                            if ($label=='Terrace') $value = $value . ' m²';
                            ?>
                            <div class="col-sm-6" style="width: 50%;">
                                <div class="pxp-sp-key-details-item">
                                    <div class="pxp-sp-kd-item-label text-uppercase"><?= htmlspecialchars($label) ?></div>
                                    <div class="pxp-sp-kd-item-value"><?= $value ?></div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>
                </div>
            </div>
            <div class="pxp-single-property-section mt-4 mt-md-5">
                <h3>Overview</h3>
                <div class="mt-3 mt-md-4">
                    <?php
                        if (!empty($property['Description'])) {
                            $desc = trim($property['Description']);

                            // Split text into sentences after . ! or ? followed by a space or line end
                            $sentences = preg_split('/(?<=[.?!])\s+/', $desc, -1, PREG_SPLIT_NO_EMPTY);

                            // Wrap each non-empty sentence in <p>...</p>, escaping the content
                            $output = '';
                            foreach ($sentences as $sentence) {
                                $sentence = trim($sentence);
                                if (!empty($sentence)) {
                                    $output .= '<p>' . esc_html($sentence) . '</p>';
                                }
                            }

                            echo $output;
                        } else {
                            echo "<em>No description available.</em>";
                        }
                        ?>
                </div>
            </div>
            <div class="pxp-single-property-section mt-4 mt-md-5">
                <h3>Amenities</h3>
                <div class="row mt-3 mt-md-4">
                    <?php
$typeIcons = [
    'Climate Control'   => 'fa-snowflake-o',
    'Pool'              => 'fa-tint',
    'Features'          => 'fa-star',
    'Furniture'         => 'fa-bed',
    'Garden'            => 'fa-leaf',
    'Security'          => 'fa-shield',
    'Parking'           => 'fa-car',
    'Views'             => 'fa-eye',
    'Condition'         => 'fa-check-square-o',
    'Setting'           => 'fa-map-marker',
    'Kitchen'           => 'fa-cutlery', // Or 'fa-utensils'
    'Orientation'       => 'fa-compass',
    // ...
];

// Step 1: Separate out 'Features' and filter out 'Category' and 'Utility'
$featuresCategory = null;
$outputCategories = [];

if (!empty($property['PropertyFeatures']['Category'])) {
    foreach ($property['PropertyFeatures']['Category'] as $category) {
        if (empty($category['Type']) || empty($category['Value']) || !is_array($category['Value'])) continue;
        if ($category['Type'] === 'Category' || $category['Type'] === 'Utilities') continue;

        if ($category['Type'] === 'Features') {
            $featuresCategory = $category;
        } else {
            $outputCategories[] = $category;
        }
    }
}

// Step 2: Output non-features categories
foreach ($outputCategories as $category):
    $type = $category['Type'];
    $iconClass = isset($typeIcons[$type]) ? $typeIcons[$type] : 'fa-check';
    $features  = array_filter(array_map('trim', $category['Value']));
    if (empty($features)) continue;
?>
    <div class="col-sm-6">
        <div class="pxp-sp-key-details-item">
            <div style="font-size: 0.8rem;"  class="pxp-sp-kd-item-label text-uppercase">
                <span class="fa <?= $iconClass ?>"></span>
                <?= htmlspecialchars($type) ?>
            </div>
            <div class="pxp-sp-kd-item-value">
                <?= htmlspecialchars(implode(', ', $features)) ?>
            </div>
        </div>
    </div>
<?php
endforeach;

// Step 3: Output 'Features' category LAST, if it exists
if ($featuresCategory) {
    $type = $featuresCategory['Type'];
    $iconClass = isset($typeIcons[$type]) ? $typeIcons[$type] : 'fa-check';
    $features  = array_filter(array_map('trim', $featuresCategory['Value']));
    if (!empty($features)):
?>
    <div class="col-sm-6">
        <div class="pxp-sp-key-details-item">
            <div class="pxp-sp-kd-item-label text-uppercase">
                <span class="fa <?= $iconClass ?>"></span>
                <?= htmlspecialchars($type) ?>
            </div>
            <div class="pxp-sp-kd-item-value">
                <?= htmlspecialchars(implode(', ', $features)) ?>
            </div>
        </div>
    </div>
<?php
    endif;
}
?>
             
                    
                </div>
            </div>
        </div>
                <div class="col-lg-4">
                    <?php 
                        $ids = get_posts([
                            'post_type'      => 'agent',
                            'fields'         => 'ids',
                            'numberposts'    => -1
                        ]);
                        $agent_id = $ids ? $ids[array_rand($ids)] : 0; 
                        $agent    = ($agent_id != '') ? get_post($agent_id) : ''; 
                        if ($agent_id != '') { 
                        $agent_avatar       = get_post_meta($agent_id, 'agent_avatar', true);
                        $agent_avatar_photo = wp_get_attachment_image_src($agent_avatar, 'pxp-thmb');

                        if ($agent_avatar_photo != '') {
                            $a_photo = $agent_avatar_photo[0];
                        } else {
                            $a_photo = RESIDEO_LOCATION . '/images/avatar-default.png';
                        }

                        $show_rating = isset($general_settings['resideo_agents_rating_field']) ? $general_settings['resideo_agents_rating_field'] : '';
                        $hide_phone = isset($appearance_settings['resideo_hide_agents_phone_field']) ? $appearance_settings['resideo_hide_agents_phone_field'] : '';
                        $options = get_option('resideo_general_settings'); 
                        $agent_email = $options['resideo_avidaemail_field'];
                        $agent_phone = $options['resideo_avidaphone_field']; ?>

                        <div class="pxp-single-property-section pxp-sp-agent-section mt-4 mt-md-5 mt-lg-0">
                            <h3><?php esc_html_e('Listed By', 'resideo'); ?></h3>
                            <div class="pxp-sp-agent mt-3 mt-md-4">
                                <span class="pxp-sp-agent-fig pxp-cover rounded-lg" style="background-image: url(<?php echo esc_attr($a_photo); ?>);"></span>
                                <div class="pxp-sp-agent-info">
                                    <div class="pxp-sp-agent-info-name"><?php echo esc_html($agent->post_title); ?></div>
                                    <?php
                                    if ($agent_email != '') { ?>
                                        <div class="pxp-sp-agent-info-email"><a href="mailto:<?php echo esc_attr($agent_email); ?>"><?php echo esc_html($agent_email); ?></a></div>
                                    <?php } ?>

                                        <div class="pxp-sp-agent-info-phone"><span class="fa fa-phone"></span><a class="pxp-sp-agent-phone-link" href="tel:<?php echo esc_html($agent_phone); ?>"><?php echo esc_html($agent_phone); ?></a> </div>
                                </div>
                                <div class="clearfix"></div>
                                <?php if (function_exists('resideo_get_contact_agent_modal')) {
                                    $modal_info                   = array();
                                    $modal_info['link']           = $propertyUrl;
                                    $modal_info['title']          = urlencode($property['Reference']);
                                    $modal_info['agent_email']    = $agent_email;
                                    $modal_info['agent_id']       = $agent_id;
                                    $modal_info['agent']          = $agent->post_title;
                                    $modal_info['user_id']        = '';
                                    $modal_info['user_email']     = '';
                                    $modal_info['user_firstname'] = '';
                                    $modal_info['user_lastname']  = '';

                                    $cta_is_sticky = isset($appearance_settings['resideo_sticky_agent_cta_field']) ? $appearance_settings['resideo_sticky_agent_cta_field'] : false;
                                    $cta_sticky_class = $cta_is_sticky == '1' ? 'pxp-is-sticky' : ''; ?>

                                    <div class="pxp-sp-agent-btns mt-3 mt-md-4">
                                        <a style="width: 47%; margin-right:3%;" href="#pxp-contact-agent" class="pxp-sp-agent-btn-main <?php echo esc_attr($cta_sticky_class); ?>" data-toggle="modal" data-target="#pxp-contact-agent"><span class="fa fa-envelope-o"></span><?php esc_html_e('Contact', 'resideo'); ?></a>
                                        <?php
                                        $phone = preg_replace('/\D/', '', $agent_phone);
                                        $message = urlencode("Hello! I'm interested in the property listed here: $propertyUrl Could you please provide more details?");
                                        $whatsappLink = "https://wa.me/$phone?text=$message";
                                        ?>
                                        <a style="width: 47%;" href="<?php echo $whatsappLink; ?>" target="_blank" rel="noopener" class="pxp-sp-agent-btn-main <?php echo esc_attr($cta_sticky_class); ?>"><span class="fa fa-whatsapp"></span><?php esc_html_e('WhatsApp', 'resideo'); ?></a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
    </div>
</div>

    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="pswp__bg"></div>
        <div class="pswp__scroll-wrap">
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <div class="pswp__counter"></div>
                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div> 
                </div>
                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($modal_info)) { 
        resideo_get_contact_agent_modal($modal_info);
    }

    if (isset($report_modal_info)) {
        resideo_get_report_property_modal($report_modal_info);
    }?>
</div>

<?php get_footer(); ?>