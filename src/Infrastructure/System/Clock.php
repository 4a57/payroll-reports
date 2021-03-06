<?php

declare(strict_types=1);

namespace App\Infrastructure\System;

use App\Domain\Clock as DomainClock;

class Clock implements DomainClock
{
    public function getDateTime(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }

    public function getDiffInYears(\DateTimeImmutable $date): int
    {
        $currentDate = $this->getDateTime();
        $diff = $currentDate->diff($date)->y;

        return $currentDate > $date ? $diff : -$diff;
    }
}
