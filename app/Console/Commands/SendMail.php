<?php

namespace App\Console\Commands;

use App\Mail\OtpEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-mail {--name=:name} {--otp=:otp}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name');
        $otp = $this->option('otp');
        Mail::to('syafi.arrosyid@gmail.com')->send(new OtpEmail($name,$otp));
    }
}
