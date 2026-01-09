<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

// require_once __DIR__ . '/../../includes/domain/class-calculator.php';

final class CalculatorTest extends TestCase {

    /**
     * @dataProvider successProvider
     */
    public function test_success_operations(
        float $a,
        float $b,
        string $operation,
        array $expected
    ): void {
        $calculator = new Calculator();

        $result = $calculator->calculate($a, $b, $operation);

        $this->assertSame($expected, $result);
    }

    /**
     * @dataProvider errorProvider
     */
    public function test_error_operations(
        float $a,
        float $b,
        string $operation,
        array $expected
    ): void {
        $calculator = new Calculator();

        $result = $calculator->calculate($a, $b, $operation);

        $this->assertSame($expected, $result);
    }

    public static function successProvider(): array
    {
        return [
            'add' => [
                2.0,
                3.0,
                'add',
                ['result' => 5.0],
            ],
            'subtract' => [
                5.0,
                3.0,
                'subtract',
                ['result' => 2.0],
            ],
            'multiply' => [
                2.5,
                4.0,
                'multiply',
                ['result' => 10.0],
            ],
            'divide' => [
                10.0,
                2.0,
                'divide',
                ['result' => 5.0],
            ],
            'power' => [
                2.0,
                3.0,
                'power',
                ['result' => 8.0],
            ],
            'rounding to 6 decimals' => [
                1.0,
                3.0,
                'divide',
                ['result' => 0.333333],
            ],
        ];
    }

    public static function errorProvider(): array
    {
        return [
            'division by zero' => [
                10.0,
                0.0,
                'divide',
                ['error' => 'Division by zero'],
            ],
            'unknown operation' => [
                1.0,
                1.0,
                'unknown',
                ['error' => 'Unknown operation'],
            ],
            'zero to negative power' => [
                0.0,
                -1.0,
                'power',
                ['error' => 'Cannot raise zero to a negative power'],
            ],
            'power overflow' => [
                10.0,
                400.0,
                'power',
                ['error' => 'Result too large'],
            ],
        ];
    }
}
