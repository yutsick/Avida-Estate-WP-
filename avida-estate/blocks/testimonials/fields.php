<?php
/**
 * Testimonials Block — SCF Fields
 *
 * @package AvidaEstate
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key'    => 'group_testimonials_block',
    'title'  => 'Testimonials Block',
    'fields' => [
        [
            'key'           => 'field_test_heading',
            'label'         => 'Heading',
            'name'          => 'test_heading',
            'type'          => 'text',
            'default_value' => 'People Trust Us',
        ],
        [
            'key'   => 'field_test_heading_link',
            'label' => 'Heading Link',
            'name'  => 'test_heading_link',
            'type'  => 'link',
            'instructions' => 'Arrow link next to the heading (e.g. to all reviews page).',
        ],
        [
            'key'           => 'field_test_items',
            'label'         => 'Testimonials',
            'name'          => 'test_items',
            'type'          => 'relationship',
            'post_type'     => ['testimonial'],
            'filters'       => ['search'],
            'return_format' => 'id',
            'min'           => 1,
            'max'           => 20,
            'instructions'  => 'Select testimonials to display. Leave empty to show latest.',
        ],
        [
            'key'           => 'field_test_count',
            'label'         => 'Count (if no selection)',
            'name'          => 'test_count',
            'type'          => 'number',
            'default_value' => 9,
            'min'           => 3,
            'max'           => 30,
            'instructions'  => 'Number of latest testimonials if none selected above.',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/testimonials',
            ],
        ],
    ],
]);
