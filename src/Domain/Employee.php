<?php

declare(strict_types=1);

namespace App\Domain;

class Employee
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private Department $department;
    private int $baseSalary;
    private \DateTimeImmutable $hiredAt;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        Department $department,
        int $baseSalary,
        \DateTimeImmutable $hiredAt
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->department = $department;
        $this->baseSalary = $baseSalary;
        $this->hiredAt = $hiredAt;
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getHiredAt(): \DateTimeImmutable
    {
        return $this->hiredAt;
    }
}
