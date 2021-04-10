<?php

function sfc_load_scripts()
{
    // load css
    wp_enqueue_style('sfc-style', get_stylesheet_uri(), array(), SFC_VERSION);
    wp_enqueue_style('sfc-main-style', get_stylesheet_directory_uri() . '/dist/styles/app.min.css', array('sfc-style'), SFC_VERSION);
    // load js
    wp_enqueue_script('sfc-script', get_stylesheet_directory_uri() . '/dist/scripts/app.min.js', array("jquery"), SFC_VERSION, true);
    // localize scripts
    wp_localize_script(
        'sfc-script',
        'wp_data',
        array(
            'root_url' => get_site_url(),
            'template_url' => get_stylesheet_directory_uri(),
            'nonce' => wp_create_nonce('wp_rest'),
        )
    );
}


add_action('wp_enqueue_scripts', 'sfc_load_scripts');
