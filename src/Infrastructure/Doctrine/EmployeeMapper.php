<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Domain\Employee as DomainEmployee;
use App\Infrastructure\Doctrine\Entity\Employee;

class EmployeeMapper
{
    private DepartmentMapper $departmentMapper;

    public function __construct(DepartmentMapper $departmentMapper)
    {
        $this->departmentMapper = $departmentMapper;
    }

    public function mapToDomain(Employee $employee): DomainEmployee
    {
        return new DomainEmployee(
            $employee->getId(),
            $employee->getFirstName(),
            $employee->getLastName(),
            $this->departmentMapper->mapToDomain($employee->getDepartment()),
            $employee->getBaseSalary(),
            $employee->getHiredAt()
        );
    }
}
