<?php
/**
 * ACF fields for Page Hero block.
 */

acf_add_local_field_group([
    'key'      => 'group_page_hero_block',
    'title'    => 'Page Hero',
    'fields'   => [
        [
            'key'           => 'field_page_hero_image',
            'label'         => 'Background Image',
            'name'          => 'page_hero_image',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'large',
            'required'      => 1,
        ],
        [
            'key'           => 'field_page_hero_title',
            'label'         => 'Title',
            'name'          => 'page_hero_title',
            'type'          => 'text',
            'instructions'  => 'Leave empty to use the page title.',
        ],
        [
            'key'          => 'field_page_hero_subtitle',
            'label'        => 'Subtitle',
            'name'         => 'page_hero_subtitle',
            'type'         => 'text',
            'instructions' => 'Optional subtitle under the title.',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/page-hero',
            ],
        ],
    ],
]);
