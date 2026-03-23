<?php
/**
 * Hero Block — SCF Fields
 *
 * @package AvidaEstate
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key'    => 'group_hero_block',
    'title'  => 'Hero Block',
    'fields' => [
        [
            'key'           => 'field_hero_image',
            'label'         => 'Background Image',
            'name'          => 'hero_image',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'medium',
            'library'       => 'all',
            'mime_types'    => 'jpg, jpeg, png, webp',
            'instructions'  => 'Recommended size: 1920×1080 or larger.',
        ],
        [
            'key'          => 'field_hero_tagline',
            'label'        => 'Tagline',
            'name'         => 'hero_tagline',
            'type'         => 'text',
            'placeholder'  => 'Whether you\'re buying, selling or renting, we can help you move forward.',
        ],
        [
            'key'          => 'field_hero_subtitle',
            'label'        => 'Subtitle',
            'name'         => 'hero_subtitle',
            'type'         => 'text',
            'instructions' => 'Optional text displayed below the tagline.',
        ],
        [
            'key'           => 'field_hero_big_title',
            'label'         => 'Big Title',
            'name'          => 'hero_big_title',
            'type'          => 'true_false',
            'ui'            => 1,
            'default_value' => 0,
            'instructions'  => 'Enable for large Noto Serif Display title style.',
        ],
        [
            'key'   => 'field_hero_button_1',
            'label' => 'Button 1',
            'name'  => 'hero_button_1',
            'type'  => 'link',
        ],
        [
            'key'   => 'field_hero_button_2',
            'label' => 'Button 2',
            'name'  => 'hero_button_2',
            'type'  => 'link',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/hero',
            ],
        ],
    ],
]);
