<?php
/**
 * ACF fields for Properties Listing block.
 */

acf_add_local_field_group([
    'key'      => 'group_properties_block',
    'title'    => 'Properties Listing',
    'fields'   => [
        [
            'key'   => 'field_properties_title',
            'label' => 'Page Title',
            'name'  => 'properties_title',
            'type'  => 'text',
            'default_value' => 'Properties',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/properties',
            ],
        ],
    ],
]);
