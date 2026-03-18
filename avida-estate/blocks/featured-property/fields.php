<?php
/**
 * Featured Property Block — SCF Fields
 *
 * @package AvidaEstate
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key'    => 'group_featured_property_block',
    'title'  => 'Featured Property Block',
    'fields' => [
        [
            'key'           => 'field_fp_image',
            'label'         => 'Background Image',
            'name'          => 'fp_image',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
            'mime_types'    => 'jpg, jpeg, png, webp',
            'instructions'  => 'High-res property photo. Recommended: 1920×1080+.',
        ],
        [
            'key'         => 'field_fp_price',
            'label'       => 'Price',
            'name'        => 'fp_price',
            'type'        => 'text',
            'placeholder' => '€7,500,000',
        ],
        [
            'key'         => 'field_fp_title',
            'label'       => 'Title',
            'name'        => 'fp_title',
            'type'        => 'text',
            'placeholder' => 'Elegant Mediterranean Villa with Timeless Charm in Sierra Blanca',
        ],
        [
            'key'         => 'field_fp_description',
            'label'       => 'Description',
            'name'        => 'fp_description',
            'type'        => 'textarea',
            'rows'        => 4,
        ],
        [
            'key'   => 'field_fp_link',
            'label' => 'Property Link',
            'name'  => 'fp_link',
            'type'  => 'link',
            'instructions' => 'Link to the property detail page.',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/featured-property',
            ],
        ],
    ],
]);
