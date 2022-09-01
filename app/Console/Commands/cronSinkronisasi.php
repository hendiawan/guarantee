<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CronSinkronisasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:sink';

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
          echo 'Cron dijalankan jalan!';
          //melakukan proses autosinkronisasi data
           $apikredit = (new \App\Http\Controllers\APIController())->autoSinkronisasiData(); //untuk pejaminan kredit
          \Log::info('Cron Sinkronisasi Penjaminan Kredit sudah berjalan! Time :'.$jam .' Info: '.$apikredit);
           $apiSurety = (new \App\Http\Controllers\APIController())->autoSinkronisasiDataSb(); //untuk pejaminan SB
          \Log::info('Cron Sinkronisasi Surety Bond sudah berjalan! Time :'.$jam .' Info: '.$apiSurety);
    }
    
    
}
