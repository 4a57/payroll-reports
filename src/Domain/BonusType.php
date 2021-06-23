<?php

declare(strict_types=1);

namespace Domain;

use MyCLabs\Enum\Enum;

class BonusType extends Enum
{
    private const FIXED = 1;
    private const PERCENTAGE = 2;
}
