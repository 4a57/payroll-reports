<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Sorting\Sorting;

class GetPayrollReportQuery
{
    private Sorting $sorting;

    public function __construct(Sorting $sorting)
    {
        $this->sorting = $sorting;
    }

    public function getSorting(): Sorting
    {
        return $this->sorting;
    }
}
