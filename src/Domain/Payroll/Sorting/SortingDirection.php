<?php

declare(strict_types=1);

namespace App\Domain\Payroll\Sorting;

use MyCLabs\Enum\Enum;

/**
 * @method static SortingDirection ASC()
 * @method static SortingDirection DESC()
 */
class SortingDirection extends Enum
{
    private const ASC = 'asc';
    private const DESC = 'desc';
}
