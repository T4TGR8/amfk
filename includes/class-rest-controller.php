<?php
add_action('rest_api_init', function () {
    register_rest_route('hetvegi-kalandmento/v1', '/programs', [
        'methods'  => WP_REST_Server::READABLE,
        'callback' => 'get_programs',
    ]);
});

function get_programs()
{
    // External data
    $file = plugin_dir_path(__DIR__) . 'data/programs.json';

    if (!file_exists($file)) {
        return new WP_Error(
            'program_data_missing',
            'Program data is unavailable.',
            ['status' => 500]
        );
    }

    $json = file_get_contents($file);
    $data = json_decode($json, true);

    if (!is_array($data) || !isset($data['programs'])) {
        return new WP_Error(
            'program_data_invalid',
            'Program data is invalid.',
            ['status' => 500]
        );
    }

    return $data;
}