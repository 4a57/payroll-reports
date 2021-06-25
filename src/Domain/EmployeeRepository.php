<?php

declare(strict_types=1);

namespace App\Domain;

interface EmployeeRepository
{
    /**
     * @return Employee[]
     */
    public function getAll();
}
