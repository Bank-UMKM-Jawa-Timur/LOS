<?php

namespace App\Console\Commands;

use App\Http\Controllers\UploadOnedriveController;
use Illuminate\Console\Command;

class OnedriveBackupTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'onedrive:cron';

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
        $onedriveBackup = new UploadOnedriveController;
        $onedriveBackup->fileUploadWithChunk();

        $this->info('OneDrive Backups Finish...');
    }
}