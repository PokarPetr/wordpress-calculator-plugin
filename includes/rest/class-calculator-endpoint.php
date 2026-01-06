<?php

class Calculator_Endpoint {
  public function __construct() {
    $this->register();
  }

  public function register() {
    register_rest_route('calculator/v1', '/calc', [
          'methods'  => 'POST',
          'callback' => [$this, 'rest_handler'],
          'permission_callback' => function($request) {
              return isset($_SERVER['HTTP_X_WP_NONCE']) &&
              wp_verify_nonce($_SERVER['HTTP_X_WP_NONCE'], 'wp_rest');
          },                        
      ]);
  }

  public function rest_handler($request) {
      return Calculator_Handler::handle($request);
  } 
}
