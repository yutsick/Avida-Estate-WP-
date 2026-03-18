<?php
/**
 * @package WordPress
 * @subpackage Resideo
 */

if (!defined('RESIDEO_LOCATION')) {
    define('RESIDEO_LOCATION', get_template_directory_uri());
}

/**
 * Register required plugins
 */
require_once 'libs/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'resideo_register_required_plugins');

if(!function_exists('resideo_register_required_plugins')): 
    function resideo_register_required_plugins() {
        $plugins = array(
            array(
                'name'         => 'Avida Plugin',
                'slug'         => 'avida-plugin',
                'source'       => 'https://newdigital.media/plugins/avida-plugin.zip',
                'required'     => true,
                'version'      => '2.5.4',
                'external_url' => ''
            ),
        );

        $config = array(
            'id'           => 'resideo',
            'default_path' => '',
            'menu'         => 'tgmpa-install-plugins',
            'has_notices'  => true,
            'dismissable'  => false,
            'dismiss_msg'  => '',
            'is_automatic' => false,
            'message'      => '',

            'strings'      => array(
                'page_title'                      => esc_html__('Install Required Plugins', 'resideo'),
                'menu_title'                      => esc_html__('Install Plugins', 'resideo'),
                'installing'                      => esc_html__('Installing Plugin: %s', 'resideo'),
                'updating'                        => esc_html__('Updating Plugin: %s', 'resideo'),
                'oops'                            => esc_html__('Something went wrong with the plugin API.', 'resideo'),
                'notice_can_install_required'     => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'resideo'),
                'notice_can_install_recommended'  => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'resideo'),
                'notice_ask_to_update'            => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'resideo'),
                'notice_ask_to_update_maybe'      => _n_noop('There is an update available for: %1$s.', 'There are updates available for the following plugins: %1$s.', 'resideo'),
                'notice_can_activate_required'    => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'resideo'),
                'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'resideo'),
                'install_link'                    => _n_noop('Begin installing plugin', 'Begin installing plugins', 'resideo'),
                'update_link'                     => _n_noop('Begin updating plugin', 'Begin updating plugins', 'resideo'),
                'activate_link'                   => _n_noop('Begin activating plugin', 'Begin activating plugins', 'resideo'),
                'return'                          => esc_html__('Return to Required Plugins Installer', 'resideo'),
                'plugin_activated'                => esc_html__('Plugin activated successfully.', 'resideo'),
                'activated_successfully'          => esc_html__('The following plugin was activated successfully:', 'resideo'),
                'plugin_already_active'           => esc_html__('No action taken. Plugin %1$s was already active.', 'resideo'),
                'plugin_needs_higher_version'     => esc_html__('Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'resideo'),
                'complete'                        => esc_html__('All plugins installed and activated successfully. %1$s', 'resideo'),
                'dismiss'                         => esc_html__('Dismiss this notice', 'resideo'),
                'notice_cannot_install_activate'  => esc_html__('There are one or more required or recommended plugins to install, update or activate.', 'resideo'),
                'contact_admin'                   => esc_html__('Please contact the administrator of this site for help.', 'resideo'),
                'nag_type'                        => 'updated',
            ),
        );

        tgmpa($plugins, $config);
    }
endif;

/**
 * Theme setup
 */
if (!function_exists('resideo_setup')):
    function resideo_setup() {
        if (function_exists('add_theme_support')) {
            add_theme_support('automatic-feed-links');
            add_theme_support('title-tag');
            add_theme_support('post-thumbnails');
            add_theme_support('custom-logo');
            add_theme_support('html5', array('style', 'script'));
            add_theme_support('responsive-embeds');
        }

        set_post_thumbnail_size(800, 600, true);
        add_image_size('pxp-thmb', 160, 160, true);
        add_image_size('pxp-icon', 200, 200, true);
        add_image_size('pxp-gallery', 800, 600, true);
        add_image_size('pxp-agent', 800, 800, true);
        add_image_size('pxp-full', 1920, 1280, true);

        if (!isset($content_width)) {
            $content_width = 1140;
        }

        register_nav_menus(array(
            'primary' => esc_html__('Top primary menu', 'resideo'),
            'primary_2' => esc_html__('Top primary Second menu', 'resideo'),
            'offcanvas' => esc_html__('Primary mobile menu', 'resideo'),
        ));
    }
endif;
add_action('after_setup_theme', 'resideo_setup');

function resideo_load_theme_textdomain() {
    load_theme_textdomain('resideo', RESIDEO_LOCATION . '/languages/');
}
add_action('init', 'resideo_load_theme_textdomain');

/**
 * Load scripts
 */
