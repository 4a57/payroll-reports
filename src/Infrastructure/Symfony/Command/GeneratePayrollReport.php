<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Application\GetPayrollReportQuery;
use App\Application\PayrollView;
use App\Application\Sorting\Sorting;
use App\Application\Sorting\SortingDirection;
use App\Application\Sorting\SortingField;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class GeneratePayrollReport extends Command
{
    const OPTION_SORT = 'sort';
    const OPTION_SORT_DIRECTION = 'sort-direction';
    protected static $defaultName = 'app:generate-payroll-report';

    private MessageBusInterface $messageBus;
    private PayrollViewSerializer $serializer;

    public function __construct(MessageBusInterface $messageBus, PayrollViewSerializer $serializer)
    {
        $this->messageBus = $messageBus;
        $this->serializer = $serializer;

        parent::__construct();
    }

    protected function configure()
    {
        $this->addOption(
            self::OPTION_SORT,
            's',
            InputOption::VALUE_OPTIONAL,
            \sprintf('Sort by field [%s]', \implode(', ', SortingField::toArray())),
            SortingField::FIRST_NAME()->getValue()
        );
        $this->addOption(
            self::OPTION_SORT_DIRECTION,
            'd',
            InputOption::VALUE_OPTIONAL,
            \sprintf('Sort direction [%s]', \implode(', ', SortingField::toArray())),
            SortingDirection::ASC()->getValue()
        );
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sortingField = new SortingField($input->getOption(self::OPTION_SORT));
        $sortingDirection = new SortingDirection($input->getOption(self::OPTION_SORT_DIRECTION));

        $envelope = $this->messageBus->dispatch(
            new GetPayrollReportQuery(new Sorting($sortingField, $sortingDirection))
        );
        /** @var PayrollView[] $payrollViews */
        $payrollViews = $envelope->last(HandledStamp::class)->getResult();

        $reportTable = new Table($output);
        $this->drawHeader($reportTable);
        $this->drawBody($payrollViews, $reportTable);

        $reportTable->render();

        return Command::SUCCESS;
    }

    protected function drawHeader(Table $reportTable): void
    {
        $reportTable->setHeaders(
            ['First name', 'Last name', 'Department', 'Base salary', 'Bonus salary', 'Bonus type', 'Total salary']
        );
    }

    /**
     * @param PayrollView[] $payrollViews
     */
    private function drawBody(array $payrollViews, Table $reportTable): void
    {
        $tableBody = \array_map(
            function (PayrollView $payrollView): array {
                return $this->serializer->toCommandOutputArray($payrollView);
            },
            $payrollViews
        );
        $reportTable->setRows($tableBody);
    }
}
