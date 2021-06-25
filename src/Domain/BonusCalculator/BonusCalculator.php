<?php

declare(strict_types=1);

namespace App\Domain\BonusCalculator;

use App\Domain\BonusCalculator\Strategy\StrategyResolver;
use App\Domain\BonusType;

class BonusCalculator
{
    private StrategyResolver $resolver;

    public function __construct(StrategyResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @throws Strategy\BonusCalculatorStrategyException
     */
    public function calculateBonus(int $salary, BonusType $bonusType, int $bonusValue, int $yearsOfService): int
    {
        return $this->resolver->resolve($bonusType)->calculateBonus($salary, $bonusValue, $yearsOfService);
    }
}
