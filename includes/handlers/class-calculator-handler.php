<?php

class Calculator_Handler {
    public Calculator $calculator;

    public function __construct(Calculator $calculator) {
        $this->calculator = $calculator;
    }

    public function handle($request) {   
        $num1 = $this->get_float($request, 'num1');
        $num2 = $this->get_float($request, 'num2');
        $operation = $this->get_operation($request, 'operation');
        
        return $this->calculator->calculate($num1, $num2, $operation);
    }

    private function get_float($request, string $key) {
        return (float) $request->get_param($key);
    }

    private function get_operation($request, string $key) {
        return sanitize_text_field($request->get_param($key));
    }
}
