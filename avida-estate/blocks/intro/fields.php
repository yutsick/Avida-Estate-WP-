<?php
/**
 * Intro Block — SCF Fields
 *
 * @package AvidaEstate
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key'    => 'group_intro_block',
    'title'  => 'Intro Block',
    'fields' => [
        [
            'key'         => 'field_intro_heading',
            'label'       => 'Heading',
            'name'        => 'intro_heading',
            'type'        => 'text',
            'placeholder' => 'Most Recognized Luxury Real Estate Agency in Marbella',
        ],
        [
            'key'         => 'field_intro_description',
            'label'       => 'Description',
            'name'        => 'intro_description',
            'type'        => 'textarea',
            'rows'        => 5,
            'placeholder' => 'With 20 years of expertise...',
        ],
        [
            'key'         => 'field_intro_theme',
            'label'       => 'Block theme',
            'name'  => 'intro_theme',
            'type'  => 'button_group',
            'choices' => [
                'light' => 'Light',
                'dark'  => 'Dark',
            ],
            'default_value' => 'light',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/intro',
            ],
        ],
    ],
]);
