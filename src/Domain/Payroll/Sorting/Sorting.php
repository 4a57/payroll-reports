<?php

declare(strict_types=1);

namespace App\Domain\Payroll\Sorting;

class Sorting
{
    private SortingField $field;
    private SortingDirection $direction;

    public function __construct(SortingField $field, SortingDirection $direction)
    {
        $this->field = $field;
        $this->direction = $direction;
    }

    public function getField(): SortingField
    {
        return $this->field;
    }

    public function getDirection(): SortingDirection
    {
        return $this->direction;
    }
}
