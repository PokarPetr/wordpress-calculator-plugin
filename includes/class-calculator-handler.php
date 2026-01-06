<?php

class Calculator_Handler {
    public static function handle($request) {
      $handler = new self();
      return $handler->calculate($request);
    }

    public function calculate($request) {
        $num1 = (float) $request->get_param('num1');
        $num2 = (float) $request->get_param('num2');
        $operation = sanitize_text_field($request->get_param('operation'));

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
                if ($num2 == 0) {
                    return [
                        'error' => 'Division by zero'
                    ];
                }
                $result = $num1 / $num2;
                break;

            default:
                return [
                    'error' => 'Unknown operation'
                ];
        }

        return [
            'result' => round($result, 4)
        ];
    }
}
