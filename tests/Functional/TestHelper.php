<?php

declare(strict_types=1);

namespace Tests\Functional;

use App\Domain\Clock;
use App\Domain\Department;
use App\Domain\Employee;
use Doctrine\DBAL\Connection;

class TestHelper
{
    private Clock $clock;
    private Connection $connection;

    public function __construct(Clock $clock, Connection $connection)
    {
        $this->clock = $clock;
        $this->connection = $connection;
    }

    public function getClock(): Clock
    {
        return $this->clock;
    }

    public function addDepartment(Department $department): void
    {
        $insert = <<<SQL
INSERT INTO departments(id, name, bonus_type, bonus_value) VALUES(:id, :name, :bonusType, :bonusValue)
SQL;

        $this->connection->executeQuery(
            $insert,
            [
                'id'         => $department->getId(),
                'name'       => $department->getName(),
                'bonusType'  => $department->getBonusType()->getValue(),
                'bonusValue' => $department->getBonusValue(),
            ]
        );
    }

    public function addEmployee(Employee $employee): void
    {
        $insert = <<<SQL
INSERT INTO employees(id, department_id, first_name, last_name, base_salary, hired_at)
VALUES(:id, :departmentId, :firstName, :lastName, :baseSalary, :hiredAt)
SQL;

        $this->connection->executeQuery(
            $insert,
            [
                'id'           => $employee->getId(),
                'departmentId' => $employee->getDepartment()->getId(),
                'firstName'    => $employee->getFirstName(),
                'lastName'     => $employee->getLastName(),
                'baseSalary'   => $employee->getBaseSalary(),
                'hiredAt'      => $employee->getHiredAt()->format(\DateTimeInterface::ATOM),
            ]
        );
    }

    public function clearDatabase(): void
    {
        $this->connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        $this->connection->executeQuery('TRUNCATE TABLE employees');
        $this->connection->executeQuery('TRUNCATE TABLE departments');
        $this->connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
