<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\BonusCalculator\BonusCalculator;
use App\Domain\Clock;
use App\Domain\Employee;

class PayrollViewFactory
{
    private BonusCalculator $calculator;
    private Clock $clock;

    public function __construct(BonusCalculator $calculator, Clock $clock)
    {
        $this->calculator = $calculator;
        $this->clock = $clock;
    }

    public function createFromEmployee(Employee $employee): PayrollView
    {
        $baseSalary = $employee->getBaseSalary();
        $bonusType = $employee->getDepartment()->getBonusType();
        $bonusValue = $employee->getDepartment()->getBonusValue();
        $yearsOfService = $this->clock->getDiffInYears($employee->getHiredAt());
        $bonusSalary = $this->calculator->calculateBonus($baseSalary, $bonusType, $bonusValue, $yearsOfService);

        return new PayrollView(
            $employee->getFirstName(),
            $employee->getLastName(),
            $employee->getDepartment()->getName(),
            $baseSalary,
            $bonusSalary,
            $bonusType->getValue(),
            $baseSalary + $bonusSalary
        );
    }
}
