<?php

declare(strict_types=1);

namespace App\Domain;

class Employee
{
    private string $firstName;
    private string $lastName;
    private Department $department;
    private int $baseSalary;

    public function __construct(string $firstName, string $lastName, Department $department, int $baseSalary)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->department = $department;
        $this->baseSalary = $baseSalary;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function getBaseSalary(): int
    {
        return $this->baseSalary;
    }
}
