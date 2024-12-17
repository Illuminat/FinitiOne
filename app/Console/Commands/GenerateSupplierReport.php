<?php

namespace App\Console\Commands;

use DateTimeImmutable;
use FinitiOne\Supplier\DTO\SupplierReportDTO;
use FinitiOne\Supplier\Enum\ReportTypes;
use FinitiOne\Supplier\Job\GenerateSupplierReportJob;
use Illuminate\Console\Command;

class GenerateSupplierReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supplier:generate_report {--queue=low}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate report for supplier';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle(): void
    {
        try {
            $report = $this->choice(
                'What type of report you want?',
                ReportTypes::$map,
                ReportTypes::SALES
            );
            $dateFrom = $this->ask('Date from', (new DateTimeImmutable())->sub(new \DateInterval('P1M'))->format('Y-m-d'));
            $dateTo = $this->ask('Date to', (new DateTimeImmutable())->format('Y-m-d'));
            GenerateSupplierReportJob::dispatch($report, $dateFrom, $dateTo)->onQueue($this->option('queue'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