if (!function_exists('resideo_load_scripts')): 
    function resideo_load_scripts() {
        global $paged;
        global $post;

        wp_enqueue_style('jquery-ui', RESIDEO_LOCATION . '/css/jquery-ui.css', array(), '1.11.0', 'all'); 
        wp_enqueue_style('fileinput', RESIDEO_LOCATION . '/css/fileinput.min.css', array(), '4.0', 'all'); 
        wp_enqueue_style('base-font', 'https://fonts.googleapis.com/css?family=Roboto:400,700,900', array(), '1.0', 'all');
        wp_enqueue_style('font-awesome', RESIDEO_LOCATION . '/css/font-awesome.min.css', array(), '4.7.0', 'all');
        wp_enqueue_style('bootstrap', RESIDEO_LOCATION . '/css/bootstrap.min.css', array(), '4.3.1', 'all');
        wp_enqueue_style('datepicker', RESIDEO_LOCATION . '/css/datepicker.css', array(), '1.0', 'all');
        wp_enqueue_style('owl-carousel', RESIDEO_LOCATION . '/css/owl.carousel.min.css', array(), '2.3.4', 'all');
        wp_enqueue_style('owl-theme', RESIDEO_LOCATION . '/css/owl.theme.default.min.css', array(), '2.3.4', 'all');
        wp_enqueue_style('photoswipe', RESIDEO_LOCATION . '/css/photoswipe.css', array(), '4.1.3', 'all');
        wp_enqueue_style('photoswipe-skin', RESIDEO_LOCATION . '/css/default-skin/default-skin.css', array(), '4.1.3', 'all');
        wp_enqueue_style('resideo-style', get_stylesheet_uri(), array(), '1.0', 'all');
        wp_enqueue_style('theme-override-style', get_template_directory_uri() . '/css/override.css');

        // RTL styles
        wp_style_add_data('resideo-style', 'rtl', 'replace');

        // Include dsIDXpress IDX Style only if plugin is active
        if (function_exists('dsidxpress_InitWidgets')) {
            wp_enqueue_style('resideo-dsidx', RESIDEO_LOCATION . '/css/idx.css', array(), '1.0', 'all');
        }

        wp_deregister_style('common');
        wp_deregister_style('forms');

        include_once(ABSPATH . 'wp-admin/includes/plugin.php');

        wp_enqueue_script('jquery-ui', RESIDEO_LOCATION . '/js/jquery-ui.min.js', array('jquery'), '1.11.4', true);
        wp_enqueue_script('popper', RESIDEO_LOCATION . '/js/popper.min.js', array('jquery'), '1.0', true);
        wp_enqueue_script('bootstrap', RESIDEO_LOCATION . '/js/bootstrap.min.js', array('jquery'), '4.3.1', true);
        wp_enqueue_script('markerclusterer',    RESIDEO_LOCATION . '/js/markerclusterer.js', array(), '2.0.8', true);
        wp_enqueue_script('datepicker', RESIDEO_LOCATION . '/js/bootstrap-datepicker.js', array(), '1.0', true);
        wp_enqueue_script('numeral', RESIDEO_LOCATION . '/js/numeral.min.js', array(), '2.0.6', true);

        $resideo_gmaps_settings = get_option('resideo_gmaps_settings', '');
        $gmaps_key              = isset($resideo_gmaps_settings['resideo_gmaps_key_field']) ? $resideo_gmaps_settings['resideo_gmaps_key_field'] : '';
        $gmaps_lat              = isset($resideo_gmaps_settings['resideo_gmaps_lat_field']) ? $resideo_gmaps_settings['resideo_gmaps_lat_field'] : 0;
        $gmaps_lng              = isset($resideo_gmaps_settings['resideo_gmaps_lng_field']) ? $resideo_gmaps_settings['resideo_gmaps_lng_field'] : 0;
        $gmaps_zoom             = isset($resideo_gmaps_settings['resideo_gmaps_zoom_field']) ? $resideo_gmaps_settings['resideo_gmaps_zoom_field'] : 13;
        $gmaps_style            = isset($resideo_gmaps_settings['resideo_gmaps_style_field']) ? $resideo_gmaps_settings['resideo_gmaps_style_field'] : '';
        $gmaps_poi              = isset($resideo_gmaps_settings['resideo_gmaps_poi_field']) ? $resideo_gmaps_settings['resideo_gmaps_poi_field'] : '';
        $poi_schools            = isset($resideo_gmaps_settings['resideo_gmaps_poi_schools_field']) ? $resideo_gmaps_settings['resideo_gmaps_poi_schools_field'] : '';
        $poi_transportation     = isset($resideo_gmaps_settings['resideo_gmaps_poi_transportation_field']) ? $resideo_gmaps_settings['resideo_gmaps_poi_transportation_field'] : '';
        $poi_restaurants        = isset($resideo_gmaps_settings['resideo_gmaps_poi_restaurants_field']) ? $resideo_gmaps_settings['resideo_gmaps_poi_restaurants_field'] : '';
        $poi_shopping           = isset($resideo_gmaps_settings['resideo_gmaps_poi_shopping_field']) ? $resideo_gmaps_settings['resideo_gmaps_poi_shopping_field'] : '';
        $poi_cafes              = isset($resideo_gmaps_settings['resideo_gmaps_poi_cafes_field']) ? $resideo_gmaps_settings['resideo_gmaps_poi_cafes_field'] : '';
        $poi_arts               = isset($resideo_gmaps_settings['resideo_gmaps_poi_arts_field']) ? $resideo_gmaps_settings['resideo_gmaps_poi_arts_field'] : '';
        $poi_fitness            = isset($resideo_gmaps_settings['resideo_gmaps_poi_fitness_field']) ? $resideo_gmaps_settings['resideo_gmaps_poi_fitness_field'] : '';

        if ($gmaps_key != '') {
            wp_enqueue_script('gmaps', 'https://maps.googleapis.com/maps/api/js?key=' . $gmaps_key . '&amp;callback=Function.prototype&amp;libraries=geometry&amp;libraries=places', array('jquery'), false, true);
            wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit', array('jquery'), false, true);
        }

        wp_enqueue_script('google-video',  'https://www.youtube.com/iframe_api', array(), false, true);

        wp_enqueue_script('fileinput', RESIDEO_LOCATION . '/js/fileinput.min.js', array('jquery'), '4.0', true); 
        wp_enqueue_script('photoswipe', RESIDEO_LOCATION . '/js/photoswipe.min.js', array(), '4.1.3', true);
        wp_enqueue_script('photoswipe-ui', RESIDEO_LOCATION . '/js/photoswipe-ui-default.min.js', array(), '4.1.3', true);
        wp_enqueue_script('owl-carousel',  RESIDEO_LOCATION . '/js/owl.carousel.min.js', array(), '2.3.4', true);
        wp_enqueue_script('chart', RESIDEO_LOCATION . '/js/Chart.min.js', array(), '2.9.3', true);
        wp_enqueue_script('sticky', RESIDEO_LOCATION . '/js/jquery.sticky.js', array('jquery'), '1.0.4', true);
        wp_enqueue_script('vibrant', RESIDEO_LOCATION . '/js/vibrant.min.js', array('jquery'), '1.0', true);
        wp_enqueue_script('masonry', RESIDEO_LOCATION . '/js/masonry.min.js', array('jquery'), '3.3.2', true);
        wp_enqueue_script('jquery-masonry', RESIDEO_LOCATION . '/js/jquery.masonry.min.js', array('jquery'), '3.1.2b', true);
        wp_enqueue_script('numscroller', RESIDEO_LOCATION . '/js/numscroller-1.0.js', array('jquery'), '1.0', true);
        wp_enqueue_script('anime', RESIDEO_LOCATION . '/js/anime.min.js', array(), '3.2.1', true);

        wp_enqueue_script('pxp-captcha', RESIDEO_LOCATION . '/js/recaptcha.js', array(), '1.0', true);
        wp_enqueue_script('pxp-services', RESIDEO_LOCATION . '/js/services.js', array(), '1.0', true);

        if ($gmaps_key != '') {
            wp_enqueue_script('infobox', RESIDEO_LOCATION . '/js/infobox.js', array('gmaps'), '1.1.13', true);
            wp_enqueue_script('pxp-map', RESIDEO_LOCATION . '/js/map.js', array(), '1.0', true);
            wp_enqueue_script('pxp-map-single', RESIDEO_LOCATION . '/js/single-map.js', array(), '1.0', true);
            wp_enqueue_script('pxp-map-contact', RESIDEO_LOCATION . '/js/contact-map.js', array(), '1.0', true);
        }

        $general_settings        = get_option('resideo_general_settings');
        $auto_country            = isset($general_settings['resideo_auto_country_field']) ? $general_settings['resideo_auto_country_field'] : '';
        $currency                = isset($general_settings['resideo_currency_symbol_field']) ? $general_settings['resideo_currency_symbol_field'] : '';
        $currency_pos            = isset($general_settings['resideo_currency_symbol_pos_field']) ? $general_settings['resideo_currency_symbol_pos_field'] : '';
        $map_marker_price_format = isset($general_settings['resideo_map_marker_price_format']) ? $general_settings['resideo_map_marker_price_format'] : 'short';

        $fields_settings   = get_option('resideo_prop_fields_settings');
        $city_type         = isset($fields_settings['resideo_p_city_t_field']) ? $fields_settings['resideo_p_city_t_field'] : '';
        $neighborhood_type = isset($fields_settings['resideo_p_neighborhood_t_field']) ? $fields_settings['resideo_p_neighborhood_t_field'] : '';

        $appearance_settings = get_option('resideo_appearance_settings');
        $theme_mode = isset($appearance_settings['resideo_theme_mode_field']) ? $appearance_settings['resideo_theme_mode_field'] : '';

        if ($gmaps_key != '') {
            wp_enqueue_script('pxp-map-submit', RESIDEO_LOCATION . '/js/submit-property-map.js', array(), '1.0', true);
            wp_localize_script('pxp-map-submit', 'spm_vars', 
                array(
                    'default_lat'       => $gmaps_lat,
                    'default_lng'       => $gmaps_lng,
                    'auto_country'      => $auto_country,
                    'city_type'         => $city_type,
                    'neighborhood_type' => $neighborhood_type,
                    'geocode_error'     => esc_html__('Geocode was not successful for the following reason', 'resideo'),
                    'theme_mode'        => $theme_mode,
                    'gmaps_style'       => $gmaps_style
                )
            );
        }

        wp_enqueue_script('pxp-tilt', RESIDEO_LOCATION . '/js/tilt.js', array(), '1.0', true);
        wp_enqueue_script('pxp-main', RESIDEO_LOCATION . '/js/main.js', array(), '1.0', true);
        wp_enqueue_script('pxp-video', RESIDEO_LOCATION . '/js/video.js', array(), '1.0', true);
        wp_enqueue_script('pxp-gallery', RESIDEO_LOCATION . '/js/gallery.js', array(), '1.0', true);
        wp_enqueue_script('pxp-payment-calculator', RESIDEO_LOCATION . '/js/payment-calculator.js', array(), '1.0', true);

        // Include dsIDXpress IDX Script only if plugin is active
        if (function_exists('dsidxpress_InitWidgets')) {
            wp_enqueue_script('resideo-dsidx-js', RESIDEO_LOCATION . '/js/idx.js', array(), '1.0', true);
        }

        // Search values
        $search_status       = isset($_GET['search_status']) ? sanitize_text_field($_GET['search_status']) : '0';
        $search_address      = isset($_GET['search_address']) ? stripslashes(sanitize_text_field($_GET['search_address'])) : '';
        $search_street_no    = isset($_GET['search_street_no']) ? stripslashes(sanitize_text_field($_GET['search_street_no'])) : '';
        $search_street       = isset($_GET['search_street']) ? stripslashes(sanitize_text_field($_GET['search_street'])) : '';
        $search_neighborhood = isset($_GET['search_neighborhood']) ? stripslashes(sanitize_text_field($_GET['search_neighborhood'])) : '';
        $search_city         = isset($_GET['search_city']) ? stripslashes(sanitize_text_field($_GET['search_city'])) : '';
        $search_state        = isset($_GET['search_state']) ? stripslashes(sanitize_text_field($_GET['search_state'])) : '';
        $search_zip          = isset($_GET['search_zip']) ? sanitize_text_field($_GET['search_zip']) : '';
        $search_type         = isset($_GET['search_type']) ? sanitize_text_field($_GET['search_type']) : '0';
        $search_price_min    = isset($_GET['search_price_min']) ? sanitize_text_field($_GET['search_price_min']) : '';
        $search_price_max    = isset($_GET['search_price_max']) ? sanitize_text_field($_GET['search_price_max']) : '';
        $search_beds         = isset($_GET['search_beds']) ? sanitize_text_field($_GET['search_beds']) : '';
        $search_baths        = isset($_GET['search_baths']) ? sanitize_text_field($_GET['search_baths']) : '';
        $search_size_min     = isset($_GET['search_size_min']) ? sanitize_text_field($_GET['search_size_min']) : '';
        $search_size_max     = isset($_GET['search_size_max']) ? sanitize_text_field($_GET['search_size_max']) : '';
        $search_keywords     = isset($_GET['search_keywords']) ? stripslashes(sanitize_text_field($_GET['search_keywords'])) : '';
        $search_id           = isset($_GET['search_id']) ? sanitize_text_field($_GET['search_id']) : '';
        $featured            = isset($_GET['featured']) ? sanitize_text_field($_GET['featured']) : '';
        $sort                = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'newest';

        $sort_leads    = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : '';
        $leads_page_no = get_query_var('paged');

        $amenities_settings = get_option('resideo_amenities_settings');
        $search_amenities   = array();

        if (is_array($amenities_settings) && count($amenities_settings) > 0) {
            uasort($amenities_settings, "resideo_compare_position");

            foreach ($amenities_settings as $key => $value) {
                if (isset($_GET[$key]) && esc_html($_GET[$key]) == 1) {
                    array_push($search_amenities, $key);
                }
            }
        }

        $custom_fields_settings = get_option('resideo_fields_settings');
        $search_custom_fields = array();

        if (is_array($custom_fields_settings)) {
            uasort($custom_fields_settings, "resideo_compare_position");

            foreach ($custom_fields_settings as $key => $value) {
                if ($value['search'] == 'yes' || $value['filter'] == 'yes') {
                    $field_data = array();

                    if ($value['type'] == 'interval_field') {
                        $search_field_min = isset($_GET[$key . '_min']) ? sanitize_text_field($_GET[$key . '_min']) : '';
                        $search_field_max = isset($_GET[$key . '_max']) ? sanitize_text_field($_GET[$key . '_max']) : '';
                    } else {
                        $search_field = isset($_GET[$key]) ? sanitize_text_field($_GET[$key]) : '';
                    }

                    $comparison = $key . '_comparison';
                    $comparison_value = isset($_GET[$comparison]) ? sanitize_text_field($_GET[$comparison]) : '';
                    $field_data['name'] = $key;

                    if ($value['type'] == 'interval_field') {
                        $field_data['value'] = array($search_field_min, $search_field_max);
                    } else {
                        $field_data['value'] = $search_field;
                    }

                    $field_data['compare'] = $comparison_value;
                    $field_data['type'] = $value['type'];

                    array_push($search_custom_fields, $field_data);
                }
            }
        }

        wp_localize_script('pxp-gallery', 'gallery_vars', 
            array(
                'is_rtl' => is_rtl()
            )
        );

        $user_logged_in = 0;
        $user_is_agent = 0;
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            $user_logged_in = 1;
            if (function_exists('resideo_check_user_agent')) {
                if (resideo_check_user_agent($current_user->ID) === true) {
                    $user_is_agent = 1;
                } else {
                    $user_is_agent = 0;
                }
            }
        } else {
            $user_logged_in = 0;
        }

        wp_localize_script('pxp-services', 'services_vars', 
            array(
                'admin_url'           => get_admin_url(),
                'ajaxurl'             => admin_url('admin-ajax.php'),
                'theme_url'           => RESIDEO_LOCATION,
                'base_url'            => home_url(),
                'user_logged_in'      => $user_logged_in,
                'user_is_agent'       => $user_is_agent,
                'wishlist_save'       => esc_html__('Save', 'resideo'),
                'wishlist_saved'      => esc_html__('Saved', 'resideo'),
                'list_redirect'       => function_exists('resideo_get_my_properties_link') ? resideo_get_my_properties_link() : '',
                'leads'               => esc_html__('Leads', 'resideo'),
                'leads_redirect'      => function_exists('resideo_get_myleads_url') ? resideo_get_myleads_url() : '',
                'sort_leads'          => $sort_leads,
                'leads_page_no'       => $leads_page_no,
                'vs_7_days'           => esc_html__('vs last 7 days', 'resideo'),
                'vs_30_days'          => esc_html__('vs last 30 days', 'resideo'),
                'vs_60_days'          => esc_html__('vs last 60 days', 'resideo'),
                'vs_90_days'          => esc_html__('vs last 90 days', 'resideo'),
                'vs_12_months'        => esc_html__('vs last 12 months', 'resideo'),
                'leads'               => esc_html__('Leads', 'resideo'),
                'contacted'           => esc_html__('Contacted', 'resideo'),
                'not_contacted'       => esc_html__('Not contacted', 'resideo'),
                'none'                => esc_html__('None', 'resideo'),
                'fit'                 => esc_html__('Fit', 'resideo'),
                'ready'               => esc_html__('Ready', 'resideo'),
                'engaged'             => esc_html__('Engaged', 'resideo'),
                'messages_list_empty' => esc_html__('No messages.', 'resideo'),
                'wl_list_empty'       => esc_html__('No properties in wish list.', 'resideo'),
                'searches_list_empty' => esc_html__('No saved searches.', 'resideo'),
                'related_property'    => esc_html__('Related Property', 'resideo'),
                'loading_messages'    => esc_html__('Loading messages', 'resideo'),
                'loading_wl'          => esc_html__('Loading wish list', 'resideo'),
                'loading_searches'    => esc_html__('Loading saved searches', 'resideo'),
                'account_redirect'    => function_exists('resideo_get_account_url') ? resideo_get_account_url() : '',
                'theme_mode'          => $theme_mode
            )
        );

        wp_localize_script('pxp-main', 'main_vars', 
            array(
                'theme_url'         => RESIDEO_LOCATION,
                'auto_country'      => $auto_country,
                'default_lat'       => $gmaps_lat,
                'default_lng'       => $gmaps_lng,
                'city_type'         => $city_type,
                'neighborhood_type' => $neighborhood_type,
                'interest'          => esc_html__('Principal and Interest', 'resideo'),
                'taxes'             => esc_html__('Property Taxes', 'resideo'),
                'hoa_dues'          => esc_html__('HOA Dues', 'resideo'),
                'currency'          => $currency,
                'currency_pos'      => $currency_pos,
                'is_rtl'            => is_rtl()
            )
        );

        wp_localize_script('pxp-map', 'map_vars', 
            array(
                'admin_url'            => get_admin_url(),
                'ajaxurl'              => admin_url('admin-ajax.php'),
                'theme_url'            => RESIDEO_LOCATION,
                'base_url'             => home_url(),
                'default_lat'          => $gmaps_lat,
                'default_lng'          => $gmaps_lng,
                'default_zoom'         => $gmaps_zoom,
                'search_status'        => $search_status,
                'search_address'       => $search_address,
                'search_street_no'     => $search_street_no,
                'search_street'        => $search_street,
                'search_neighborhood'  => $search_neighborhood,
                'search_city'          => $search_city,
                'search_state'         => $search_state,
                'search_zip'           => $search_zip,
                'search_type'          => $search_type,
                'search_price_min'     => $search_price_min,
                'search_price_max'     => $search_price_max,
                'search_beds'          => $search_beds,
                'search_baths'         => $search_baths,
                'search_size_min'      => $search_size_min,
                'search_size_max'      => $search_size_max,
                'search_keywords'      => $search_keywords,
                'search_id'            => $search_id,
                'search_amenities'     => $search_amenities,
                'search_custom_fields' => $search_custom_fields,
                'featured'             => $featured,
                'sort'                 => $sort,
                'page'                 => $paged,
                'theme_mode'           => $theme_mode,
                'gmaps_style'          => $gmaps_style,
                'marker_price_format'  => $map_marker_price_format,
                'schools_title'        => esc_html__('Schools', 'resideo'),
                'transportation_title' => esc_html__('Transportation', 'resideo'),
                'restaurants_title'    => esc_html__('Restaurants', 'resideo'),
                'shopping_title'       => esc_html__('Shopping', 'resideo'),
                'cafes_title'          => esc_html__('Cafes & Bars', 'resideo'),
                'arts_title'           => esc_html__('Arts & Entertainment', 'resideo'),
                'fitness_title'        => esc_html__('Fitness', 'resideo'),
                'gmaps_poi'            => $gmaps_poi,
                'poi_schools'          => $poi_schools,
                'poi_transportation'   => $poi_transportation,
                'poi_restaurants'      => $poi_restaurants,
                'poi_shopping'         => $poi_shopping,
                'poi_cafes'            => $poi_cafes,
                'poi_arts'             => $poi_arts,
                'poi_fitness'          => $poi_fitness
            )
        );

        wp_localize_script('pxp-map-single', 'map_single_vars', 
            array(
                'theme_mode'  => $theme_mode,
                'gmaps_style' => $gmaps_style
            )
        );

        wp_localize_script('pxp-map-contact', 'map_contact_vars', 
            array(
                'theme_mode'  => $theme_mode,
                'gmaps_style' => $gmaps_style
            )
        );

        $recaptcha_settings = get_option('resideo_recaptcha_settings', '');
        $recaptcha_site_key = isset($recaptcha_settings['resideo_recaptcha_site_key_field']) ? $recaptcha_settings['resideo_recaptcha_site_key_field'] : '';

        wp_localize_script('pxp-captcha', 'captcha_vars', 
            array(
                'site_key'   => $recaptcha_site_key,
                'theme_mode' => $theme_mode,
            )
        );

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
endif;
add_action( 'wp_enqueue_scripts', 'resideo_load_scripts' );

