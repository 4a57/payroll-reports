<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\BonusCalculator\Strategy;

use App\Domain\BonusCalculator\Strategy\PercentageStrategy;
use App\Domain\BonusType;
use PHPUnit\Framework\TestCase;

class PercentageStrategyTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_support_only_percentage_bonus()
    {
        $strategy = new PercentageStrategy();

        $this->assertTrue($strategy->supports(BonusType::PERCENTAGE()));
        $this->assertFalse($strategy->supports(BonusType::FIXED()));
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
        $strategy = new PercentageStrategy();

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
                'bonus value'      => 10,
                'years of service' => 3,
                'expected bonus'   => 200,
            ],
            '100 years' => [
                'base salary'      => 1000,
                'bonus value'      => 10,
                'years of service' => 100,
                'expected bonus'   => 100,
            ],
            '1 year, ceil' => [
                'base salary'      => 1111,
                'bonus value'      => 10,
                'years of service' => 1,
                'expected bonus'   => 112,
            ],
        ];
    }
}
