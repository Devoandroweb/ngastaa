<?php

namespace App\Console\Commands;

use App\Models\AppStatusFunction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AppSetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appsetting:update-excel-version';

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
        $appSetting = AppStatusFunction::whereName('excel_template_pegawai_version')->update([
            'value' => Hash::make('1')
        ]);
        if($appSetting){
            $this->info("Updte Version Excel Berhasil");
        }else{
            $this->info("Updte Version Excel Gagal");

        }
        return Command::SUCCESS;
    }
}
