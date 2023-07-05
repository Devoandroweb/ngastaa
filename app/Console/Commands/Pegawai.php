<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class Pegawai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pegawai:assign-role-pegawai';

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
        $pegawai = User::all();
        foreach ($pegawai as $value) {
            if($value->owner == 0){
                $value->assignRole('pegawai');
            }else{
                $value->removeRole('pegawai');
            }
        }
        $this->info("Sukses Assign Role Pegawai");
        return Command::SUCCESS;
    }
}
