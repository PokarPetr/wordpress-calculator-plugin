<?php
if ( ! defined( 'ABSPATH' ) ) exit;

final class Init {

    private static $instance = null;

    public static function instance() {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        $this->register_services();
    }

    private function __clone() {}

    public function __wakeup() {
        throw new \Exception('Cannot unserialize singleton');
    }

    private function register_services() {

        $config = require_once CALCULATOR_PLUGIN_PATH . 'includes/config/services.php';

        if(!empty($config['blocks'])) {
            foreach($config['blocks'] as $service) {
              new $service();
            }
        }        
    }
}
