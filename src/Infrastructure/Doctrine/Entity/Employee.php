<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'employees')]
class Employee
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $lastName;

    #[ORM\ManyToOne(targetEntity: Department::class)]
    private Department $department;

    #[ORM\Column(type: 'integer')]
    private int $baseSalary;

    #[ORM\Column(type: 'datetime_immutable')]
    private int $hiredAt;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        Department $department,
        int $baseSalary,
        int $hiredAt
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

    public function getHiredAt(): int
    {
        return $this->hiredAt;
    }
}
