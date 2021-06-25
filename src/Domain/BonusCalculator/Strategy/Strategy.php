<?php

declare(strict_types=1);

namespace App\Domain\BonusCalculator\Strategy;

use App\Domain\BonusType;

interface Strategy
{
    public function supports(BonusType $bonusType): bool;

    public function calculateBonus(int $salary, int $bonusValue, int $yearsOfService): int;
}
