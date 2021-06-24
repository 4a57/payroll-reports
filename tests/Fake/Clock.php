<?php

declare(strict_types=1);

namespace Tests\Fake;

use App\Infrastructure\System\Clock as BaseClock;

class Clock extends BaseClock
{
    private static ?\DateTimeImmutable $dateTime;

    public static function setDateTime(\DateTimeImmutable $dateTime): void
    {
        self::$dateTime = $dateTime;
    }

    public function getDateTime(): \DateTimeImmutable
    {
        return self::$dateTime ?? parent::getDateTime();
    }
}
