<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Domain\BonusType;
use App\Domain\Department as DomainDepartment;
use App\Infrastructure\Doctrine\Entity\Department;

class DepartmentMapper
{
    public function mapToDomain(Department $department): DomainDepartment
    {
        return new DomainDepartment(
            $department->getId(),
            $department->getName(),
            new BonusType($department->getBonusType()),
            $department->getBonusValue()
        );
    }
}
