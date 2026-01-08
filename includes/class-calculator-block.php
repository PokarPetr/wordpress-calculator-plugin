<?php

class Calculator_Block {

    private string $mode = 'rest';
    private string $js_dir;
    private string $css_dir;
    private string $template_dir;
    private string $rest_namespace;
    private string $block_handle;
    private string $block_script;
    private string $block_style;
    private array $enqueue_data = [];

    public function __construct() {
        $this->js_dir = CALCULATOR_PLUGIN_URL . "assets/js/";
        $this->css_dir = CALCULATOR_PLUGIN_URL . "assets/css/";
        $this->template_dir = CALCULATOR_PLUGIN_PATH . "templates/";
        $this->rest_namespace = "calculator/v1/";
        $this->block_handle = "calculator-block";
        $this->block_script = $this->js_dir . "calc-block.js";
        $this->block_style = $this->css_dir . "calc.css";

        add_action('init', [$this, 'register']);

        if ($this->mode === 'rest') {

            $this->rest_data();

            add_action('rest_api_init', [$this, 'rest_register']);

        } else {

            $this->ajax_data();

            add_action('wp_loaded', [$this, 'ajax_register']);

        }
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

    public function render() {
        ob_start();

            include $this->template_dir . 'calc.php';
        
        return ob_get_clean();
    }

    public function rest_data() {
        $this->enqueue_data = [
            'file' => 'calc-front.js',
            'handle' => 'calculator-front',
            'object_name' => 'CalculatorRest',
            'url_name'    => 'rest_url',
            'nonce_name'  => 'wp_rest'
        ];
    }

    public function ajax_data() {
        $this->enqueue_data = [
            'file' => 'calc-front-ajax.js',
            'handle' => 'calculator-front',
            'object_name' => 'CalculatorAjax',
            'url_name' => 'ajax_url',
            'nonce_name' => 'ajax_nonce'
        ];
    }

    public function rest_register() {
        $this->loader(CALCULATOR_PLUGIN_PATH . 'includes/rest/');               
    }

    public function ajax_register() {
        $this->loader(CALCULATOR_PLUGIN_PATH . 'includes/ajax/');
    }

    public function loader(string $dir) {

        foreach (glob($dir . 'class-*.php') as $file) {

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
        wp_enqueue_script(
            $this->enqueue_data['handle'],
            $this->js_dir . $this->enqueue_data['file'],
            [],
            false,
            true        
        );

        wp_enqueue_style(
            $this->enqueue_data['handle'],
            $this->block_style,
            [],
            null
        ); 
        
        if ($this->mode === 'rest') {
            $url = esc_url(rest_url($this->rest_namespace . 'calc'));
        } else {
            $url = admin_url( 'admin-ajax.php' );
        }

        wp_localize_script(            
            $this->enqueue_data['handle'],
            $this->enqueue_data['object_name'],
            [
                $this->enqueue_data['url_name'] => $url,
                'nonce'   => wp_create_nonce( $this->enqueue_data['nonce_name'] ),
            ]
        );
    }
}

