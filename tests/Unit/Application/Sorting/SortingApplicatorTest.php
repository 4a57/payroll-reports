<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Sorting;

use App\Application\PayrollView;
use App\Application\Sorting\Sorting;
use App\Application\Sorting\SortingApplicator;
use App\Application\Sorting\SortingDirection;
use App\Application\Sorting\SortingField;
use PHPUnit\Framework\TestCase;

class SortingApplicatorTest extends TestCase
{
    private const EMPLOYEE_ADAM = 'Adam';
    private const EMPLOYEE_ANIA = 'Ania';

    /**
     * @test
     * @dataProvider getSortingCases
     */
    public function it_should_sort_int_value(string $expectedNameOnTop, Sorting $sort): void
    {
        $data = [
            new PayrollView(self::EMPLOYEE_ADAM, 'Kowalski', 'HR', 100000, 100000, 'fixed', 200000),
            new PayrollView(self::EMPLOYEE_ANIA, 'Nowak', 'Customer Service', 110000, 11000, 'percentage', 121000),
        ];

        $sortingApplicator = new SortingApplicator();
        $sortedData = $sortingApplicator->sort($data, $sort);

        $this->assertSame($expectedNameOnTop, $sortedData[0]->firstName);
    }

    public function getSortingCases(): array
    {
        return [
            'first name ASC'       => [
                'expected top' => self::EMPLOYEE_ADAM,
                'sort'         => new Sorting(SortingField::FIRST_NAME(), SortingDirection::ASC()),
            ],
            'first name DESC'      => [
                'expected top' => self::EMPLOYEE_ANIA,
                'sort'         => new Sorting(SortingField::FIRST_NAME(), SortingDirection::DESC()),
            ],
            'last name ASC'        => [
                'expected top' => self::EMPLOYEE_ADAM,
                'sort'         => new Sorting(SortingField::LAST_NAME(), SortingDirection::ASC()),
            ],
            'last name DESC'       => [
                'expected top' => self::EMPLOYEE_ANIA,
                'sort'         => new Sorting(SortingField::LAST_NAME(), SortingDirection::DESC()),
            ],
            'department name ASC'  => [
                'expected top' => self::EMPLOYEE_ANIA,
                'sort'         => new Sorting(SortingField::DEPARTMENT_NAME(), SortingDirection::ASC()),
            ],
            'department name DESC' => [
                'expected top' => self::EMPLOYEE_ADAM,
                'sort'         => new Sorting(SortingField::DEPARTMENT_NAME(), SortingDirection::DESC()),
            ],
            'base salary ASC'      => [
                'expected top' => self::EMPLOYEE_ADAM,
                'sort'         => new Sorting(SortingField::BASE_SALARY(), SortingDirection::ASC()),
            ],
            'base salary DESC'     => [
                'expected top' => self::EMPLOYEE_ANIA,
                'sort'         => new Sorting(SortingField::BASE_SALARY(), SortingDirection::DESC()),
            ],
            'bonus salary ASC'     => [
                'expected top' => self::EMPLOYEE_ANIA,
                'sort'         => new Sorting(SortingField::BONUS_SALARY(), SortingDirection::ASC()),
            ],
            'bonus salary DESC'    => [
                'expected top' => self::EMPLOYEE_ADAM,
                'sort'         => new Sorting(SortingField::BONUS_SALARY(), SortingDirection::DESC()),
            ],
            'bonus type ASC'       => [
                'expected top' => self::EMPLOYEE_ADAM,
                'sort'         => new Sorting(SortingField::BONUS_TYPE(), SortingDirection::ASC()),
            ],
            'bonus type DESC'      => [
                'expected top' => self::EMPLOYEE_ANIA,
                'sort'         => new Sorting(SortingField::BONUS_TYPE(), SortingDirection::DESC()),
            ],
            'total salary ASC'     => [
                'expected top' => self::EMPLOYEE_ANIA,
                'sort'         => new Sorting(SortingField::TOTAL_SALARY(), SortingDirection::ASC()),
            ],
            'total salary DESC'    => [
                'expected top' => self::EMPLOYEE_ADAM,
                'sort'         => new Sorting(SortingField::TOTAL_SALARY(), SortingDirection::DESC()),
            ],
        ];
    }
}
