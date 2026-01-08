<?php

class Calculator {
  public function calculate($num1, $num2, $operation) {

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
            
            case 'power':
                if ($num1 == 0 && $num2 < 0) {
                    return ['error' => 'Cannot raise zero to a negative power'];
                }
                if (abs($num1 ** $num2) > PHP_FLOAT_MAX) {
                    return ['error' => 'Result too large'];
                }
                $result = $num1 ** $num2;
                break;

            default:
                return [
                    'error' => 'Unknown operation'
                ];
        }

        return [
            'result' => round($result, 6)
        ];
    }
}