if (!function_exists('resideo_wp_title')) :
    function resideo_wp_title($title, $sep) {
        global $page, $paged;

        $title .= get_bloginfo('name', 'display');
        $site_description = get_bloginfo('description', 'display');

        if ($site_description && (is_home() || is_front_page() || is_archive() || is_search())) {
            $title .= " $sep $site_description";
        }

        return $title;
    }
endif;
add_filter('wp_title', 'resideo_wp_title', 10, 2);

if (!function_exists('resideo_compare_position')) :
    function resideo_compare_position($a, $b) {
        return intval($a["position"]) - intval($b["position"]);
    }
endif;

if (!function_exists('resideo_get_attachment')) :
    function resideo_get_attachment($id) {
        $attachment = get_post($id);

        return array(
            'alt'         => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
            'caption'     => $attachment->post_excerpt,
            'description' => $attachment->post_content,
            'title'       => $attachment->post_title
        );
    }
endif;

/**
 * Custom excerpt lenght
 */
if (!function_exists('resideo_custom_excerpt_length')): 
    function resideo_custom_excerpt_length($length) {
        return 30;
    }
endif;
add_filter('excerpt_length', 'resideo_custom_excerpt_length', 999);

/**
 * Custom excerpt ending
 */
function resideo_excerpt_more($more) {
    return '&#46;&#46;&#46;';
}
add_filter('excerpt_more', 'resideo_excerpt_more');

