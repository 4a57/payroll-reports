<?php

declare(strict_types=1);

namespace App\Domain\BonusCalculator\Strategy;

use App\Domain\BonusType;

class PercentageStrategy implements Strategy
{
    public function supports(BonusType $bonusType): bool
    {
        return $bonusType->equals(BonusType::PERCENTAGE());
    }

    public function calculateBonus(int $salary, int $bonusValue, int $yearsOfService): int
    {
        return (int) \ceil($salary * $bonusValue / 100);
    }
}
