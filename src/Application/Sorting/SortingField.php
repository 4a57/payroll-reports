<?php

declare(strict_types=1);

namespace App\Application\Sorting;

use MyCLabs\Enum\Enum;

/**
 * @method static SortingField FIRST_NAME()
 * @method static SortingField LAST_NAME()
 * @method static SortingField DEPARTMENT_NAME()
 * @method static SortingField BASE_SALARY()
 * @method static SortingField BONUS_SALARY()
 * @method static SortingField BONUS_TYPE()
 * @method static SortingField TOTAL_SALARY()
 */
class SortingField extends Enum
{
    private const FIRST_NAME = 'firstName';
    private const LAST_NAME = 'lastName';
    private const DEPARTMENT_NAME = 'departmentName';
    private const BASE_SALARY = 'baseSalary';
    private const BONUS_SALARY = 'bonusSalary';
    private const BONUS_TYPE = 'bonusType';
    private const TOTAL_SALARY = 'totalSalary';
}
