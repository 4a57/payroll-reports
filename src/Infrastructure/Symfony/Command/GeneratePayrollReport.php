<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Domain\Employee;
use App\Domain\EmployeeRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GeneratePayrollReport extends Command
{
    protected static $defaultName = 'app:generate-payroll-report';

    private EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $employees = $this->employeeRepository->getAll();

        $reportTable = new Table($output);
        $reportTable->setHeaders(
            ['First name', 'Last name', 'Department', 'Base salary', 'Bonus salary', 'Bonus type', 'Total salary']
        );

        $tableView = \array_map(static function (Employee $employee): array {
            return [
                $employee->getFirstName(),
                $employee->getLastName(),
                $employee->getDepartment()->getName(),
                $employee->getBaseSalary() / 100,
                $employee->getDepartment()->getBonusValue() / 100,
                $employee->getDepartment()->getBonusType()->getValue(),
                $employee->getBaseSalary() / 100,
            ];
        }, $employees);

        $reportTable->setRows($tableView);

        $reportTable->render();

        return Command::SUCCESS;
    }
}
