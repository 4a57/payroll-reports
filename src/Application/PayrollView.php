<?php

declare(strict_types=1);

namespace App\Application;

class PayrollView
{
    private string $firstName;
    private string $lastName;
    private string $departmentName;
    private int $baseSalary;
    private int $bonusSalary;
    private string $bonusType;
    private int $totalSalary;

    public function __construct(
        string $name,
        string $surname,
        string $departmentName,
        int $baseSalary,
        int $bonusSalary,
        string $bonusType,
        int $totalSalary
    ) {
        $this->firstName = $name;
        $this->lastName = $surname;
        $this->departmentName = $departmentName;
        $this->baseSalary = $baseSalary;
        $this->bonusSalary = $bonusSalary;
        $this->bonusType = $bonusType;
        $this->totalSalary = $totalSalary;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getDepartmentName(): string
    {
        return $this->departmentName;
    }

    public function getBaseSalary(): int
    {
        return $this->baseSalary;
    }

    public function getBonusSalary(): int
    {
        return $this->bonusSalary;
    }

    public function getBonusType(): string
    {
        return $this->bonusType;
    }

    public function getTotalSalary(): int
    {
        return $this->totalSalary;
    }
}