if (!function_exists('resideo_get_excerpt_by_id')): 
    function resideo_get_excerpt_by_id($post_id) {
        $the_post       = get_post($post_id);
        $the_excerpt    = $the_post->post_content;
        $excerpt_length = 30;
        $the_excerpt    = strip_tags(strip_shortcodes($the_excerpt));
        $words          = explode(' ', $the_excerpt, $excerpt_length + 1);

        if (count($words) > $excerpt_length) :
            array_pop($words);
            array_push($words, '...');
            $the_excerpt = implode(' ', $words);
        endif;

        wp_reset_postdata();

        return $the_excerpt;
    }
endif;

/**
 * Register sidebars
 */
if (!function_exists('resideo_widgets_init')): 
    function resideo_widgets_init() {
        register_sidebar(array(
            'name'          => esc_html__('Main Widget Area', 'resideo'),
            'id'            => 'pxp-main-widget-area',
            'description'   => esc_html__('The main widget area', 'resideo'),
            'before_widget' => '<div id="%1$s" class="pxp-side-section mt-4 mt-md-5 %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ));

        if (function_exists('dsidxpress_InitWidgets')) {
            register_sidebar(array(
                'name'          => esc_html__('IDX Properties Page Search Widget Area', 'resideo'),
                'id'            => 'pxp-idx-search-widget-area',
                'description'   => esc_html__('IDX properties page search form widget area', 'resideo'),
                'before_widget' => '<div id="%1$s" class="pxp-side-section mt-4 mt-md-5 %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3>',
                'after_title'   => '</h3>'
            ));
            register_sidebar(array(
                'name'          => esc_html__('IDX Homepage Search Widget Area', 'resideo'),
                'id'            => 'pxp-idx-home-search-widget-area',
                'description'   => esc_html__('IDX Homepage Search Widget Area', 'resideo'),
                'before_widget' => '<div id="%1$s" class="pxp-idx-home-section %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3>',
                'after_title'   => '</h3>'
            ));
        }

        register_sidebar(array(
            'name'          => esc_html__('Column #1 Footer Widget Area', 'resideo'),
            'id'            => 'pxp-first-footer-widget-area',
            'description'   => esc_html__('The first column footer widget area', 'resideo'),
            'before_widget' => '<div id="%1$s" class="pxp-side-section mt-4 mt-md-5 %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ));

        register_sidebar(array(
            'name'          => esc_html__('Column #2 Footer Widget Area', 'resideo'),
            'id'            => 'pxp-second-footer-widget-area',
            'description'   => esc_html__('The second column footer widget area', 'resideo'),
            'before_widget' => '<div id="%1$s" class="pxp-side-section mt-4 mt-md-5 %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ));

        register_sidebar(array(
            'name'          => esc_html__('Column #3 Footer Widget Area', 'resideo'),
            'id'            => 'pxp-third-footer-widget-area',
            'description'   => esc_html__('The third column footer widget area', 'resideo'),
            'before_widget' => '<div id="%1$s" class="pxp-side-section mt-4 mt-md-5 %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ));

        register_sidebar(array(
            'name'          => esc_html__('Column #4 Footer Widget Area', 'resideo'),
            'id'            => 'pxp-fourth-footer-widget-area',
            'description'   => esc_html__('The fourth column footer widget area', 'resideo'),
            'before_widget' => '<div id="%1$s" class="pxp-side-section mt-4 mt-md-5 %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ));
    }
endif;
add_action('widgets_init', 'resideo_widgets_init');

/**
 * Custom comments
 */

if (!function_exists('resideo_comment_ratings')): 
    function resideo_comment_ratings($comment_id) {
        if (isset($_POST['rate'])) {
            add_comment_meta($comment_id, 'rate', $_POST['rate']);
        }
    }
endif;
add_action('comment_post','resideo_comment_ratings');

if (!function_exists('resideo_comment')): 
    function resideo_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        extract($args, EXTR_SKIP);

        if ('div' == $args['style']) {
            $tag = 'div';
            $add_below = 'comment';
        } else {
            $tag = 'li';
            $add_below = 'div-comment';
        } ?>

        <<?php echo esc_html($tag); ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">

        <div class="media mt-3 mt-md-4">
            <?php if ($args['avatar_size'] != 0) {
                echo get_avatar($comment, $args['avatar_size']);
            }

            if ('div' != $args['style']) : ?>
                <div id="div-comment-<?php comment_ID() ?>" class="comment-body media-body">
            <?php endif; ?>

            <h5><?php echo get_comment_author_link(); ?> <span class="pxp-blog-post-comments-author-label"><?php esc_html_e('Author', 'resideo'); ?></span></h5>

            <div class="pxp-blog-post-comments-date">
                <div class="comment-meta commentmetadata">
                    <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>"><?php printf(esc_html__('%1$s at %2$s', 'resideo'), get_comment_date(), get_comment_time()); ?></a>
                </div>
            </div>

            <?php if ($comment->comment_approved == '0') : ?>
                <em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'resideo'); ?></em>
                <br />
            <?php endif; ?>

            <div class="comment-content">
                <?php comment_text(); ?>
            </div>

            <ul class="pxp-comment-ops">
                <li><?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?></li>
                <li><?php edit_comment_link(esc_html__('Edit', 'resideo')); ?></li>
            </ul>

            <?php if ('div' != $args['style']) : ?>
                </div>
            <?php endif; ?>
        </div>
    <?php }
endif;

if (!function_exists('resideo_agent_review')): 
    function resideo_agent_review($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        extract($args, EXTR_SKIP);

        if ('div' == $args['style']) {
            $tag = 'div';
            $add_below = 'comment';
        } else {
            $tag = 'li';
            $add_below = 'div-comment';
        } ?>

        <<?php echo esc_html($tag); ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">

        <div class="media mt-3 mt-md-4">
            <?php if ($args['avatar_size'] != 0) {
                echo get_avatar($comment, $args['avatar_size']);
            }

            if ('div' != $args['style']) : ?>
                <div id="div-comment-<?php comment_ID() ?>" class="comment-body media-body">
            <?php endif; ?>

            <h5><?php echo get_comment_author_link(); ?></h5>

            <div class="pxp-blog-post-comments-date">
                <div class="comment-meta commentmetadata">
                    <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>"><?php printf(esc_html__('%1$s at %2$s', 'resideo'), get_comment_date(), get_comment_time()); ?></a>
                </div>
            </div>

            <?php if ($comment->comment_approved == '0') : ?>
                <em class="comment-awaiting-moderation"><?php esc_html_e('Your review is awaiting moderation.', 'resideo'); ?></em>
                <br />
            <?php endif;

            $rate = get_comment_meta($comment->comment_ID, 'rate');

            if (isset($rate[0]) && $rate[0] != '') {
                print resideo_display_agent_rating(array('avarage' => $rate[0], 'users' => 0), false, 'pxp-agent-review-rating');
            }

            comment_text(); ?>

            <?php if ('div' != $args['style']) : ?>
                </div>
            <?php endif; ?>
        </div>
    <?php }
endif;

if(!function_exists('resideo_get_field_value')): 
    function resideo_get_field_value($field_type, $field_value, $list) {
        $field_text = '';

        if ($field_value != '') {
            if ($field_type == 'list') {
                if (is_array($list) && count($list) > 0) {
                    foreach ($list as $key => $value) {
                        if ($field_value == $key) {
                            $field_text = $value['name'];
                        }
                    }
                }
            } else {
                return $field_text = $field_value;
            }
        }

        return $field_text;
    }
endif;

/**
 * Pagination
 */
if (!function_exists('resideo_pagination')): 
    function resideo_pagination($pages = '', $range = 2) {
        $showitems = ($range * 2) + 1;

        global $paged;
        if (empty($paged)) {
            $paged = 1;
        }

        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }

        if (1 != $pages) {
            echo '<ul class="pagination pxp-paginantion mt-2 mt-md-4">';

            if ($paged > 2 && $paged > $range + 1 && $showitems < $pages) {
                echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link(1)) . '"><span class="fa fa-angle-double-left"></span></a></li>';
            }

            if ($paged > 1 && $showitems < $pages) {
                echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link($paged - 1)) . '"><span class="fa fa-angle-left"></span></a></li>';
            }

            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                    if ($paged == $i) {
                        echo '<li class="page-item active"><a class="page-link" href="#">' . esc_html($i) . '</a></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link($i)) . '">' . esc_html($i) . '</a></li>';
                    }
                }
            }

            if ($paged < $pages && $showitems < $pages) {
                echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link($paged + 1)) . '"><span class="fa fa-angle-right"></span></a></li>';
            }

            if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages) {
                echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link($pages)) . '"><span class="fa fa-angle-double-right"></span></a></li>';
            }

            echo '</ul>';
        }
    }
