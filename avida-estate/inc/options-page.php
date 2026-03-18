<?php
/**
 * ACF/SCF Options Page — Site Settings
 *
 * @package AvidaEstate
 */

if (!function_exists('acf_add_options_page')) {
    return;
}

acf_add_options_page([
    'page_title' => 'Avida Estate Settings',
    'menu_title' => 'Avida Settings',
    'menu_slug'  => 'avida-settings',
    'capability' => 'manage_options',
    'icon_url'   => 'dashicons-building',
    'position'   => 59,
    'redirect'   => false,
]);

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key'    => 'group_avida_footer',
    'title'  => 'Footer Settings',
    'fields' => [

        // ── Contact ──
        [
            'key'   => 'field_footer_tab_contact',
            'label' => 'Contact',
            'name'  => '',
            'type'  => 'tab',
        ],
        [
            'key'           => 'field_footer_phone',
            'label'         => 'Phone',
            'name'          => 'footer_phone',
            'type'          => 'text',
            'default_value' => '+34 952 766 950',
        ],
        [
            'key'           => 'field_footer_email',
            'label'         => 'Email',
            'name'          => 'footer_email',
            'type'          => 'text',
            'default_value' => 'info@drumelia.com',
        ],
        [
            'key'           => 'field_footer_address',
            'label'         => 'Address',
            'name'          => 'footer_address',
            'type'          => 'textarea',
            'rows'          => 5,
            'default_value' => "Drumelia Headquarters Office\nCentro de Negocios Puerta de Banus\nEdificio B, Local 11\n29660 Marbella",
        ],
        [
            'key'   => 'field_footer_contact_page',
            'label' => 'Contact Page Link',
            'name'  => 'footer_contact_page',
            'type'  => 'link',
        ],

        // ── Navigation ──
        [
            'key'   => 'field_footer_tab_nav',
            'label' => 'Navigation',
            'name'  => '',
            'type'  => 'tab',
        ],
        [
            'key'          => 'field_footer_nav',
            'label'        => 'Navigation Links',
            'name'         => 'footer_nav',
            'type'         => 'repeater',
            'layout'       => 'table',
            'button_label' => 'Add Link',
            'sub_fields'   => [
                [
                    'key'   => 'field_footer_nav_link',
                    'label' => 'Link',
                    'name'  => 'link',
                    'type'  => 'link',
                ],
            ],
        ],
        [
            'key'          => 'field_footer_collection',
            'label'        => 'Collection Links',
            'name'         => 'footer_collection',
            'type'         => 'repeater',
            'layout'       => 'table',
            'button_label' => 'Add Link',
            'sub_fields'   => [
                [
                    'key'   => 'field_footer_col_link',
                    'label' => 'Link',
                    'name'  => 'link',
                    'type'  => 'link',
                ],
            ],
        ],

        // ── Social ──
        [
            'key'   => 'field_footer_tab_social',
            'label' => 'Social',
            'name'  => '',
            'type'  => 'tab',
        ],
        [
            'key'   => 'field_footer_linkedin',
            'label' => 'LinkedIn URL',
            'name'  => 'footer_linkedin',
            'type'  => 'url',
        ],
        [
            'key'   => 'field_footer_instagram',
            'label' => 'Instagram URL',
            'name'  => 'footer_instagram',
            'type'  => 'url',
        ],
        [
            'key'   => 'field_footer_youtube',
            'label' => 'YouTube URL',
            'name'  => 'footer_youtube',
            'type'  => 'url',
        ],

        // ── Awards ──
        [
            'key'   => 'field_footer_tab_awards',
            'label' => 'Awards',
            'name'  => '',
            'type'  => 'tab',
        ],
        [
            'key'          => 'field_footer_awards',
            'label'        => 'Award Badges',
            'name'         => 'footer_awards',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => 'Add Badge',
            'instructions' => 'Upload award/badge images (round seals etc.)',
            'sub_fields'   => [
                [
                    'key'           => 'field_footer_award_image',
                    'label'         => 'Image',
                    'name'          => 'image',
                    'type'          => 'image',
                    'return_format' => 'array',
                    'preview_size'  => 'thumbnail',
                ],
            ],
        ],

        // ── Legal ──
        [
            'key'   => 'field_footer_tab_legal',
            'label' => 'Legal',
            'name'  => '',
            'type'  => 'tab',
        ],
        [
            'key'           => 'field_footer_company',
            'label'         => 'Company Name',
            'name'          => 'footer_company',
            'type'          => 'text',
            'default_value' => 'Drumelia Real Estate',
        ],
        [
            'key'   => 'field_footer_terms_link',
            'label' => 'Terms of Use Link',
            'name'  => 'footer_terms_link',
            'type'  => 'link',
        ],
        [
            'key'   => 'field_footer_cookies_link',
            'label' => 'Cookies Policy Link',
            'name'  => 'footer_cookies_link',
            'type'  => 'link',
        ],
        [
            'key'           => 'field_footer_credits',
            'label'         => 'Built by',
            'name'          => 'footer_credits',
            'type'          => 'text',
            'default_value' => 'Inmoba',
        ],

        // ── Subscribe ──
        [
            'key'   => 'field_footer_tab_subscribe',
            'label' => 'Subscribe',
            'name'  => '',
            'type'  => 'tab',
        ],
        [
            'key'           => 'field_footer_subscribe_heading',
            'label'         => 'Subscribe Heading',
            'name'          => 'footer_subscribe_heading',
            'type'          => 'text',
            'default_value' => 'Subscribe to Our News',
        ],
        [
            'key'           => 'field_footer_subscribe_action',
            'label'         => 'Form Action URL',
            'name'          => 'footer_subscribe_action',
            'type'          => 'url',
            'instructions'  => 'Mailchimp / newsletter form action URL. Leave empty for default.',
        ],
        [
            'key'           => 'field_footer_privacy_text',
            'label'         => 'Consent Text',
            'name'          => 'footer_privacy_text',
            'type'          => 'text',
            'default_value' => 'I agree to receive info by email and I accept the privacy policy',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'options_page',
                'operator' => '==',
                'value'    => 'avida-settings',
            ],
        ],
    ],
]);
