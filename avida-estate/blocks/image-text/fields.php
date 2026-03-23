<?php
/**
 * Image + Text Block — ACF Fields
 *
 * @package AvidaEstate
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key'    => 'group_image_text_block',
    'title'  => 'Image + Text Block',
    'fields' => [
        [
            'key'           => 'field_image_text_heading',
            'label'         => 'Heading',
            'name'          => 'image_text_heading',
            'type'          => 'text',
        ],
        [
            'key'           => 'field_image_text_content',
            'label'         => 'Content',
            'name'          => 'image_text_content',
            'type'          => 'wysiwyg',
            'tabs'          => 'all',
            'toolbar'       => 'full',
            'media_upload'  => 0,
        ],
        [
            'key'           => 'field_image_text_image',
            'label'         => 'Image',
            'name'          => 'image_text_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
        ],
        [
            'key'           => 'field_image_text_layout',
            'label'         => 'Image Position',
            'name'          => 'image_text_layout',
            'type'          => 'button_group',
            'choices'       => [
                'left'  => 'Image Left',
                'right' => 'Image Right',
            ],
            'default_value' => 'right',
            'layout'        => 'horizontal',
        ],
        [
            'key'           => 'field_image_text_spacing',
            'label'         => 'Spacing',
            'name'          => 'image_text_spacing',
            'type'          => 'select',
            'choices'       => [
                'both'   => 'Both (top + bottom)',
                'top'    => 'Top only',
                'bottom' => 'Bottom only',
                'none'   => 'None',
            ],
            'default_value' => 'both',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/image-text',
            ],
        ],
    ],
]);
