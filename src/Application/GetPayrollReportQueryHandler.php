<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Sorting\SortingApplicator;
use App\Domain\Employee;
use App\Domain\EmployeeRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetPayrollReportQueryHandler implements MessageHandlerInterface
{
    private EmployeeRepository $employeeRepository;
    private PayrollViewFactory $payrollViewFactory;
    private SortingApplicator $sortingApplicator;

    public function __construct(
        EmployeeRepository $employeeRepository,
        PayrollViewFactory $payrollViewFactory,
        SortingApplicator $sortingApplicator
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->payrollViewFactory = $payrollViewFactory;
        $this->sortingApplicator = $sortingApplicator;
    }

    /**
     * @return PayrollView[]
     */
    public function __invoke(GetPayrollReportQuery $query): array
    {
        $employees = $this->employeeRepository->getAll();
        $payrollViews = \array_map(
            function (Employee $employee): PayrollView {
                return $this->payrollViewFactory->createFromEmployee($employee);
            },
            $employees
        );
        $payrollViews = $this->sortingApplicator->sort($payrollViews, $query->getSorting());

        return $payrollViews;
    }
}
