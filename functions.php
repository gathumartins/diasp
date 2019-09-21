<?php

add_action( 'wp_enqueue_scripts', 'diaspora_styles');

function diaspora_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css');
}

$script_loc = get_template_directory_uri() . '/dist/';
if( defined('WP_ENV') && 'LOCAL' === WP_ENV ){
    $script_loc = '//localhost:4200/';
}

$scripts = [
    [
        'key' => 'runtime',
        'script' => 'runtime.js'
    ],
    [
        'key' => 'polyfills',
        'script' => 'polyfills.js'
    ],
    [
        'key' => 'styles',
        'script' => 'styles.js'
    ],
    [
        'key' => 'vendor',
        'script' => 'vendor.js'
    ],
    [
        'key' => 'main',
        'script' => 'main.js'
    ]
    ];
    foreach( $scripts as $key => $value ){
        $prev_key = ( $key > 0 ) ? $scripts[$key-1] ['key'] : 'jquery';
        wp_enqueue_script( $value['key'], $script_loc . $value['script'], array( $prev_key ), 1.0, true);
    }

    add_action( 'wp_head', 'add_base_href', 99);
    function add_base_href(){
        if( is_front_page() ){
            echo '<base href="/">';
        }
    }