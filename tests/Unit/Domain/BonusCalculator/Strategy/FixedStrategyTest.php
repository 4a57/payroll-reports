<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\BonusCalculator\Strategy;

use App\Domain\BonusCalculator\Strategy\FixedStrategy;
use App\Domain\BonusType;
use PHPUnit\Framework\TestCase;

class FixedStrategyTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_support_only_fixed_bonus()
    {
        $strategy = new FixedStrategy();

        $this->assertTrue($strategy->supports(BonusType::FIXED()));
        $this->assertFalse($strategy->supports(BonusType::PERCENTAGE()));
    }

    /**
     * @test
     * @dataProvider getBonusData
     */
    public function it_should_calculate_bonus(
        int $baseSalary,
        int $bonusValue,
        int $yearsOfService,
        int $expectedBonus
    ): void {
        $strategy = new FixedStrategy();

        $bonus = $strategy->calculateBonus($baseSalary, $bonusValue, $yearsOfService);
        $this->assertSame($expectedBonus, $bonus);
    }

    public function getBonusData(): array
    {
        return [
            '0'       => [
                'base salary'      => 0,
                'bonus value'      => 0,
                'years of service' => 0,
                'expected bonus'   => 0,
            ],
            '0 years' => [
                'base salary'      => 1000,
                'bonus value'      => 0,
                'years of service' => 0,
                'expected bonus'   => 0,
            ],
            '3 years' => [
                'base salary'      => 2000,
                'bonus value'      => 100,
                'years of service' => 3,
                'expected bonus'   => 300,
            ],
            '100 years' => [
                'base salary'      => 1000,
                'bonus value'      => 10,
                'years of service' => 100,
                'expected bonus'   => 100,
            ],
            '3 year, cents' => [
                'base salary'      => 1111,
                'bonus value'      => 111,
                'years of service' => 3,
                'expected bonus'   => 333,
            ],
        ];
    }
}
