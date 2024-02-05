<?php

namespace App\Providers;

use Carbon\Carbon;
use Exception;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Google\Service\Drive as ServiceDrive;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Masbug\Flysystem\GoogleDriveAdapter;
use Microsoft\Graph\Graph;
use NicolasBeauvais\FlysystemOneDrive\OneDriveAdapter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        Paginator::useBootstrap();

        $this->loadGoogleStorageDriver();
        $this->loadGoogleStorageDriver();
    }

    private function loadOnedriveStorageDriver() {
        $driverName = 'onedrive';
        $graph = new Graph();
        $graph->setAccessToken('EwBIA8l6BAAU7p9QDpi...');

        $adapter = new OneDriveAdapter($graph, 'root');
        $filesystem = new Filesystem($adapter);

        // Or to use the approot endpoint:
        $adapter = new OneDriveAdapter($graph, 'special/approot');
        return new FilesystemAdapter($filesystem, $adapter);
    }

    private function loadGoogleStorageDriver(string $driverName = 'google') {
        try {
            Storage::extend($driverName, function($app, $config) {
                $options = [];

                if (!empty($config['teamDriveId'] ?? null)) {
                    $options['teamDriveId'] = $config['teamDriveId'];
                }

                $client = new \Google\Client();
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->refreshToken($config['refreshToken']);

                $service = new ServiceDrive($client);
                $adapter = new GoogleDriveAdapter($service, $config['folder'] ?? '/', $options);
                $driver = new Filesystem($adapter);

                return new FilesystemAdapter($driver, $adapter);
            });
        } catch(Exception $e) {
            return $e;
            // your exception handling logic
        }
    }
}
