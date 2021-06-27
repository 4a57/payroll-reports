<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Payroll\Filter;

use App\Domain\Payroll\Filter\FilterApplicator;
use App\Domain\Payroll\PayrollView;
use PHPUnit\Framework\TestCase;

class FilterApplicatorTest extends TestCase
{
    private const EMPLOYEE_ADAM = 'Adam';
    private const EMPLOYEE_ANIA = 'Ania';
    private const EMPLOYEE_KRZYSZTOF = 'Krzysztof';

    /**
     * @test
     * @dataProvider getSortingCases
     */
    public function it_should_sort_int_value(int $expectedCount, ?string $expectedName, string $filter): void
    {
        $data = [
            new PayrollView(self::EMPLOYEE_ADAM, 'Kowalski', 'HR', 100000, 100000, 'fixed', 200000),
            new PayrollView(self::EMPLOYEE_ANIA, 'Nowak', 'Customer Service', 110000, 11000, 'percentage', 121000),
            new PayrollView(self::EMPLOYEE_KRZYSZTOF, 'Kowal', 'HRops', 200000, 5000, 'fixed', 205000),
        ];

        $filterApplicator = new FilterApplicator();
        $filteredData = $filterApplicator->filter($data, $filter);

        $this->assertCount($expectedCount, $filteredData);
        $this->assertSame($expectedName, isset($filteredData[0]) ? $filteredData[0]->firstName : null);
    }

    public function getSortingCases(): array
    {
        return [
            'Ada' => [
                'expected count'  => 1,
                'expected result' => self::EMPLOYEE_ADAM,
                'filter'          => 'Ada',
            ],
            'HR' => [
                'expected count'  => 2,
                'expected result' => self::EMPLOYEE_ADAM,
                'filter'          => 'HR',
            ],
            'hr' => [
                'expected count'  => 2,
                'expected result' => self::EMPLOYEE_ADAM,
                'filter'          => 'hr',
            ],
            'Kowal' => [
                'expected count'  => 2,
                'expected result' => self::EMPLOYEE_ADAM,
                'filter'          => 'Kowal',
            ],
            'Customer' => [
                'expected count'  => 1,
                'expected result' => self::EMPLOYEE_ANIA,
                'filter'          => 'Customer',
            ],
            'hr Adam' => [
                'expected count'  => 1,
                'expected result' => self::EMPLOYEE_ADAM,
                'filter'          => 'hr Adam',
            ],
            'ow' => [
                'expected count'  => 3,
                'expected result' => self::EMPLOYEE_ADAM,
                'filter'          => 'ow',
            ],
            'asdqwezxc' => [
                'expected count'  => 0,
                'expected result' => null,
                'filter'          => 'asdqwezxc',
            ],
        ];
    }
}
