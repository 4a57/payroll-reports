<?php

declare(strict_types=1);

namespace App\Domain\BonusCalculator\Strategy;

use App\Domain\BonusType;
use App\Domain\DomainException;
use Throwable;

class BonusCalculatorStrategyException extends DomainException
{
    private function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function strategyNotFound(BonusType $bonusType): self
    {
        return new self(\sprintf('Strategy not found for bonus type %s', $bonusType->getValue()));
    }
}
