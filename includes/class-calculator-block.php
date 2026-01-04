<?php

class Calculator_Block {

    public function __construct() {
        add_action('init', [$this, 'register']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
    }

    public function register() {
        wp_register_script(
            'calculator-block-js',
            plugins_url('../assets/js/calc-block.js', __FILE__),
            ['wp-blocks', 'wp-element', 'wp-block-editor', 'wp-server-side-render',]
        );

        wp_register_style(
            'calculator-block-css',
            plugins_url('../assets/css/calc.css', __FILE__),
            []
        );

        register_block_type('calculator/block', [
            'editor_script'   => 'calculator-block-js',
            'editor_style'    => 'calculator-block-css',
            'style'           => 'calculator-block-css',
            'render_callback' => [$this, 'render']
        ]);
    }



    public function render($attributes) {
        ob_start();

        include plugin_dir_path( __DIR__ ) . 'templates/calc.php';
        
        return ob_get_clean();
    }

    public function enqueue() {
        wp_enqueue_script(
        'calculator-front-js',
        plugins_url('../assets/js/calc-front.js', __FILE__),
        [],
        false,
        true        
        );

        wp_localize_script(
        'calculator-front-js',
        'CalculatorAjax',
        [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'calculator_nonce' ),
        ]
        );
    }
}

