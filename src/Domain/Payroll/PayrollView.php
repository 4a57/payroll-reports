<?php

declare(strict_types=1);

namespace App\Domain\Payroll;

class PayrollView
{
    public string $firstName;
    public string $lastName;
    public string $department;
    public int $baseSalary;
    public int $bonusSalary;
    public string $bonusType;
    public int $totalSalary;

    public function __construct(
        string $name,
        string $surname,
        string $department,
        int $baseSalary,
        int $bonusSalary,
        string $bonusType,
        int $totalSalary
    ) {
        $this->firstName = $name;
        $this->lastName = $surname;
        $this->department = $department;
        $this->baseSalary = $baseSalary;
        $this->bonusSalary = $bonusSalary;
        $this->bonusType = $bonusType;
        $this->totalSalary = $totalSalary;
    }
}
