<?php

declare(strict_types=1);

namespace App\Domain;

class Department
{
    private int $id;
    private string $name;
    private BonusType $bonusType;
    private int $bonusValue;

    public function __construct(int $id, string $name, BonusType $bonusType, int $bonusValue)
    {
        $this->id = $id;
        $this->name = $name;
        $this->bonusType = $bonusType;
        $this->bonusValue = $bonusValue;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
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
