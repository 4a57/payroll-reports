<?php

declare(strict_types=1);

namespace Tests\Functional;

use App\Domain\BonusType;
use App\Domain\Department;
use App\Domain\Employee;
use Tests\Fake\Clock;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GeneratePayrollReportCommandTest extends KernelTestCase
{
    private CommandTester $commandTester;
    private TestHelper $testHelper;

    protected function setUp(): void
    {
        $application = new Application(static::createKernel());
        $command = $application->find('app:generate-payroll-report');
        $this->commandTester = new CommandTester($command);

        $this->testHelper = static::getContainer()->get('test.test_helper');

        $this->testHelper->clearDatabase();

        parent::setUp();
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
        $output = $this->commandTester->getDisplay();

        $expectedOutput = <<<TXT
+------------+-----------+----------------+-------------+--------------+------------+--------------+
| First name | Last name | Department     | Base salary | Bonus salary | Bonus type | Total salary |
+------------+-----------+----------------+-------------+--------------+------------+--------------+
| Adam       | Kowalski  | HR             | 1000        | 0            | fixed      | 1000         |
| Ania       | Nowak     | Custom Service | 1100        | 0            | percentage | 1100         |
+------------+-----------+----------------+-------------+--------------+------------+--------------+

TXT;

        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @test
     */
    public function it_should_show_report_with_bonus(): void
    {
        $this->markTestSkipped();
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
        $output = $this->commandTester->getDisplay();

        $expectedOutput = <<<TXT
+------------+-----------+----------------+-------------+--------------+------------+--------------+
| First name | Last name | Department     | Base salary | Bonus salary | Bonus type | Total salary |
+------------+-----------+----------------+-------------+--------------+------------+--------------+
| Adam       | Kowalski  | HR             | 1000        | 0            | fixed      | 1000         |
| Ania       | Nowak     | Custom Service | 1100        | 0            | percentage | 1100         |
+------------+-----------+----------------+-------------+--------------+------------+--------------+

TXT;

        $this->assertSame($expectedOutput, $output);
    }
}
