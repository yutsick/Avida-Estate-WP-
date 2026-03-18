<?php
/**
 * Latest Posts Block — SCF Fields
 *
 * @package AvidaEstate
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key'    => 'group_latest_posts_block',
    'title'  => 'Latest Posts Block',
    'fields' => [
        [
            'key'           => 'field_lp_heading',
            'label'         => 'Heading',
            'name'          => 'lp_heading',
            'type'          => 'text',
            'default_value' => 'Latest Updates in Avida Estate Real Estate',
        ],
        [
            'key'   => 'field_lp_heading_link',
            'label' => 'Heading Link',
            'name'  => 'lp_heading_link',
            'type'  => 'link',
            'instructions' => 'Arrow link next to the heading (e.g. to blog archive).',
        ],
        [
            'key'           => 'field_lp_count',
            'label'         => 'Number of Posts',
            'name'          => 'lp_count',
            'type'          => 'number',
            'default_value' => 8,
            'min'           => 2,
            'max'           => 20,
        ],
        [
            'key'           => 'field_lp_category',
            'label'         => 'Category',
            'name'          => 'lp_category',
            'type'          => 'taxonomy',
            'taxonomy'      => 'category',
            'field_type'    => 'select',
            'allow_null'    => 1,
            'return_format' => 'id',
            'instructions'  => 'Optional: filter by category.',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/latest-posts',
            ],
        ],
    ],
]);
