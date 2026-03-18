<?php
/**
 * Property Slider Block — SCF Fields
 *
 * @package AvidaEstate
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key'    => 'group_property_slider_block',
    'title'  => 'Property Slider Block',
    'fields' => [
        [
            'key'         => 'field_ps_heading',
            'label'       => 'Heading',
            'name'        => 'ps_heading',
            'type'        => 'text',
            'placeholder' => 'Exclusive Listings to Avida Estate',
        ],
        [
            'key'   => 'field_ps_heading_link',
            'label' => 'Heading Link',
            'name'  => 'ps_heading_link',
            'type'  => 'link',
            'instructions' => 'Arrow link next to the heading.',
        ],
        [
            'key'           => 'field_ps_post_type',
            'label'         => 'Content Type',
            'name'          => 'ps_post_type',
            'type'          => 'select',
            'choices'       => [
                'property' => 'Properties',
                'post'     => 'Posts (Blog / News)',
            ],
            'default_value' => 'property',
            'instructions'  => 'Which content to show in the slider.',
        ],
        [
            'key'           => 'field_ps_items',
            'label'         => 'Items',
            'name'          => 'ps_items',
            'type'          => 'relationship',
            'post_type'     => ['property', 'post'],
            'filters'       => ['search'],
            'return_format' => 'id',
            'min'           => 0,
            'max'           => 20,
            'instructions'  => 'Pick specific items. Leave empty to auto-fetch latest based on Content Type.',
        ],
        [
            'key'           => 'field_ps_count',
            'label'         => 'Auto-fetch Count',
            'name'          => 'ps_count',
            'type'          => 'number',
            'default_value' => 8,
            'min'           => 1,
            'max'           => 20,
            'instructions'  => 'How many items to show when none selected above.',
        ],
        [
            'key'           => 'field_ps_category',
            'label'         => 'Category (Posts only)',
            'name'          => 'ps_category',
            'type'          => 'taxonomy',
            'taxonomy'      => 'category',
            'field_type'    => 'select',
            'allow_null'    => 1,
            'return_format' => 'id',
            'instructions'  => 'Filter posts by category. Only applies when Content Type = Posts and no manual selection.',
        ],
        [
            'key'           => 'field_ps_mode',
            'label'         => 'Mode',
            'name'          => 'ps_mode',
            'type'          => 'select',
            'choices'       => [
                'slider'    => 'Simple Slider (links to property)',
                'gallery'   => 'Gallery (click to preview)',
                'paginated' => 'Paginated (4 thumbs + 1 featured per page)',
            ],
            'default_value' => 'slider',
            'instructions'  => 'Simple: horizontal scroll, links to property. Gallery: click thumbnail to show large preview. Paginated: auto-groups by 5 (4 small + 1 featured), arrow navigation.',
        ],
        [
            'key'           => 'field_ps_style',
            'label'         => 'Style',
            'name'          => 'ps_style',
            'type'          => 'select',
            'choices'       => [
                'color'     => 'Color',
                'grayscale' => 'Grayscale (Sold)',
            ],
            'default_value' => 'color',
        ],
        [
            'key'           => 'field_ps_bg_color',
            'label'         => 'Background Color',
            'name'          => 'ps_bg_color',
            'type'          => 'color_picker',
            'default_value' => '#ffffff',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/property-slider',
            ],
        ],
    ],
]);
