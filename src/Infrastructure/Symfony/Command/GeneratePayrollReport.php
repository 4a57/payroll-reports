<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GeneratePayrollReport extends Command
{
    protected static $defaultName = 'app:generate-payroll-report';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $reportTable = new Table($output);
        $reportTable->setHeaders(
            ['First name', 'Last name', 'Department', 'Base salary', 'Bonus salary', 'Bonus type', 'Total salary']
        )->setRows(
            [
                ['Adam', 'Kowalski', 'HR', '1000', '1000', 'Fixed', '2000'],
                ['Ania', 'Nowak', 'Customer Service', '1100', '110', 'Percentage', '1210'],
            ]
        );

        $reportTable->render();

        return Command::SUCCESS;
    }
}
