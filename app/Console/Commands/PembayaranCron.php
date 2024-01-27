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

        $date_yesterday = Carbon::yesterday()->setTime(5, 0, 0)->toDateTimeString();
        $data_yesterday = MasterDDLoan::with('angsuran')
            ->whereDate('created_at', '>=', $date_yesterday)
            ->whereDate('created_at', '<', Carbon::now()->setTime(5, 0, 0))
            ->get();


        if ($data_yesterday->isNotEmpty()) {

            foreach ($data_yesterday as $loan) {
                $this->processLoan($loan);
            }
        } else {
            $this->info('tidak ada data.');
        }


    }

    private function processLoan($loan)
    {
        $date_to_process = Carbon::now()->addDay()->setTime(5, 0, 0);

        foreach ($loan as $key => $value) {
            $kumulatif = new PembayaranController;
            $pokok_pembayaran = MasterDDAngsuran::where('no_loan', $value['no_loan'])
                                ->whereDate('updated_at', $date_to_process)
                                ->first();
            if ($pokok_pembayaran) {
                $response = $kumulatif->kumulatif_debitur($value['kode_pendaftaran'], $pokok_pembayaran->pokok_pembayaran, $value['baki_debet'], $value['kolek']);
            }else{
                $response = $kumulatif->kumulatif_debitur($value['kode_pendaftaran'], 0, $value['baki_debet'],1);

            }
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
