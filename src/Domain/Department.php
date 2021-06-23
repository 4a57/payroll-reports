<?php

declare(strict_types=1);

namespace Domain;

class Department
{
    private int $name;
    private BonusType $bonusType;
    private int $bonusValue;

    public function __construct(int $name, BonusType $bonusType, int $bonusValue)
    {
        $this->name = $name;
        $this->bonusType = $bonusType;
        $this->bonusValue = $bonusValue;
    }

    public function getName(): int
    {
        return $this->name;
    }

    public function getBonusType(): BonusType
    {
        return $this->bonusType;
    }

    public function getBonusValue(): int
    {
        return $this->bonusValue;
    }
}
