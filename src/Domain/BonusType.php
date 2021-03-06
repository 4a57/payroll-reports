<?php

declare(strict_types=1);

namespace App\Domain;

use MyCLabs\Enum\Enum;

/**
 * @method static BonusType FIXED()
 * @method static BonusType PERCENTAGE()
 */
class BonusType extends Enum
{
    private const FIXED = 'fixed';
    private const PERCENTAGE = 'percentage';
}
