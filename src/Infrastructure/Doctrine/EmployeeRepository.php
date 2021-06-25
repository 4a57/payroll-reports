<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Domain\Employee as DomainEmployee;
use App\Domain\EmployeeRepository as DomainEmployeeRepository;
use App\Infrastructure\Doctrine\Entity\Employee;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class EmployeeRepository implements DomainEmployeeRepository
{
    private EntityRepository $repository;
    private EmployeeMapper $employeeMapper;

    public function __construct(EntityManager $em, EmployeeMapper $employeeMapper)
    {
        $this->repository = $em->getRepository(Employee::class);
        $this->employeeMapper = $employeeMapper;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $employees = $this->repository->findAll();

        return \array_map(
            function (Employee $employee): DomainEmployee {
                return $this->employeeMapper->mapToDomain($employee);
            },
            $employees
        );
    }
}
