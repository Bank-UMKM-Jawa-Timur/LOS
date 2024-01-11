<?php

namespace App\Console\Commands;

use App\Http\Controllers\PembayaranController;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PembayaranCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pembayaran:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {

        $pembayaran = new PembayaranController;
        $pembayaran->checkPembayaran();

        $this->info('Pembayaran bisa dilakukan !');


    }
}
