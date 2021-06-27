<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Payroll\Filter\Filter;
use App\Domain\Payroll\Sorting\Sorting;

class GetPayrollReportQuery
{
    private Sorting $sorting;
    private ?string $filter;

    public function __construct(Sorting $sorting, ?string $filter = null)
    {
        $this->sorting = $sorting;
        $this->filter = $filter;
    }

    public function getSorting(): Sorting
    {
        return $this->sorting;
    }

    public function getFilter(): ?string
    {
        return $this->filter;
    }
}
