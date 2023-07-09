<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class Role extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:remove-role-pegawai';

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
        $user = User::where('nip',null)->get();
        foreach ($user as  $value) {
            $value->removeRole('pegawai');
        }
        $this->info('Suksess Remove Role');
        return Command::SUCCESS;
    }
}
