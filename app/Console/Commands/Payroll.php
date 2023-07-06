<?php

namespace App\Console\Commands;

use App\Models\Payroll\DataPayroll;
use App\Models\Payroll\GeneratePayroll;
use App\Models\Payroll\PayrollKurang;
use App\Models\Payroll\PayrollTambah;
use Illuminate\Console\Command;

class Payroll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payroll:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DataPayroll::truncate();
        PayrollTambah::truncate();
        PayrollKurang::truncate();
        GeneratePayroll::truncate();
        $this->info("Sukses Reset Payroll");
        return Command::SUCCESS;
    }
}
