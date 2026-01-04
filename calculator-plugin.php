<?php
/**
 * Plugin Name: Calculator
 * Description: Калькулятор для страниц WordPress через блок Gutenberg.
 * Version: 1.0.0
 * Author: Petr
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once plugin_dir_path( __FILE__ ) . 'includes/functions.php';

spl_autoload_register(function ($class_name) {
    $class_name = strtolower( str_replace( '_', '-', $class_name ) );

    $file = plugin_dir_path(__FILE__) . 'includes/class-' . strtolower($class_name) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

Init::instance();