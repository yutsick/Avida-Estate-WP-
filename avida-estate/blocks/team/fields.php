<?php
/**
 * Team Block — ACF Fields
 *
 * @package AvidaEstate
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key'    => 'group_team_block',
    'title'  => 'Team Block',
    'fields' => [
        [
            'key'           => 'field_team_heading',
            'label'         => 'Heading',
            'name'          => 'team_heading',
            'type'          => 'text',
            'default_value' => 'Meet the Team',
        ],
        [
            'key'          => 'field_team_subtitle',
            'label'        => 'Subtitle',
            'name'         => 'team_subtitle',
            'type'         => 'text',
            'instructions' => 'Optional subtitle under the heading.',
        ],
        [
            'key'   => 'field_team_heading_link',
            'label' => 'Heading Link',
            'name'  => 'team_heading_link',
            'type'  => 'link',
            'instructions' => 'Arrow link next to the heading (e.g. to the team page).',
        ],
        [
            'key'           => 'field_team_display_mode',
            'label'         => 'Display Mode',
            'name'          => 'team_display_mode',
            'type'          => 'button_group',
            'choices'       => [
                'grid'   => 'Grid',
                'slider' => 'Slider',
            ],
            'default_value' => 'grid',
            'layout'        => 'horizontal',
        ],
        [
            'key'           => 'field_team_show_all',
            'label'         => 'Show All (manual cards)',
            'name'          => 'team_show_all',
            'type'          => 'true_false',
            'ui'            => 1,
            'default_value' => 0,
            'instructions'  => 'If enabled, shows ALL agents regardless of type.',
        ],
        [
            'key'            => 'field_team_members',
            'label'          => 'Select Agents',
            'name'           => 'team_members',
            'type'           => 'relationship',
            'post_type'      => ['agent'],
            'filters'        => ['search'],
            'return_format'  => 'id',
            'min'            => 0,
            'max'            => '',
            'instructions'   => 'Pick specific agents to display.',
            'conditional_logic' => [
                [
                    [
                        'field'    => 'field_team_show_all',
                        'operator' => '!=',
                        'value'    => '1',
                    ],
                ],
            ],
        ],
        [
            'key'           => 'field_team_show_owners',
            'label'         => 'Show Owners',
            'name'          => 'team_show_owners',
            'type'          => 'true_false',
            'ui'            => 1,
            'default_value' => 0,
            'instructions'  => 'If enabled, displays owners in a separate chess-pattern section above agents.',
            'conditional_logic' => [
                [
                    [
                        'field'    => 'field_team_show_all',
                        'operator' => '!=',
                        'value'    => '1',
                    ],
                ],
            ],
        ],
        [
            'key'   => 'field_team_owners_title',
            'label' => 'Owners Section Title',
            'name'  => 'team_owners_title',
            'type'  => 'text',
            'instructions'  => 'Title for the owners block. Can be empty.',
            'conditional_logic' => [
                [
                    [
                        'field'    => 'field_team_show_owners',
                        'operator' => '==',
                        'value'    => '1',
                    ],
                    [
                        'field'    => 'field_team_show_all',
                        'operator' => '!=',
                        'value'    => '1',
                    ],
                ],
            ],
        ],
        [
            'key'   => 'field_team_owners_subtitle',
            'label' => 'Owners Section Subtitle',
            'name'  => 'team_owners_subtitle',
            'type'  => 'text',
            'instructions'  => 'Subtitle for the owners block. Can be empty.',
            'conditional_logic' => [
                [
                    [
                        'field'    => 'field_team_show_owners',
                        'operator' => '==',
                        'value'    => '1',
                    ],
                    [
                        'field'    => 'field_team_show_all',
                        'operator' => '!=',
                        'value'    => '1',
                    ],
                ],
            ],
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'avidaestate/team',
            ],
        ],
    ],
]);
