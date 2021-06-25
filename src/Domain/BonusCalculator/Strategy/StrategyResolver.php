<?php

declare(strict_types=1);

namespace App\Domain\BonusCalculator\Strategy;

use App\Domain\BonusType;

class StrategyResolver
{
    /** @var Strategy[] */
    private array $strategies;

    public function __construct(Strategy ...$strategies)
    {
        $this->strategies = $strategies;
    }

    /**
     * @throws BonusCalculatorStrategyException
     */
    public function resolve(BonusType $bonusType): Strategy
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($bonusType)) {
                return $strategy;
            }
        }

        throw BonusCalculatorStrategyException::strategyNotFound($bonusType);
    }
}
