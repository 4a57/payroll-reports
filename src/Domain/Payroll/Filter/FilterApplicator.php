<?php

declare(strict_types=1);

namespace App\Domain\Payroll\Filter;

use App\Domain\Payroll\PayrollView;

class FilterApplicator
{
    /**
     * @param PayrollView[] $payrollViews
     * @return PayrollView[]
     */
    public function filter(array $payrollViews, string $filter): array
    {
        return \array_values(
            \array_filter($payrollViews, fn($payrollView) => $this->checkValue($filter, $payrollView))
        );
    }

    private function checkValue(string $filter, PayrollView $view): bool
    {
        $filterHaystack = \sprintf('%s %s %s', $view->department, $view->firstName, $view->lastName);

        return \str_contains(\mb_strtolower($filterHaystack), \mb_strtolower($filter));
    }
}
