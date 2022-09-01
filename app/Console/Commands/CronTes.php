<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CronTes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat log, yang memastikan command berjalan';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
          date_default_timezone_set("Asia/Jakarta");
          $jam=date('Y-m-d H:i:s',strtotime('+1 hour')); 
          echo 'Cron kita sudah jalan!';
 
         \Log::info('Cron kita sudah jalan! Time :'.$jam);
    }
    
    
}