endif;

if (!function_exists('resideo_sanitize_item')) :
    function resideo_sanitize_item($item) {
        return sanitize_text_field($item);
    }
endif;

if (!function_exists('resideo_sanitize_multi_array')) :
    function resideo_sanitize_multi_array(&$item, $key) {
        $item = sanitize_text_field($item);
    }
endif;

if (!function_exists('resideo_get_client_ip_env')): 
    function resideo_get_client_ip_env() {
        $ipaddress = '';

        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } else if(getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } else if(getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } else if(getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } else if(getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } else if(getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }
endif;

if (!function_exists('resideo_add_dark_mode_class')): 
    function resideo_add_dark_mode_class($classes) {
        $appearance_settings = get_option('resideo_appearance_settings');
        $theme_mode = isset($appearance_settings['resideo_theme_mode_field']) ? $appearance_settings['resideo_theme_mode_field'] : '';

        if ($theme_mode == 'dark') {
            $classes[] = 'pxp-dark-mode';
        }

        return $classes;
    }
endif;
add_filter('body_class', 'resideo_add_dark_mode_class');

// Fix redirect for pagination on single agent page template
if (!function_exists('resideo_single_agent_redirect_canonical')): 
    function resideo_single_agent_redirect_canonical($redirect_url) {
        if (is_singular('agent')) {
            $redirect_url = false;
        }

        return $redirect_url;
    }
endif;
add_filter('redirect_canonical', 'resideo_single_agent_redirect_canonical');

//Resales Online API for all Properties

add_action('init', function() {
    add_rewrite_rule('^property/([^/]+)/?$', 'index.php?property_ref=$matches[1]', 'top');
});
add_filter('query_vars', function($vars) {
    $vars[] = 'property_ref';
    return $vars;
});

add_filter('template_include', function($template) {
    if (get_query_var('property_ref')) {
        // Point this to your test template path
        return get_stylesheet_directory() . '/single_property.php';
    }
    return $template;
});

add_action('rest_api_init', function () {
    register_rest_route('resales/v1', '/property-detail/', [
        'methods' => 'GET',
        'callback' => 'get_resales_property_detail_api',
        'permission_callback' => '__return_true'
    ]);
});

// -- Securely Fetch Resales Properties 
function get_resales_property_detail_api($request) {
    $options = get_option('resideo_general_settings'); 
    $api_url = 'https://webapi.resales-online.com/V6/PropertyDetails';
    $p1 = $options['resideo_apiidnt_field'];
    $api_key = $options['resideo_apikey_field'];

    $ref_id = $request->get_param('P_RefId');
    if (!$ref_id) {
        return new WP_Error('missing_refid', 'Missing property reference ID', ['status' => 400]);
    }

    $body = [
        'P1' => $p1,
        'P2' => $api_key,
        'P_ApiId' => '63886',
        'P_RefId' => $ref_id
        // Add more parameters as needed
    ];

    // CACHE KEY -- Make sure it's unique per RefId
    $cache_key = 'avida_resales_detail_' . md5(json_encode($body));

    // CHECK CACHE FIRST
    $cache = get_transient($cache_key);
    if ($cache !== false) {
        return rest_ensure_response($cache);
    }

    $query_url = add_query_arg($body, $api_url);

    $response = wp_remote_get($query_url, [
        'headers' => [
            'Content-Type' => 'application/json'
        ],
        'timeout' => 15,
        'sslverify' => false,
    ]);

    if (is_wp_error($response)) {
        return new WP_Error('api_error', $response->get_error_message(), ['status' => 502]);
    }

    $raw_body = wp_remote_retrieve_body($response);
    $data = json_decode($raw_body, true);

    if (!$data || empty($data['Property'])) {
        return rest_ensure_response([
            'property' => null,
            'raw' => $raw_body // For debugging, remove for prod
        ]);
    }

    $result = [
        'property' => $data['Property'],
        // 'raw' => $raw_body // Uncomment for debugging
    ];

    // SET CACHE -- 5 minutes (300 seconds), or change as needed
    set_transient($cache_key, $result, 300);

    return rest_ensure_response($result);
}
add_action('rest_api_init', function () {
    register_rest_route('resales/v1', '/properties/', array(
        'methods'  => 'GET',
        'callback' => 'get_resales_properties_api',
        'permission_callback' => '__return_true', // Open endpoint, optionally restrict
    ));
});

