<?php

namespace FinitiOne\Supplier\Job;

use DateTimeImmutable;
use FinitiOne\Supplier\DTO\SupplierReportDTO;
use FinitiOne\Supplier\ReportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use PHPUnit\TextUI\RuntimeException;

class GenerateSupplierReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $report;
    protected $dateFrom;
    protected $dateTo;

    public $tries = 2;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($report, $dateFrom, $dateTo)
    {
        $this->report= $report;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ReportService $service)
    {
        $startTime = microtime(true);
        Log::debug(self::class . ' started');
        try {
            $service->generateReport(new SupplierReportDTO(
                $this->report,
                DateTimeImmutable::createFromFormat('Y-m-d', $this->dateFrom),
                DateTimeImmutable::createFromFormat('Y-m-d', $this->dateTo)
            ));
        } catch (\RuntimeException $e) {
            $this->release(5);
        } catch (\Exception $e) {
            Log::error('Generating report error | ' . $e->getMessage());
        } finally {
            Log::debug(self::class . ' finished. Total execution time: ' . (microtime(true) - $startTime) / 60);
        }
    }
}
