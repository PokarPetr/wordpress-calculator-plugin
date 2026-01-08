<?php

class Calculator_Ajax {
    public function __construct() {
        add_action( 'wp_ajax_calculate', [ $this, 'handle' ] );
        add_action( 'wp_ajax_nopriv_calculate', [ $this, 'handle' ] );
    }

    public function handle() {
    check_ajax_referer('ajax_nonce', 'nonce');

    $num1 = isset($_POST['num1']) ? floatval($_POST['num1']) : 0;
    $num2 = isset($_POST['num2']) ? floatval($_POST['num2']) : 0;
    $operation = $_POST['operation'] ?? '';

    switch ($operation) {
        case 'add':
            $result = $num1 + $num2;
            break;
        case 'subtract':
            $result = $num1 - $num2;
            break;
        case 'multiply':
            $result = $num1 * $num2;
            break;
        case 'divide':
            $result = ($num2 != 0) ? $num1 / $num2 : 'Error: division by zero';
            break;
        default:
            $result = 'Unknown operation';
    }

    if (is_numeric($result)) {
        $result = round($result, 4);
    }

    wp_send_json_success([
        'result' => $result,
    ]);
  }

}
