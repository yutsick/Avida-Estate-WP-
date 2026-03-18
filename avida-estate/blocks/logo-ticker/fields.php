<?php
/**
 * Logo Ticker Block — SCF Fields
 *
 * @package AvidaEstate
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key'    => 'group_logo_ticker_block',
    'title'  => 'Logo Ticker Block',
    'fields' => [
        [
            'key'           => 'field_ticker_logos',
            'label'         => 'Logos',
            'name'          => 'ticker_logos',
            'type'          => 'repeater',
            'layout'        => 'block',
            'button_label'  => 'Add Logo',
            'instructions'  => 'Upload partner/client logos. Recommended: transparent PNG or SVG.',
            'sub_fields'    => [
                [
                    'key'           => 'field_ticker_logo_image',
                    'label'         => 'Logo',
                    'name'          => 'logo',
                    'type'          => 'image',
                    'return_format' => 'array',
                    'preview_size'  => 'thumbnail',
                    'library'       => 'all',
                    'mime_types'    => 'jpg, jpeg, png, svg, webp',
                ],
            ],
        ],
        [
            'key'           => 'field_ticker_background',
            'label'         => 'Background Color',
            'name'          => 'ticker_background',
            'type'          => 'color_picker',
            'default_value' => '#002C23',
        ],
        [
            'key'           => 'field_ticker_speed',
            'label'         => 'Scroll Speed (seconds)',
            'name'          => 'ticker_speed',
            'type'          => 'number',
            'default_value' => 30,
            'min'           => 5,
            'max'           => 120,
            'instructions'  => 'Duration for one full loop. Lower = faster.',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/logo-ticker',
            ],
        ],
    ],
]);
