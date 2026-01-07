<?php

class Calculator_Block {

    private string $mode = 'rest';
    private string $js_dir;
    private string $css_dir;
    private string $template_dir;
    private string $rest_namespase;
    private string $block_handle;
    private string $block_script;
    private string $block_style;

    public function __construct() {
        $this->js_dir = CALCULATOR_PLUGIN_URL . "assets/js/";
        $this->css_dir = CALCULATOR_PLUGIN_URL . "assets/css/";
        $this->template_dir = CALCULATOR_PLUGIN_PATH . "templates/";
        $this->rest_namespase = "calculator/v1";
        $this->block_handle = "calculator-block";
        $this->block_script = $this->js_dir . "calc-block.js";
        $this->block_style = $this->css_dir . "calc.css";

        add_action('init', [$this, 'register']);
        if ($this->mode === 'rest') add_action('rest_api_init', [$this, 'rest_register']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function register() {
        wp_register_script(
            $this->block_handle . '-js',
            $this->block_script,
            ['wp-blocks', 'wp-element', 'wp-block-editor', 'wp-server-side-render',]
        );

        wp_register_style(
            $this->block_handle . '-css',
            $this->block_style,
            []
        );

        register_block_type('calculator/block', [
            'editor_script'   => $this->block_handle . '-js',
            'editor_style'    => $this->block_handle . '-css',
            'style'           => $this->block_handle . '-css',
            'render_callback' => [$this, 'render']
        ]);
    }

    public function render($attributes) {
        ob_start();

        include $this->template_dir . 'calc.php';
        
        return ob_get_clean();
    }

    public function rest_register() {      

         foreach (glob(CALCULATOR_PLUGIN_PATH . 'includes/rest/*.php') as $file) {
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
            $this->js_dir . $file,
            [],
            false,
            true        
        );

        wp_enqueue_style(
            $handle,
            $this->block_style,
            [],
            null
        );        

        if ($this->mode === 'ajax') {
            $object_name = 'CalculatorAjax';
            $url_name = 'ajax_url';
            $url = admin_url( 'admin-ajax.php' );
            $nonce_name = 'ajax_nonce';
        } else {
            $object_name = 'CalculatorRest';
            $url_name    = 'rest_url';
            $url         = esc_url(rest_url($this->rest_namespase . 'calc'));
            $nonce_name  = 'wp_rest';
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

