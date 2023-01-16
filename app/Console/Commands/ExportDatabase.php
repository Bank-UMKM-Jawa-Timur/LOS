<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ExportDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export the database';

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
        $dbDriver = config('database.default');
        $path = Storage::path('database/database.sql');

        if($dbDriver == 'mysql') {
            $mysql = config('database.connections.mysql');
            $conn = \Spatie\DbDumper\Databases\MySql::create()
                ->setDbName($mysql['database'])
                ->setUserName($mysql['username'])
                ->setPassword($mysql['password']);
        }

        $this->line('Running database migration...');

        // Call the migrate command and dump the database
        Artisan::call('migrate');
        $conn->dumpToFile($path);

        $this->info("Success dump database to {$path}");
        return 0;
    }
}
