<?php
if ( ! defined( 'ABSPATH' ) ) exit;

final class Init {

    private static ?Init $instance = null;

    public static function instance(): Init {
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
        $services = [
            Calculator_Block::class,
            Calculator_Ajax::class,
        ];

        foreach ( $services as $service ) {
            new $service();
        }
    }
}