// Main API Call
function get_resales_properties_api($request) {
    $options = get_option('resideo_general_settings'); 
    $api_url = 'https://webapi.resales-online.com/V6/SearchProperties';
    $p1 = $options['resideo_apiidnt_field'];
    $api_key = $options['resideo_apikey_field'];

    $page = (int)$request->get_param('p_PageNo');
    if ($page < 1) $page = 1;

    // Build parameters for URL
     $body = array(
        'P1'              => $p1,
        'P2'              => $api_key,
        'P_ApiId'         => '63886',
        //'P_Lang'        => $request->get_param('P_Lang') ?: '',
        //'P_RefId'       => $request->get_param('P_RefId') ?: '',
        //'P_QueryId'     => $request->get_param('P_QueryId') ?: '',
        'p_SortType'      => '1',
        'p_Min'           => $request->get_param('p_Min') ?: '',
        'p_Max'           => $request->get_param('p_Max') ?: '',
        'p_PropertyTypes' => $request->get_param('p_PropertyTypes') ?: '',
        'p_Beds'          => $request->get_param('p_Beds') ?: '',
        'p_Location'      => $request->get_param('p_Location') ?: '',
        'p_new_devs'      => $request->get_param('p_new_devs') !== null ? $request->get_param('p_new_devs') : 'exclude',
        'p_PageNo'        => $page,
        'p_PageSize'      => 12
        
    );
    
    $body = array_filter($body, function($v) { return $v !== ''; });
    // Use different cache for each page number
    $cache_key = 'avida_resales_' . md5(json_encode($body));

    // Check cache first
    $cache = get_transient($cache_key);
    if ($cache !== false) {
        return rest_ensure_response($cache);
    }

    // Build dynamic query URL
    $query_url = add_query_arg($body, $api_url);

    $response = wp_remote_get($query_url, [
        'headers' => [
            // 'Authorization'  => 'Bearer ' . $api_key, // usually not needed for Resales API
            'Content-Type'   => 'application/json'
        ],
        'timeout' => 15,
        'sslverify' => false,
    ]);

    if (is_wp_error($response)) {
        return new WP_Error('api_error', $response->get_error_message(), ['status' => 502]);
    }

    $raw_body = wp_remote_retrieve_body($response);
    $data = json_decode($raw_body, true);

    if (!$data || !isset($data['Property']) || !is_array($data['Property'])) {
        // Do NOT cache error responses!
        $transaction = isset($data['transaction']) ? $data['transaction'] : null;
        return rest_ensure_response([
            'properties'   => [],
            'query'        => [],
            'transaction'  => $transaction,
            'raw'          => $raw_body // for investigation, remove for production
        ]);
    }

    $result = array(
        'properties'   => $data['Property'],
        'query'        => $data['QueryInfo'],
        'transaction'  => isset($data['transaction']) ? $data['transaction'] : null,
        // 'raw' => $raw_body, // uncomment for debugging
    );

    // Cache successful result (e.g. 60 seconds)
    set_transient($cache_key, $result, 300);

    return rest_ensure_response($result);
}

function render_smart_pagination($current_page, $total_pages, $base_url) {
if ($total_pages < 2) return;

// BUILD query string from current GET params
$get_params = $_GET;
$querystring = '';
if (!empty($get_params)) {
    $querystring = '?' . http_build_query($get_params);
}

echo '<ul class="pagination pxp-paginantion mt-2 mt-md-4">';

// Previous Button
if ($current_page > 1) {
    $prev_page_url = ($current_page - 1 == 1)
        ? $base_url . $querystring
        : trailingslashit($base_url) . 'page/' . ($current_page - 1) . '/' . $querystring;
    echo '<li class="page-item"><a class="page-link" href="' . esc_url($prev_page_url) . '">&laquo;</a></li>';
} else {
    echo '<li class="page-item disabled"><span class="page-link">&laquo;</span></li>';
}

$pages_to_show = [];

// Always show first 1 and 2
$pages_to_show[] = 1;
if ($total_pages >= 2) $pages_to_show[] = 2;

// Show current, one before and one after
for ($i = $current_page - 1; $i <= $current_page + 1; $i++) {
    if ($i > 2 && $i < $total_pages - 1) $pages_to_show[] = $i;
}

// Always show last 1 and 2
if ($total_pages >= 3) $pages_to_show[] = $total_pages - 1;
if ($total_pages >= 2) $pages_to_show[] = $total_pages;

// Remove duplicates and sort
$pages_to_show = array_unique($pages_to_show);
$pages_to_show = array_filter($pages_to_show, function($page) use ($total_pages) {
    return $page >= 1 && $page <= $total_pages;
});
sort($pages_to_show);

$prev = 0;
foreach ($pages_to_show as $page) {
    if ($prev && $page - $prev > 1) {
        // Gap, so insert dots
        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
    }
    $active = ($page == $current_page) ? ' active' : '';
    $page_url = ($page == 1)
        ? $base_url . $querystring
        : trailingslashit($base_url) . 'page/' . $page . '/' . $querystring;
    echo '<li class="page-item'.$active.'"><a class="page-link" href="' . esc_url($page_url) . '">' .$page. '</a></li>';
    $prev = $page;
}

// Next Button
if ($current_page < $total_pages) {
    $next_page_url = trailingslashit($base_url) . 'page/' . ($current_page + 1) . '/' . $querystring;
    echo '<li class="page-item"><a class="page-link" href="' . esc_url($next_page_url) . '">&raquo;</a></li>';
} else {
    echo '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';
}

echo '</ul>';
}

