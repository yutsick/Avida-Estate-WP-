<?php
/*
Template Name: Resales Test
*/

get_header();

// Your fixed API URL:
$api_url = 'https://webapi.resales-online.com/V6/SearchProperties?P1=1032175&P2=6d66b1f85b87de77282b113cbad36408a3774f0d&P_ApiId=63895&p_PageSize=10';
//$api_url = 'https://webapi.resales-online.com/V6/PropertyDetails?P1=1032175&P2=51486350168cabc637af5d5fa32e16409341a032&P_ApiId=63886&P_RefId=R5055154';

// Make the GET request:
$response = wp_remote_get($api_url, [
    'headers' => [
        'Content-Type' => 'application/json'
    ],
    'timeout' => 15,
    'sslverify' => false,
]);

echo '<div style="padding:2rem;font-family:monospace;">';

if (is_wp_error($response)) {
    echo '<h2>HTTP Error</h2>';
    echo '<pre>' . esc_html($response->get_error_message()) . '</pre>';
} else {
    $body = wp_remote_retrieve_body($response);

    echo '<h2>Decoded API Response</h2>';
    $json = json_decode($body, true);

    if ($json === null) {
        echo '<strong>Failed to parse JSON!</strong>';
    } else {
        echo '<pre>' . esc_html(print_r($json, true)) . '</pre>';
    }

    echo '<h2>Raw API Response</h2>';
    echo '<textarea style="width:100%;height:300px;">' . esc_textarea($body) . '</textarea>';
}
echo '</div>';

get_footer();
?>