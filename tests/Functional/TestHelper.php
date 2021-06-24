<?php

declare(strict_types=1);

namespace Tests\Functional;

use App\Domain\Clock;
use App\Domain\Department;
use App\Domain\Employee;

class TestHelper
{
    private Clock $clock;

    public function __construct(Clock $clock)
    {
        $this->clock = $clock;
    }

    public function getClock(): Clock
    {
        return $this->clock;
    }

    public function addDepartment(Department $department): void
    {
    }

    public function addEmployee(Employee $employee): void
    {
    }
}
