<?php

namespace App\Console\Commands;

use App\Http\Controllers\PembayaranController;
use App\Models\MasterDDAngsuran;
use App\Models\MasterDDLoan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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

        // $date_yesterday = Carbon::yesterday()->setTime(5, 0, 0)->toDateTimeString();
        // $data_yesterday = MasterDDLoan::with('angsuran')->whereDate('created_at', '>=', $date_yesterday)->get();

        // if ($data_yesterday->isNotEmpty()) {
        //     $this->info('Cek data realisasi sebelumnya');

        //     foreach ($data_yesterday as $loan) {
        //         $this->processLoan($loan);
        //     }
        // } else {
        //     $this->info('tidak ada data.');
        // }

        $data_today = MasterDDAngsuran::whereDate('created_at', Carbon::now())->get();

        if ($data_today->isNotEmpty()) {
            foreach ($data_today as $value) {
                $loan = MasterDDLoan::where('no_loan', $value['no_loan'])->whereDate('updated_at',Carbon::now())->first();
                if ($loan) {
                    $this->updateBakiDebetAndCallAPI($loan, $value);
                }
            }
        }

    }

    private function processLoan($loan)
    {
        foreach ($loan as $key => $value) {
            $kode = $loan->kode_pendaftaran;
            $total_angsuran = $loan->baki_debet - $value['pokok_pembayaran'];
            $update = MasterDDLoan::where('no_loan',$value['no_loan'])->whereDate('updated_at',Carbon::now())->first();
            $update->baki_debet = $total_angsuran;
            $update->update();
            $response = $this->kumulatif_debitur($kode, $value['pokok_pembayaran'], $total_angsuran, $value['kolek']);
            info($response);
        }
    }

    private function updateBakiDebetAndCallAPI($loan, $value)
    {
        // Your logic for updating baki_debet and making API call goes here
        // For example:
        $kode = $loan->kode_pendaftaran;
        $total_angsuran = $loan->baki_debet - $value['pokok_pembayaran'];
        $loan->baki_debet = $total_angsuran;
        $loan->update();
        // Make API call using $value, $loan, etc.
        // You can use HTTP client, Guzzle, or any other method to make the API call
        $kumulatif = new PembayaranController;

        $response = $kumulatif->kumulatif_debitur($kode, $value['pokok_pembayaran'], $total_angsuran, $value['kolek']);
        info($response);
    }
}
