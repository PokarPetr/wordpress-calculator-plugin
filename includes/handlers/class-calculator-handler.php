<?php

class Calculator_Handler {
    public static function handle($request) {   
        $num1 = (float) $request->get_param('num1');
        $num2 = (float) $request->get_param('num2');
        $operation = sanitize_text_field($request->get_param('operation'));
        $calculator = new Calculator();
        return $calculator->calculate($num1, $num2, $operation);
    }    
}
