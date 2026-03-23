<?php
/**
 * ACF fields for Rentals block.
 */

acf_add_local_field_group([
    'key'      => 'group_rentals_block',
    'title'    => 'Rental Properties',
    'fields'   => [
        [
            'key'           => 'field_rentals_title',
            'label'         => 'Page Title',
            'name'          => 'rentals_title',
            'type'          => 'text',
            'default_value' => 'Rental Properties',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/rentals',
            ],
        ],
    ],
]);
