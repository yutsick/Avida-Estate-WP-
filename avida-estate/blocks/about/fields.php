<?php
/**
 * About Block — SCF Fields
 *
 * @package AvidaEstate
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key'    => 'group_about_block',
    'title'  => 'About Block',
    'fields' => [
        [
            'key'          => 'field_about_text',
            'label'        => 'Description',
            'name'         => 'about_text',
            'type'         => 'wysiwyg',
            'tabs'         => 'all',
            'toolbar'      => 'basic',
            'media_upload' => 0,
            'instructions' => 'Company description text.',
        ],
        [
            'key'   => 'field_about_cta',
            'label' => 'CTA Link',
            'name'  => 'about_cta',
            'type'  => 'link',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/about',
            ],
        ],
    ],
]);
