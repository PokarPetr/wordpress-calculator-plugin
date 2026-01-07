<?php
/**
 * Plugin Name: Calculator
 * Description: Калькулятор для страниц WordPress через блок Gutenberg.
 * Version: 1.0.0
 * Author: Petr
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define('CALCULATOR_PLUGIN_FILE', __FILE__);
define('CALCULATOR_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('CALCULATOR_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CALCULATOR_PLUGIN_BASENAME', plugin_basename(__FILE__));

spl_autoload_register(function ($class_name) {
    $class_name = strtolower( str_replace( '_', '-', $class_name ) );

    $file = CALCULATOR_PLUGIN_PATH . 'includes/class-' . strtolower($class_name) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

Init::instance();