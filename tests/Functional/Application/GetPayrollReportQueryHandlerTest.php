<?php

declare(strict_types=1);

namespace Tests\Functional\Application;

use App\Application\GetPayrollReportQuery;
use App\Application\PayrollView;
use App\Application\Sorting\Sorting;
use App\Application\Sorting\SortingDirection;
use App\Application\Sorting\SortingField;
use App\Domain\BonusType;
use App\Domain\Department;
use App\Domain\Employee;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Tests\Fake\Clock;
use Tests\Functional\FunctionalTest;

class GetPayrollReportQueryHandlerTest extends FunctionalTest
{
    /**
     * @test
     */
    public function it_should_return_payroll_view_for_all_employees()
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

        $envelope = $this->testHelper->getMessageBus()->dispatch(
            new GetPayrollReportQuery(new Sorting(SortingField::FIRST_NAME(), SortingDirection::ASC()))
        );
        /** @var PayrollView[] $payrollViews */
        $payrollViews = $envelope->last(HandledStamp::class)->getResult();

        $this->assertCount(2, $payrollViews);
        $this->assertSame(200000, $payrollViews[0]->totalSalary);
        $this->assertSame(121000, $payrollViews[1]->totalSalary);
    }
}
