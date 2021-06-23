<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GeneratePayrollReport extends Command
{
    protected static $defaultName = 'app:generate-payroll-report';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Hello Tidio!');

        return Command::SUCCESS;
    }
}
