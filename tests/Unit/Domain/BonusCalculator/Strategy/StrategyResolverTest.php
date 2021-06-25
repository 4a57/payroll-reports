<?php

declare(strict_types=1);

namespace Unit\Domain\BonusCalculator\Strategy;

use App\Domain\BonusCalculator\Strategy\BonusCalculatorStrategyException;
use App\Domain\BonusCalculator\Strategy\FixedStrategy;
use App\Domain\BonusCalculator\Strategy\PercentageStrategy;
use App\Domain\BonusCalculator\Strategy\StrategyResolver;
use App\Domain\BonusType;
use PHPUnit\Framework\TestCase;

class StrategyResolverTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_throw_exception_if_not_supported_strategy_found()
    {
        $this->expectException(BonusCalculatorStrategyException::class);

        $resolver = new StrategyResolver(new PercentageStrategy());
        $resolver->resolve(BonusType::FIXED());
    }

    /**
     * @test
     */
    public function it_should_found_strategy()
    {
        $resolver = new StrategyResolver(new PercentageStrategy(), new FixedStrategy());

        $this->assertInstanceOf(PercentageStrategy::class, $resolver->resolve(BonusType::PERCENTAGE()));
        $this->assertInstanceOf(FixedStrategy::class, $resolver->resolve(BonusType::FIXED()));
    }
}
