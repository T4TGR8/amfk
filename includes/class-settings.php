<?php

add_action('admin_menu', static function (): void {
    add_options_page(
        'Hétvégi Kalandmentő',
        'Hétvégi Kalandmentő',
        'manage_options',
        'hkm-settings',
        'hkm_render_settings_page'
    );
});


add_action('admin_init', static function (): void {
    register_setting(
        'hkm_settings',
        'hkm_api_url',
        [
            'type'              => 'string',
            'sanitize_callback' => 'esc_url_raw',
            'default'           => '',
        ]
    );

    add_settings_section(
        'hkm_api_section',
        'API beállítások',
        static function (): void {
            echo '<p>Add meg a programokat szolgáltató külső API címét.</p>';
        },
        'hkm-settings'
    );

    add_settings_field(
        'hkm_api_url',
        'API URL',
        'hkm_render_api_url_field',
        'hkm-settings',
        'hkm_api_section'
    );
});


function hkm_render_api_url_field(): void
{
    $api_url = get_option('hkm_api_url', '');
    ?>

    <input
        type="url"
        name="hkm_api_url"
        value="<?= esc_attr($api_url); ?>"
        class="regular-text"
        placeholder="https://example.com/api/programs"
    >

    <p class="description">
        A programokat szolgáltató külső API teljes URL-je.
    </p>

    <?php
}


function hkm_render_settings_page(): void
{
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>

    <div class="wrap">
        <h1>Hétvégi Kalandmentő</h1>

        <form method="post" action="options.php">
            <?php
            settings_fields('hkm_settings');
            do_settings_sections('hkm-settings');
            submit_button('Beállítások mentése');
            ?>
        </form>
    </div>

    <?php
}