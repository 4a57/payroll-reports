<?php

declare(strict_types=1);

namespace App\Domain\BonusCalculator\Strategy;

use App\Domain\BonusType;

class FixedStrategy implements Strategy
{
    private const MAX_YEARS_TO_CALCULATE = 10;

    public function supports(BonusType $bonusType): bool
    {
        return $bonusType->equals(BonusType::FIXED());
    }

    public function calculateBonus(int $salary, int $bonusValue, int $yearsOfService): int
    {
        $yearsToCalculate = \min($yearsOfService, self::MAX_YEARS_TO_CALCULATE);

        return $bonusValue * $yearsToCalculate;
    }
}
