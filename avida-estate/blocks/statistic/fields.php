<?php
/**
 * Statistic Block — ACF Fields
 *
 * @package AvidaEstate
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key'    => 'group_statistic_block',
    'title'  => 'Statistic Block',
    'fields' => [
        [
            'key'          => 'field_statistic_items',
            'label'        => 'Items',
            'name'         => 'statistic_items',
            'type'         => 'repeater',
            'layout'       => 'table',
            'button_label' => 'Add Item',
            'min'          => 1,
            'max'          => 8,
            'sub_fields'   => [
                [
                    'key'   => 'field_statistic_value',
                    'label' => 'Value',
                    'name'  => 'value',
                    'type'  => 'text',
                    'instructions' => 'e.g. 10+, 500+, 4',
                ],
                [
                    'key'   => 'field_statistic_label',
                    'label' => 'Label',
                    'name'  => 'label',
                    'type'  => 'text',
                    'instructions' => 'e.g. Years of Excellence',
                ],
            ],
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/statistic',
            ],
        ],
    ],
]);
