<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Application\PayrollView;

class PayrollViewSerializer
{
    public function toCommandOutputArray(PayrollView $payroll): array
    {
        return [
            $payroll->getFirstName(),
            $payroll->getLastName(),
            $payroll->getDepartmentName(),
            (string) ($payroll->getBaseSalary() / 100),
            (string) ($payroll->getBonusSalary() / 100),
            $payroll->getBonusType(),
            (string) ($payroll->getTotalSalary() / 100),
        ];
    }
}