function resales_property_filter_form() {
    ob_start(); ?>
    <?php
// At the top of your template:
$current_location      = isset($_GET['p_Location'])      ? $_GET['p_Location']      : '';
$current_propertytypes = isset($_GET['p_PropertyTypes']) ? $_GET['p_PropertyTypes'] : '0';
$current_beds          = isset($_GET['p_Beds'])          ? $_GET['p_Beds']          : '0';
$current_min           = isset($_GET['p_Min'])           ? $_GET['p_Min']           : '';
$current_max           = isset($_GET['p_Max'])           ? $_GET['p_Max']           : '';
$current_newdev        = isset($_GET['p_new_devs']) && $_GET['p_new_devs'] === 'only';
?>
<form class="pxp-results-filter-form" role="search" method="get" action="<?php echo esc_url(get_permalink()); ?>">
    <div class="pxp-content-side-search-form-adv mb-3">
        <div class="row pxp-content-side-search-form-row">

            <!-- Location (Neighborhood) -->
            <div class="col-sm-6 col-md-2 pxp-content-side-search-form-col">
                <div class="form-group">
                    <label for="p_Location">Neighborhood</label>
                    <select class="custom-select" id="p_Location" name="p_Location">
                        <option value="">All</option>
                        <?php
                        $locations = ["Aloha", "Altos de los Monteros", "Atalaya", "Bahía de Marbella", "Bailen Miraflores",
                            "Bel Air", "Benahavís", "Benalmadena", "Benalmadena Costa", "Benavista", "Cabopino", "Calahonda",
                            "Calanova Golf", "Calypso", "Campo Mijas", "Cancelada", "El Madroñal", "El Padron", "El Paraiso",
                            "El Faro", "El Rosario", "Estepona", "Elviria", "Guadalmina Alta", "Guadalmina Baja", "Istán", "La Cala de Mijas",
                            "La Cala Golf", "La Atalaya", "La Cala", "La Cala Hills", "La Quinta", "La Zagaleta", "Las Brisas",
                            "Las Chapas", "Las Lagunas", "Los Flamingos", "Los Monteros", "Marbella", "Marbesa", "Mijas",
                            "Mijas Costa", "Mijas Golf", "Nagüeles", "New Golden Mile", "Nueva Andalucía", "Puerto Banús",
                            "Puerto de Cabopino", "Reserva de Marbella", "Río Real", "Riviera del Sol", "San Pedro de Alcántara",
                            "Selwo", "Sierra Blanca", "Sotogrande", "Sotogrande Alto", "Sotogrande Costa", "Sotogrande Marina",
                            "Sotogrande Playa", "The Golden Mile"];
                        foreach ($locations as $loc) {
                            echo '<option value="' . esc_attr($loc) . '"';
                            if ($current_location == $loc) echo ' selected';
                            echo '>' . esc_html($loc) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Property Type and Beds -->
            <div class="col-sm-4 pxp-content-side-search-form-col">
                <div class="row pxp-content-side-search-form-row">
                    <div class="col pxp-content-side-search-form-col">
                        <div class="form-group">
                            <label for="p_PropertyTypes">Type</label>
                            <select class="custom-select" id="p_PropertyTypes" name="p_PropertyTypes">
                                <option value="0" <?php if ($current_propertytypes == "0") echo 'selected'; ?>>All</option>
                                <option value="1-1" <?php if ($current_propertytypes == "1-1") echo 'selected'; ?>>Apartment</option>
                                <option value="1-2" <?php if ($current_propertytypes == "1-2") echo 'selected'; ?>>Ground Floor Apartment</option>
                                <option value="1-4" <?php if ($current_propertytypes == "1-4") echo 'selected'; ?>>Middle Floor Apartment</option>
                                <option value="1-5" <?php if ($current_propertytypes == "1-5") echo 'selected'; ?>>Top Floor Apartment</option>
                                <option value="1-6" <?php if ($current_propertytypes == "1-6") echo 'selected'; ?>>Penthouse</option>
                                <option value="1-8" <?php if ($current_propertytypes == "1-8") echo 'selected'; ?>>Duplex</option>
                                <option value="2-2" <?php if ($current_propertytypes == "2-2") echo 'selected'; ?>>Detached Villa</option>
                                <option value="2-4" <?php if ($current_propertytypes == "2-4") echo 'selected'; ?>>Semi-Detached House</option>
                                <option value="2-5" <?php if ($current_propertytypes == "2-5") echo 'selected'; ?>>Townhouse</option>
                            </select>
                        </div>
                    </div>
                    <div class="col pxp-content-side-search-form-col">
                        <div class="form-group">
                            <label for="p_Beds">Beds</label>
                            <select class="custom-select" name="p_Beds" id="p_Beds">
                                <option value="0" <?php if ($current_beds == "0") echo 'selected'; ?>>Any</option>
                                <option value="1" <?php if ($current_beds == "1") echo 'selected'; ?>>1+</option>
                                <option value="2" <?php if ($current_beds == "2") echo 'selected'; ?>>2+</option>
                                <option value="3" <?php if ($current_beds == "3") echo 'selected'; ?>>3+</option>
                                <option value="4" <?php if ($current_beds == "4") echo 'selected'; ?>>4+</option>
                                <option value="5" <?php if ($current_beds == "5") echo 'selected'; ?>>5+</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Price -->
            <div class="col-sm-4 pxp-content-side-search-form-col">
                <div class="row pxp-content-side-search-form-row">
                    <div class="col pxp-content-side-search-form-col">
                        <div class="form-group">
                            <label for="p_Min">Min Price</label>
                            <select class="custom-select" name="p_Min" id="p_Min">
                                <option value="" <?php if ($current_min === "") echo 'selected'; ?>>No Min</option>
                                <option value="100000" <?php if ($current_min == "100000") echo 'selected'; ?>>€100,000</option>
                                <option value="200000" <?php if ($current_min == "200000") echo 'selected'; ?>>€200,000</option>
                                <option value="500000" <?php if ($current_min == "500000") echo 'selected'; ?>>€500,000</option>
                                <option value="1000000" <?php if ($current_min == "1000000") echo 'selected'; ?>>€1,000,000</option>
                                <option value="2000000" <?php if ($current_min == "2000000") echo 'selected'; ?>>€2,000,000</option>
                                <option value="5000000" <?php if ($current_min == "5000000") echo 'selected'; ?>>€5,000,000</option>
                            </select>
                        </div>
                    </div>
                    <div class="col pxp-content-side-search-form-col">
                        <div class="form-group">
                            <label for="p_Max">Max Price</label>
                            <select class="custom-select" name="p_Max" id="p_Max">
                                <option value="" <?php if ($current_max === "") echo 'selected'; ?>>No Max</option>
                                <option value="300000" <?php if ($current_max == "300000") echo 'selected'; ?>>€300,000</option>
                                <option value="600000" <?php if ($current_max == "600000") echo 'selected'; ?>>€600,000</option>
                                <option value="1000000" <?php if ($current_max == "1000000") echo 'selected'; ?>>€1,000,000</option>
                                <option value="5000000" <?php if ($current_max == "5000000") echo 'selected'; ?>>€5,000,000</option>
                                <option value="10000000" <?php if ($current_max == "10000000") echo 'selected'; ?>>€10,000,000</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Development Checkbox -->
            <div class="col-sm-6 col-md-2 pxp-content-side-search-form-col newdev">
                <div class="form-group">
                    <div class="checkbox custom-checkbox">
                        <label>
                            <input type="checkbox" name="p_new_devs" value="only" <?php if ($current_newdev) echo 'checked'; ?>>
                            <span class="fa fa-check"></span> New Development
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="submit" class="pxp-filter-btn" value="Apply filters">
</form>
    <?php
    return ob_get_clean();
}

// 1. Register the shortcode "[resales_properties ...]"
add_shortcode('resales_properties', 'resales_properties_shortcode_handler');

function resales_properties_shortcode_handler($atts) {
    // Default values
    $defaults = [
        'p_min'           => '',
        'p_max'           => '',
        'p_propertytypes' => '',
        'p_beds'          => '',
        'p_location'      => '',
        'p_new_devs'      => 'exclude',
    ];
    $args = shortcode_atts($defaults, $atts);

    // Call your API fetcher
    $data = resales_properties_fetch_api($args);
    $properties = $data['properties'] ?? [];
    $api_error = is_wp_error($data);

    ob_start();
    ?>
    <div class="row pxp-results">
    <?php
    if (!$api_error) {
        if (!empty($properties)) {
            foreach ($properties as $p) {
                $carousel_id = 'card-carousel-' . esc_attr($p['Reference'] ?? '');
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
                $details_url = site_url('property/' . urlencode($p['Reference'] ?? ''));

                ?>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a href="<?php echo $details_url; ?>" class="pxp-results-card pxp-results-card-2" data-prop="<?php echo esc_attr($p['Reference'] ?? ''); ?>">
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
                        <?php if (isset($p['OwnProperty']) && $p['OwnProperty'] == "1") { ?>
                            <div class="pxp-results-card-2-featured-label">Exclusive</div>
                        <?php } ?>
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
                                        echo esc_html($p['GardenPlot']) . ' P m²';
                                    }
                                }
                                ?>
                                </span>
                            </div>
                            <div class="pxp-results-card-2-details-price">
                                <?php
                                $price = !empty($p['Price']) ? number_format(floatval($p['Price'])) : 'N/A';
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
        }
    }
    ?>
    </div>
            
    <?php

    return ob_get_clean();
}

// Shortcode API Call
function resales_properties_fetch_api($params) {
        $options = get_option('resideo_general_settings'); 
        $api_url = 'https://webapi.resales-online.com/V6/SearchProperties';
        $p1 = $options['resideo_apiidnt_field'];
        $api_key = $options['resideo_apikey_field'];

        // Prepare API params
        $body = array(
            'P1'              => $p1,
            'P2'              => $api_key,
            'P_ApiId'         => '63886',
            'p_Min'           => $params['p_min'],
            'p_Max'           => $params['p_max'],
            'p_PropertyTypes' => $params['p_propertytypes'],
            'p_Beds'          => $params['p_beds'],
            'p_Location'      => $params['p_location'],
            'p_new_devs'      => $params['p_new_devs'],
            'p_PageNo'        => 1,
            'p_PageSize'      => 12
        );

        $body = array_filter($body, function($v) { return $v !== ''; });
        // Use different cache for each body param set
        $cache_key = 'avida_resales_shortcode_' . md5(json_encode($body));

        // Check cache first
        $cache = get_transient($cache_key);
        if ($cache !== false) {
            return $cache;
        }

        // Build dynamic query URL
        $query_url = add_query_arg($body, $api_url);
        $response = wp_remote_get($query_url, [
            'headers' => [
                'Content-Type'   => 'application/json'
            ],
            'timeout' => 15,
            'sslverify' => false,
        ]);

        if (is_wp_error($response)) {
            return $response;
        }

        $raw_body = wp_remote_retrieve_body($response);
        $data = json_decode($raw_body, true);

        if (!$data || !isset($data['Property']) || !is_array($data['Property'])) {
            return [
                'properties'   => [],
                'query'        => [],
                'transaction'  => $data['transaction'] ?? null,
                'raw'          => $raw_body
            ];
        }
        $result = [
            'properties'   => $data['Property'],
            'query'        => $data['QueryInfo'],
            'transaction'  => $data['transaction'] ?? null,
        ];

        // Cache successful result
        set_transient($cache_key, $result, 300);

        return $result;
    }

// Homepage resales api function
add_action('rest_api_init', function () {
    register_rest_route('resales/v1', '/homepage-properties/', array(
        'methods'  => 'GET',
        'callback' => 'get_resales_homepage_properties_api',
        'permission_callback' => '__return_true', // Open endpoint
    ));
});

function get_resales_homepage_properties_api($request) {
    $options = get_option('resideo_general_settings'); 
    $api_url = 'https://webapi.resales-online.com/V6/SearchProperties';
    $p1 = $options['resideo_apiidnt_field'];
    $api_key = $options['resideo_apikey_field'];

    // Homepage: could hardcode params, or get small set
    $body = array(
        'P1'              => $p1,
        'P2'              => $api_key,
        'P_ApiId'         => '63895',
        'p_SortType'      => '1',
        'p_PageNo'        => 1,
        'p_PageSize'      => 10,
    );
    
    $body = array_filter($body, function($v) { return $v !== ''; });

    // Homepage cache key
    $cache_key = 'avida_resales_homepage_' . md5(json_encode($body));

    $cache = get_transient($cache_key);
    if ($cache !== false) {
        return rest_ensure_response($cache);
    }

    // Build URL
    $query_url = add_query_arg($body, $api_url);

    $response = wp_remote_get($query_url, [
        'headers' => [
            'Content-Type'   => 'application/json'
        ],
        'timeout' => 15,
        'sslverify' => false,
    ]);

    if (is_wp_error($response)) {
        return new WP_Error('api_error', $response->get_error_message(), ['status' => 502]);
    }

    $raw_body = wp_remote_retrieve_body($response);
    $data = json_decode($raw_body, true);

    if (!$data || !isset($data['Property']) || !is_array($data['Property'])) {
        return rest_ensure_response([
            'properties'   => [],
            'query'        => [],
            'transaction'  => isset($data['transaction']) ? $data['transaction'] : null,
            'raw'          => $raw_body // for investigation, remove in prod
        ]);
    }

    $result = array(
        'properties'   => $data['Property'],
        'query'        => $data['QueryInfo'],
        'transaction'  => isset($data['transaction']) ? $data['transaction'] : null,
        // 'raw' => $raw_body,
    );

    set_transient($cache_key, $result, 300);

    return rest_ensure_response($result);
}
// add meta title and meta description to properties from resales 
// meta description
function my_property_wpseo_metadesc($desc) {
    if (isset($GLOBALS['current_property_data']) && is_array($GLOBALS['current_property_data'])) {
        $property = $GLOBALS['current_property_data'];
        $description_raw = isset($property['Description']) ? $property['Description'] : '';
        $desc = mb_substr(strip_tags($description_raw), 0, 155);
    }
    return $desc;
}
add_filter('wpseo_metadesc', 'my_property_wpseo_metadesc');

