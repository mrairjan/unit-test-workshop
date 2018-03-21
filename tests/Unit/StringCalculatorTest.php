<?php
/**
 * @copyright C UAB "NFQ Solutions" 2018
 *
 * This Software is the property of "Net Frequency"
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB "NFQ Solutions":
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 *
 */
declare(strict_types=1);

namespace Tests\Unit\StringCalculatorTest;

use Logger\LoggerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class StringCalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function add_returns_zero_with_empty_string()
    {
        $sc = $this->make();

        $numbers = '';
        $expectedResult = 0;

        $result = $sc->add($numbers);
        $this->assertSame($expectedResult, $result);
    }

    /**
     * @test
     */
    public function add_returns_same_number_with_one_number()
    {
        $sc = $this->make();

        $numbers = '1';
        $expectedResult = 1;

        $result = $sc->add($numbers);
        $this->assertSame($expectedResult, $result);
    }

    /**
     * @test
     * @dataProvider two_numbers_string_provider
     */
    public function add_returns_numbers_sum_with_two_numbers(string $numbers, int $expectedResult)
    {
        $sc = $this->make();
        $result = $sc->add($numbers);
        $this->assertSame($expectedResult, $result);
    }

    public function two_numbers_string_provider()
    {
        return [
            ["1,2", 3],
            ["2,2", 4],
            ["3,4", 7],
        ];
    }

    /**
     * @test
     * @dataProvider multiple_numbers_provider
     */
    public function add_returns_numbers_sum_with_multiple_numbers(string $numbers, int $expectedResult)
    {
        $sc = $this->make();
        $result = $sc->add($numbers);
        $this->assertSame($result, $expectedResult);
    }

    public function multiple_numbers_provider()
    {
        return [
            ["1,2,3", 6],
            ["2,2,4,4", 12],
            ["1,1,1,1,1", 5],
        ];
    }

    /**
     * @test
     */
    public function add_returns_numbers_sum_with_new_line_delimiter()
    {
        $sc = $this->make();
        
        $numbers = '1\n2,3';
        $expectedResult = 6;
        
        $result = $sc->add($numbers);
        $this->assertSame($result, $expectedResult);
    }

    /**
     * @test
     */
    public function add_returns_numbers_sum_with_specified_delimiter()
    {
        $sc = $this->make();
        $numbers = '//;\n1;2;3;4';
        $expectedResult = 10;
        
        $result = $sc->add($numbers);
        $this->assertSame($expectedResult, $result);
    }

    /**
     * @test
     */
    public function add_should_log_input_numbers()
    {
        $logger = $this->mockLogger();
        $sc = $this->make($logger);

        $numbers = '1,2,3';

        $logger->expects($this->at(0))
            ->method('log')
            ->with($numbers);

        $sc->add($numbers);
    }


    /**
     * @test
     */
    public function add_should_log_result()
    {
        $logger = $this->mockLogger();
        $sc = $this->make($logger);

        $numbers = '1,2,3';
        $result = 6;

        $logger->expects($this->at(1))
            ->method('log')
            ->with($result);

        $sc->add($numbers);
    }

    /**
     * @test
     */
    public function add_with_negative_numbers_throws_exception()
    {
        $sc = $this->make();

        $numbers = '-1,-2,3';

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Negative numbers');

        $sc->add($numbers);
    }

    protected function make(LoggerInterface $logger = null): \StringCalculator
    {
        $logger = $logger ?? $this->mockLogger();
        return new \StringCalculator($logger);
    }

    protected function mockLogger(): MockObject
    {
        return $this->createMock(LoggerInterface::class);
    }
}