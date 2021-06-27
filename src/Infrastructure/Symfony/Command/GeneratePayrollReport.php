<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Application\GetPayrollReportQuery;
use App\Domain\Payroll\PayrollView;
use App\Domain\Payroll\Sorting\Sorting;
use App\Domain\Payroll\Sorting\SortingDirection;
use App\Domain\Payroll\Sorting\SortingField;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class GeneratePayrollReport extends Command
{
    private const OPTION_SORT = 'sort';
    private const OPTION_SORT_DIRECTION = 'sort-direction';
    private const OPTION_FILTER = 'filter';

    protected static $defaultName = 'app:generate-payroll-report';
    protected static $defaultDescription = 'Generate payroll report with for whole company';

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
        $this->addOption(
            self::OPTION_FILTER,
            'f',
            InputOption::VALUE_OPTIONAL,
            'Filter by combined department, first name, and last name'
        );

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $sortingField = new SortingField($input->getOption(self::OPTION_SORT));
            $sortingDirection = new SortingDirection($input->getOption(self::OPTION_SORT_DIRECTION));
        } catch (\UnexpectedValueException $exception) {
            $output->writeln(\sprintf('Validation error: %s', $exception->getMessage()));

            return Command::INVALID;
        }

        $filter = $input->getOption(self::OPTION_FILTER);

        $envelope = $this->messageBus->dispatch(
            new GetPayrollReportQuery(new Sorting($sortingField, $sortingDirection), $filter)
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
