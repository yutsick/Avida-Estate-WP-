<?php
/**
 * Image CTA Block — ACF Fields
 *
 * @package AvidaEstate
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key'    => 'group_image_cta_block',
    'title'  => 'Image CTA Block',
    'fields' => [
        [
            'key'   => 'field_image_cta_heading',
            'label' => 'Heading',
            'name'  => 'image_cta_heading',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_image_cta_subtitle',
            'label' => 'Subtitle',
            'name'  => 'image_cta_subtitle',
            'type'  => 'text',
        ],
        [
            'key'           => 'field_image_cta_image',
            'label'         => 'Background Image',
            'name'          => 'image_cta_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
        ],
        [
            'key'           => 'field_image_cta_button_text',
            'label'         => 'Button Text',
            'name'          => 'image_cta_button_text',
            'type'          => 'text',
            'default_value' => 'Call Us',
        ],
        [
            'key'          => 'field_image_cta_form_id',
            'label'        => 'Form Shortcode / ID',
            'name'         => 'image_cta_form_id',
            'type'         => 'text',
            'instructions' => 'Paste the form shortcode, e.g. [wpforms id="123"]',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/image-cta',
            ],
        ],
    ],
]);