// title shortener
function truncate_title($title, $max_length = 60) {
    if (mb_strlen($title) > $max_length) {
        $trimmed = mb_substr($title, 0, $max_length);
        $last_space = mb_strrpos($trimmed, ' ');
        if ($last_space !== false) {
            $trimmed = mb_substr($trimmed, 0, $last_space);
        }
        return $trimmed . '...';
    }
    return $title;
}

// Yoast SEO title filter
function my_yoast_property_title($title) {
    if (isset($GLOBALS['current_property_data']) && is_array($GLOBALS['current_property_data'])) {
        $property = $GLOBALS['current_property_data'];
        $beds = (!empty($property['Bedrooms']) ? $property['Bedrooms'] . ' Bed ' : '');
        $type = (!empty($property['PropertyType']['NameType']) ? $property['PropertyType']['NameType'] : 'Property');
        $loc = (!empty($property['Location']) ? $property['Location'] : '');
        $ref = (!empty($property['Reference']) ? $property['Reference'] : '');

        $raw_title = trim("{$beds}{$type} in {$loc} for Sale - {$ref}");
        $title = truncate_title($raw_title, 60); // keep to 60 chars
    }
    return $title;
}
add_filter('wpseo_title', 'my_yoast_property_title');

function my_yoast_canonical_url($canonical) {
    $property_ref = get_query_var('property_ref');
    if ($property_ref) {
        $canonical = home_url('/property/' . urlencode($property_ref) . '/');
    }
    return $canonical;
}
add_filter('wpseo_canonical', 'my_yoast_canonical_url');

// Yoast: dynamic OG title
function my_property_og_title($og_title) {
    if (isset($GLOBALS['current_property_data']) && is_array($GLOBALS['current_property_data'])) {
        $property = $GLOBALS['current_property_data'];
        $beds = (!empty($property['Bedrooms']) ? $property['Bedrooms'] . ' Bed ' : '');
        $type = (!empty($property['PropertyType']['NameType']) ? $property['PropertyType']['NameType'] : 'Property');
        $loc = (!empty($property['Location']) ? $property['Location'] : '');
        $ref = (!empty($property['Reference']) ? $property['Reference'] : '');
        $raw_title = trim("{$beds}{$type} in {$loc} for Sale - {$ref}");
        $og_title = truncate_title($raw_title, 60);
    }
    return $og_title;
}
add_filter('wpseo_opengraph_title', 'my_property_og_title');

// Yoast: dynamic OG description
function my_property_og_desc($og_desc) {
    if (isset($GLOBALS['current_property_data']) && is_array($GLOBALS['current_property_data'])) {
        $property = $GLOBALS['current_property_data'];
        $description_raw = isset($property['Description']) ? $property['Description'] : '';
        $og_desc = mb_substr(strip_tags($description_raw), 0, 155);
    }
    return $og_desc;
}
add_filter('wpseo_opengraph_desc', 'my_property_og_desc');

// Yoast: dynamic OG URL
function my_property_og_url($og_url) {
    if (isset($GLOBALS['current_property_data']) && is_array($GLOBALS['current_property_data'])) {
        $property = $GLOBALS['current_property_data'];
        $ref = (!empty($property['Reference']) ? $property['Reference'] : '');
        if ($ref) {
            $og_url = home_url('/property/' . urlencode($ref) . '/');
        }
    }
    return $og_url;
}
add_filter('wpseo_opengraph_url', 'my_property_og_url');

// Yoast: dynamic OG image
function my_property_og_image($og_image) {
    if (isset($GLOBALS['current_property_data']) && is_array($GLOBALS['current_property_data'])) {
        $property = $GLOBALS['current_property_data'];
        $image_url = '';
        if (
            !empty($property['Pictures']['Picture']) &&
            is_array($property['Pictures']['Picture']) &&
            !empty($property['Pictures']['Picture'][0]['PictureURL'])
        ) {
            $image_url = $property['Pictures']['Picture'][0]['PictureURL'];
        }
        if ($image_url) {
            $og_image = $image_url;
        }
    }
    return $og_image;
}
add_filter('wpseo_opengraph_image', 'my_property_og_image');

// Yoast: dynamic OG type ("product" for property listings)
function my_property_og_type($og_type) {
    if (isset($GLOBALS['current_property_data']) && is_array($GLOBALS['current_property_data'])) {
        return 'product';
    }
    return $og_type;
}
add_filter('wpseo_opengraph_type', 'my_property_og_type');

// add correct schema for properties as products
function output_property_schema_structured_data() {
    if (isset($GLOBALS['current_property_data']) && is_array($GLOBALS['current_property_data'])) {
        $property = $GLOBALS['current_property_data'];
        $type = !empty($property['PropertyType']['NameType']) ? $property['PropertyType']['NameType'] : 'Property';
        $loc = !empty($property['Location']) ? $property['Location'] : '';
        $ref = !empty($property['Reference']) ? $property['Reference'] : '';
        $price = !empty($property['Price']) ? $property['Price'] : '';
        $currency = !empty($property['Currency']) ? $property['Currency'] : 'EUR'; // Adjust as needed
        $bedrooms = !empty($property['Bedrooms']) ? intval($property['Bedrooms']) : null;

        // Just the first image, if available
        $image_url = '';
        if (
            !empty($property['Pictures']['Picture']) &&
            is_array($property['Pictures']['Picture']) &&
            !empty($property['Pictures']['Picture'][0]['PictureURL'])
        ) {
            $image_url = $property['Pictures']['Picture'][0]['PictureURL'];
        }

        $canonical = home_url('/property/' . urlencode($ref) . '/');
        
        $raw_description = !empty($property['Description']) ? strip_tags($property['Description']) : '';
        $description = mb_substr($raw_description, 0, 300);

        // Add address structure
        $address = [
            "@type" => "PostalAddress",
            "addressLocality" => $loc,
            "addressRegion"   => "Costa del Sol",
            "addressCountry"  => "Spain"
        ];

        $schema = [
            "@context" => "https://schema.org",
            "@type" => "Product",
            "name" => "{$type} in {$loc} for Sale - {$ref}",
            "image" => $image_url,
            "description" => $description,
            "url" => $canonical,
            "sku" => $ref,
            "brand" => [
                "@type" => "Brand",
                "name" => "Avida Estate"
            ],
            "address" => $address,
            // Only include bedrooms if it exists and is > 0
            "numberOfRooms" => $bedrooms,
            "offers" => [
                "@type" => "Offer",
                "priceCurrency" => $currency,
                "price" => $price,
                "availability" => "https://schema.org/InStock",
            ]
        ];

        // Remove numberOfRooms if not set (to avoid an empty/null property in schema)
        if (!$bedrooms) {
            unset($schema['numberOfRooms']);
        }

        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'output_property_schema_structured_data', 20);

//remove yoast incorrect Schema for properties
add_filter('wpseo_json_ld_output', function($enabled) {
    if (isset($GLOBALS['current_property_data']) && is_array($GLOBALS['current_property_data'])) {
        return false; // Disable Yoast JSON-LD on property pages
    }
    return $enabled;
});

// add custom google font 

function mytheme_enqueue_google_fonts() {
    wp_enqueue_style(
        'mytheme-google-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Serif+Display:ital,wght@0,100..900;1,100..900&display=swap',
        array(),
        null
    );
}
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_google_fonts' );

// Gutenberg blocks
require_once get_template_directory() . '/inc/blocks.php';

// Options page
require_once get_template_directory() . '/inc/options-page.php';

?>