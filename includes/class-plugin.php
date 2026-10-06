<?php

add_shortcode('hetvegi_kalandmento', 'render');

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_script(
        'tailwindcss',
        'https://cdn.tailwindcss.com',
        [],
        null,
        false
    );

    wp_enqueue_script(
        'hkm-programs',
        plugins_url('assets/js/frontend.js', __DIR__),
        [],
        '1.0.0'
    );
});


function render()
{
    // From URL to get webpage contents.
    $url = get_option('hkm_api_url', '');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    if (empty($result)) {
        return;
    }

    $data = json_decode($result, true);
    if (empty($data) || empty($data['programs'])) {
        return;
    }

    include_once(__DIR__ . '/class-program-repository.php');
    $programs = ProgramRepository::normalizePrograms($data['programs'], $data['reference_time']);

    ob_start();
    include(__DIR__ . '/../templates/programs.php');
    return ob_get_clean();
}