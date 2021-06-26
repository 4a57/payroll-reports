<?php

declare(strict_types=1);

namespace Tests\Functional\Infrastructure\Symfony;

use App\Domain\BonusType;
use App\Domain\Department;
use App\Domain\Employee;
use Symfony\Component\Console\Command\Command;
use Tests\Fake\Clock;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\Functional\FunctionalTest;

class GeneratePayrollReportCommandTest extends FunctionalTest
{
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        parent::setUp();

        $application = new Application(static::$kernel);
        $command = $application->find('app:generate-payroll-report');
        $this->commandTester = new CommandTester($command);
    }

    public function it_should_return_validation_error()
    {
        $this->commandTester->execute(['--sort', 'someInvalidField']);

        $status = $this->commandTester->getStatusCode();
        $output = $this->commandTester->getDisplay();

        $this->assertSame(Command::INVALID, $status);
        $this->assertStringContainsString('Validation error', $output);
    }

    /**
     * @test
     */
    public function it_should_show_report_with_no_bonus(): void
    {
        $departmentHr = new Department(1, 'HR', BonusType::FIXED(), 0);
        $departmentCustomService = new Department(2, 'Custom Service', BonusType::PERCENTAGE(), 0);
        $this->testHelper->addDepartment($departmentHr);
        $this->testHelper->addDepartment($departmentCustomService);

        Clock::setDateTime(new \DateTimeImmutable('2020-01-01 00:00:00'));
        $fifteenYearsAgo = $this->testHelper->getClock()->getDateTime()->modify('-15 years');
        $fiveYearsAgo = $this->testHelper->getClock()->getDateTime()->modify('-5 years');
        $employeeAK = new Employee(1, 'Adam', 'Kowalski', $departmentHr, 100000, $fifteenYearsAgo);
        $employeeAN = new Employee(2, 'Ania', 'Nowak', $departmentCustomService, 110000, $fiveYearsAgo);
        $this->testHelper->addEmployee($employeeAK);
        $this->testHelper->addEmployee($employeeAN);

        $this->commandTester->execute([]);
        $status = $this->commandTester->getStatusCode();
        $output = $this->commandTester->getDisplay();

        $expectedOutput = <<<TXT
+------------+-----------+----------------+-------------+--------------+------------+--------------+
| First name | Last name | Department     | Base salary | Bonus salary | Bonus type | Total salary |
+------------+-----------+----------------+-------------+--------------+------------+--------------+
| Adam       | Kowalski  | HR             | 1000        | 0            | fixed      | 1000         |
| Ania       | Nowak     | Custom Service | 1100        | 0            | percentage | 1100         |
+------------+-----------+----------------+-------------+--------------+------------+--------------+

TXT;

        $this->assertSame(Command::SUCCESS, $status);
        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @test
     */
    public function it_should_show_report_with_bonus(): void
    {
        $departmentHr = new Department(1, 'HR', BonusType::FIXED(), 10000);
        $departmentCustomService = new Department(2, 'Custom Service', BonusType::PERCENTAGE(), 10);
        $this->testHelper->addDepartment($departmentHr);
        $this->testHelper->addDepartment($departmentCustomService);

        Clock::setDateTime(new \DateTimeImmutable('2020-01-01 00:00:00'));
        $fifteenYearsAgo = $this->testHelper->getClock()->getDateTime()->modify('-15 years');
        $fiveYearsAgo = $this->testHelper->getClock()->getDateTime()->modify('-5 years');
        $employeeAK = new Employee(1, 'Adam', 'Kowalski', $departmentHr, 100000, $fifteenYearsAgo);
        $employeeAN = new Employee(2, 'Ania', 'Nowak', $departmentCustomService, 110000, $fiveYearsAgo);
        $this->testHelper->addEmployee($employeeAK);
        $this->testHelper->addEmployee($employeeAN);

        $this->commandTester->execute([]);
        $status = $this->commandTester->getStatusCode();
        $output = $this->commandTester->getDisplay();

        $expectedOutput = <<<TXT
+------------+-----------+----------------+-------------+--------------+------------+--------------+
| First name | Last name | Department     | Base salary | Bonus salary | Bonus type | Total salary |
+------------+-----------+----------------+-------------+--------------+------------+--------------+
| Adam       | Kowalski  | HR             | 1000        | 1000         | fixed      | 2000         |
| Ania       | Nowak     | Custom Service | 1100        | 110          | percentage | 1210         |
+------------+-----------+----------------+-------------+--------------+------------+--------------+

TXT;

        $this->assertSame(Command::SUCCESS, $status);
        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @test
     */
    public function it_should_show_report_in_proper_order(): void
    {
        $departmentHr = new Department(1, 'HR', BonusType::FIXED(), 10000);
        $departmentCustomService = new Department(2, 'Custom Service', BonusType::PERCENTAGE(), 10);
        $this->testHelper->addDepartment($departmentHr);
        $this->testHelper->addDepartment($departmentCustomService);

        Clock::setDateTime(new \DateTimeImmutable('2020-01-01 00:00:00'));
        $fifteenYearsAgo = $this->testHelper->getClock()->getDateTime()->modify('-15 years');
        $fiveYearsAgo = $this->testHelper->getClock()->getDateTime()->modify('-5 years');
        $employeeAK = new Employee(1, 'Adam', 'Kowalski', $departmentHr, 100000, $fifteenYearsAgo);
        $employeeAN = new Employee(2, 'Ania', 'Nowak', $departmentCustomService, 110000, $fiveYearsAgo);
        $this->testHelper->addEmployee($employeeAK);
        $this->testHelper->addEmployee($employeeAN);

        $this->commandTester->execute(['--sort' => 'lastName', '--sort-direction' => 'desc']);
        $status = $this->commandTester->getStatusCode();
        $output = $this->commandTester->getDisplay();

        $expectedOutput = <<<TXT
+------------+-----------+----------------+-------------+--------------+------------+--------------+
| First name | Last name | Department     | Base salary | Bonus salary | Bonus type | Total salary |
+------------+-----------+----------------+-------------+--------------+------------+--------------+
| Ania       | Nowak     | Custom Service | 1100        | 110          | percentage | 1210         |
| Adam       | Kowalski  | HR             | 1000        | 1000         | fixed      | 2000         |
+------------+-----------+----------------+-------------+--------------+------------+--------------+

TXT;

        $this->assertSame(Command::SUCCESS, $status);
        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @test
     */
    public function it_should_filter_report(): void
    {
        $departmentHr = new Department(1, 'HR', BonusType::FIXED(), 10000);
        $departmentCustomService = new Department(2, 'Custom Service', BonusType::PERCENTAGE(), 10);
        $this->testHelper->addDepartment($departmentHr);
        $this->testHelper->addDepartment($departmentCustomService);

        Clock::setDateTime(new \DateTimeImmutable('2020-01-01 00:00:00'));
        $fifteenYearsAgo = $this->testHelper->getClock()->getDateTime()->modify('-15 years');
        $fiveYearsAgo = $this->testHelper->getClock()->getDateTime()->modify('-5 years');
        $employeeAK = new Employee(1, 'Adam', 'Kowalski', $departmentHr, 100000, $fifteenYearsAgo);
        $employeeAN = new Employee(2, 'Ania', 'Nowak', $departmentCustomService, 110000, $fiveYearsAgo);
        $this->testHelper->addEmployee($employeeAK);
        $this->testHelper->addEmployee($employeeAN);

        $this->commandTester->execute(['--filter' => 'hR']);
        $status = $this->commandTester->getStatusCode();
        $output = $this->commandTester->getDisplay();

        $expectedOutput = <<<TXT
+------------+-----------+------------+-------------+--------------+------------+--------------+
| First name | Last name | Department | Base salary | Bonus salary | Bonus type | Total salary |
+------------+-----------+------------+-------------+--------------+------------+--------------+
| Adam       | Kowalski  | HR         | 1000        | 1000         | fixed      | 2000         |
+------------+-----------+------------+-------------+--------------+------------+--------------+

TXT;

        $this->assertSame(Command::SUCCESS, $status);
        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @test
     */
    public function it_should_filter_and_sort_report(): void
    {
        $departmentHr = new Department(1, 'HR', BonusType::FIXED(), 10000);
        $departmentCustomService = new Department(2, 'Custom Service', BonusType::PERCENTAGE(), 10);
        $this->testHelper->addDepartment($departmentHr);
        $this->testHelper->addDepartment($departmentCustomService);

        Clock::setDateTime(new \DateTimeImmutable('2020-01-01 00:00:00'));
        $fifteenYearsAgo = $this->testHelper->getClock()->getDateTime()->modify('-15 years');
        $fiveYearsAgo = $this->testHelper->getClock()->getDateTime()->modify('-5 years');
        $employeeAK = new Employee(1, 'Adam', 'Kowalski', $departmentHr, 100000, $fifteenYearsAgo);
        $employeeAN = new Employee(2, 'Ania', 'Nowak', $departmentCustomService, 110000, $fiveYearsAgo);
        $employeeKP = new Employee(3, 'Krzysztof', 'Nowakowski', $departmentHr, 100000, $fiveYearsAgo);
        $this->testHelper->addEmployee($employeeAK);
        $this->testHelper->addEmployee($employeeAN);
        $this->testHelper->addEmployee($employeeKP);

        $this->commandTester->execute(['--sort' => 'totalSalary', '--sort-direction' => 'desc', '--filter' => 'hR']);
        $status = $this->commandTester->getStatusCode();
        $output = $this->commandTester->getDisplay();

        $expectedOutput = <<<TXT
+------------+------------+------------+-------------+--------------+------------+--------------+
| First name | Last name  | Department | Base salary | Bonus salary | Bonus type | Total salary |
+------------+------------+------------+-------------+--------------+------------+--------------+
| Adam       | Kowalski   | HR         | 1000        | 1000         | fixed      | 2000         |
| Krzysztof  | Nowakowski | HR         | 1000        | 500          | fixed      | 1500         |
+------------+------------+------------+-------------+--------------+------------+--------------+

TXT;

        $this->assertSame(Command::SUCCESS, $status);
        $this->assertSame($expectedOutput, $output);
    }
}
