<?php

class Calculator {
    public function calculate($num1, $num2, $operation) {

        switch ($operation) {
            case 'add':
                return $this->add($num1, $num2);

            case 'subtract':
                return $this->subtract($num1, $num2);

            case 'multiply':
                return $this->multiply($num1, $num2);

            case 'divide':
                return $this->divide($num1, $num2);
            
            case 'power':
                return $this->power($num1, $num2);

            default:
                return [
                    'error' => 'Unknown operation'
                ];
        }
    }

    private function add(float $a, float $b): array {
        return $this->success($a + $b);
    }

    private function subtract(float $a, float $b): array {
        return $this->success($a - $b);
    }

    private function multiply(float $a, float $b): array {
        $result = $a * $b;

        if (abs($result) > PHP_FLOAT_MAX) {
            return ['error' => 'Result too large'];
        }
        return $this->success($result);
    }

    private function divide(float $a, float $b): array {
        if ($b == 0.0) {
            return ['error' => 'Division by zero'];
        }

        return $this->success($a / $b);
    }

    private function power(float $a, float $b): array {
        if ($a == 0 && $b < 0) {
            return ['error' => 'Cannot raise zero to a negative power'];
        }

        $result = $a ** $b;

        if (abs($result) > PHP_FLOAT_MAX) {
            return ['error' => 'Result too large'];
        }        

        return $this->success($result);
    }

    private function success(float $value): array {
        return ['result' => round($value, 6)];
    }
}