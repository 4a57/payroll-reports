<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Application\PayrollView;

class PayrollViewSerializer
{
    public function toCommandOutputArray(PayrollView $payroll): array
    {
        return [
            $payroll->firstName,
            $payroll->lastName,
            $payroll->department,
            (string) ($payroll->baseSalary / 100),
            (string) ($payroll->bonusSalary / 100),
            $payroll->bonusType,
            (string) ($payroll->totalSalary / 100),
        ];
    }
}
