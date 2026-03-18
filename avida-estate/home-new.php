<?php
/*
Template Name: Home new
*/

/**
 * @package WordPress
 * @subpackage Resideo
 */

global $post;
$data = array(
    'is_transparent' => true
);
get_header('new');

$resideo_general_settings = get_option('resideo_general_settings'); ?>

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
        $page_margin_bottom = get_post_meta($post_ID, 'page_margin_bottom', true);

        $container_margin = '';
        $content_wrapper_class = '';
        $page_title_margin = '';

        if ($header_type == 'none' || $header_type == '') {
            $content_wrapper_class = 'pxp-content-wrapper pt-0';
            $container_margin = '';
            $page_title_margin = '';
        } ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="<?php echo esc_attr($content_wrapper_class); ?>">
                <?php if (!is_front_page() && $hide_page_title != '1') { 
                    $container_margin = 'mt-4 mt-md-5'; ?>

                    <div class="container <?php echo esc_attr($page_title_margin); ?>">
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                <h1 class="pxp-page-header"><?php echo get_the_title(); ?></h1>
                            </div>
                        </div>
                    </div>
                <?php } else {
                    $container_margin = '';
                } ?>

                <div class="<?php echo esc_attr($container_margin); ?>">
                    <?php the_content(); ?>
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
                </div>
            </div>
        </div>

        <?php if(comments_open() || get_comments_number()) { ?>
            <div class="container">
                <?php comments_template(); ?>
            </div>
        <?php }
    endwhile; ?>
</div>

<?php 
    get_footer('new');

  ?>