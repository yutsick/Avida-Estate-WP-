<?php
/*
Template Name: Center Default
*/

/**
 * @package WordPress
 * @subpackage Resideo
 */

global $post;
get_header();

$resideo_appearance_settings = get_option('resideo_appearance_settings', '');
$sidebar_position            = isset($resideo_appearance_settings['resideo_sidebar_field']) ? $resideo_appearance_settings['resideo_sidebar_field'] : 'right';
$resideo_general_settings    = get_option('resideo_general_settings'); 


$content_column_class = 'col-sm-12 col-lg-10';
$items_column_class = 'col-sm-12 col-md-6';
?>
<div class="pxp-content">
    <?php while(have_posts()) : the_post();
        $post_ID     = get_the_ID();
        $header_type = get_post_meta($post_ID, 'page_header_type', true);

        $header_info                     = array();
        $header_info['post_id']          = $post_ID;
        $header_info['header_type']      = $header_type;
        $header_info['general_settings'] = $resideo_general_settings;

        if (function_exists('resideo_get_page_header')) {
            resideo_get_page_header($header_info);
        }

        $hide_page_title = get_post_meta($post_ID, 'page_title_hide', true);

        $content_wrapper_class = ' ';
        $page_title_margin = 'mt-100';
        $container_margin = 'mt-100';

        if ($header_type == 'none' || $header_type == '') {
            $content_wrapper_class = 'pxp-content-wrapper mt-100';
            $page_title_margin = '';
            $container_margin = '';
        } ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="<?php echo esc_attr($content_wrapper_class); ?>">
                <div class="container <?php echo esc_attr($container_margin); ?>">
                    <div class="row justify-content-center">
                        <div class="<?php echo esc_attr($content_column_class); ?>">
                            <div class="page-content">
                                <?php the_content(); ?>
                            </div>
                            <div class="clearfix"></div>
                            <?php wp_link_pages(
                                array(
                                    'before'      => '<div class="pagination pxp-paginantion mt-2 mt-md-4">',
                                    'after'       => '</div>',
                                    'link_before' => '<span>',
                                    'link_after'  => '</span>',
                                    'pagelink'    => '%',
                                    'separator'   => '',
                                )
                            ); ?>

                            <div class="pxp-page-comments">
                                <?php if (comments_open() || get_comments_number()) {
                                    comments_template();
                                } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
