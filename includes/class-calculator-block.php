<?php

class Calculator_Block {

    private string $mode = 'rest';

    public function __construct() {
        add_action('init', [$this, 'register']);
        if ($this->mode === 'rest') add_action('rest_api_init', [$this, 'rest_register']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
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

    public function rest_register() {      

         foreach (glob(plugin_dir_path(__DIR__) . 'includes/rest/*.php') as $file) {
            require_once $file;
            
            $class_name = pathinfo($file, PATHINFO_FILENAME);
            $class_name = str_replace('class-', '', $class_name);
            $class_name = str_replace('-', '_', $class_name);

            if (class_exists($class_name)) {
                new $class_name();
            }
        }

    }

    public function enqueue_assets() {

        $file = $this->mode === 'ajax' ? 'calc-front-ajax.js' : 'calc-front.js';
        $handle = 'calculator-front';
        wp_enqueue_script(
        $handle,
        plugins_url('../assets/js/' . $file, __FILE__),
        [],
        false,
        true        
        );

        wp_enqueue_style(
            $handle,
            plugins_url( '../assets/css/calc.css', __FILE__ ),
            [],
            null
        );

        $object_name = 'CalculatorRest';
        $url_name = 'rest_url';
        $url = esc_url(rest_url('calculator/v1/calc'));
        $nonce_name = 'wp_rest';

        if ($this->mode === 'ajax') {
            $object_name = 'CalculatorAjax';
            $url_name = 'ajax_url';
            $url = admin_url( 'admin-ajax.php' );
            $nonce_name = 'ajax_nonce';
        }        
        wp_localize_script(            
            $handle,
            $object_name,
            [
                $url_name => $url,
                'nonce'   => wp_create_nonce( $nonce_name ),
            ]
        );
    }
}

