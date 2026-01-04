<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Init {

    public function __construct() {
        $this->register_services();
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
