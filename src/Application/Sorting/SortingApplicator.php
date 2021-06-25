<?php

declare(strict_types=1);

namespace App\Application\Sorting;

use App\Application\PayrollView;

class SortingApplicator
{
    /**
     * @param PayrollView[] $payrollViews
     * @return PayrollView[]
     */
    public function sort(array $payrollViews, Sorting $sort): array
    {
        usort($payrollViews, fn($a, $b) => $this->compare($sort, $a, $b));

        return $payrollViews;
    }

    private function compare(Sorting $sort, PayrollView $view1, PayrollView $view2): int
    {
        $sortingField = $sort->getField()->getValue();

        $value1 = $view1->$sortingField;
        $value2 = $view2->$sortingField;

        if ($sort->getDirection()->equals(SortingDirection::ASC())) {
            $a = $value1;
            $b = $value2;
        } else {
            $a = $value2;
            $b = $value1;
        }

        return \is_int($a) ? $a - $b : \strcmp($a, $b);
    }
}
