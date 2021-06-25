<?php

declare(strict_types=1);

namespace Unit\Infrastructure\System;

use App\Infrastructure\System\Clock;
use PHPUnit\Framework\TestCase;

class ClockTest extends TestCase
{
    public function getDatesToDiff(): array
    {
        return [
            '5 years ago'   => ['expected diff' => 5, new \DateTimeImmutable('-5 years')],
            '100 days ago'  => ['expected diff' => 0, new \DateTimeImmutable('-100 days')],
            '300 days ago'  => ['expected diff' => 0, new \DateTimeImmutable('-300 days')],
            '500 days ago'  => ['expected diff' => 1, new \DateTimeImmutable('-500 days')],
            '5 years after' => ['expected diff' => -1, new \DateTimeImmutable('+500 days')],
        ];
    }

    /**
     * @test
     * @dataProvider getDatesToDiff
     */
    public function it_should_return_diff_in_years(int $expectedDiff, \DateTimeImmutable $dateToDiff)
    {
        $clock = new Clock();
        $diff = $clock->getDiffInYears($dateToDiff);

        $this->assertSame($expectedDiff, $diff);
    }
}
