<?php

namespace App\Http\Controllers;

use App\Auth\TokenCache;
use App\Helpers\MicrosoftGraphHelper;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use File;
use Illuminate\Support\Facades\DB;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class UploadOnedriveController extends Controller
{
    public function index() {
        return $this->fileUploadWithChunk();
        $latestBackup = BackupDestination::create('local', 'Laravel')
            ->newestBackup();

        $filepath = storage_path('app/'.$latestBackup->path());
        $filename = explode('/',$latestBackup->path())[1];

        $accessTokenFile = 'EwCAA8l6BAAUs5+HQn0N+h2FxWzLS31ZgQVuHsYAAdGgbIVgIdbp4yNo+ba8KeEmBWZXij3seGwSsgCC0tHPCcgVwxiq5dLbFgHLwcW3Lv0Z/l3WT0OIlPTJ7Xr92R1JMisQLA/LUThvQ8EVKn7TzY/m7NFmuEntvUvyw9OrHlvqK21S6BZZnp0ihhl4iE2hIEEU6t5ldgDKmtHqh2C4pPvu/rRIUPSpZAnEiyda6gYMvAz1uuljTLM73GmHcUTrNM9m5xbfKT9Lo4j2R8VGz9Wbf0wVjkrms4esA1wBBjHoHdMKyvPGVKFtHvuoepkV/4+uIrlr66ySlL/UBu/Oya0SjSKe0RbrhlQyFAsjgLnuviBPCTtLMSh0bE+CpSIDZgAACFNJJ7QOh+bCUAILjA+bI9cEJ7a6sguvV+4qdwcVgNaitjfj9Ih3wajs7uut1E9Av+mnbxicLz1TQX48aO1MBFYXSNLrkNyvKWWPSLcRm21bSZYCuvq6bwW4Gq45aSmyLZg6EaeW08sUxN5Rid2GsgK+suwZDD3aRQXelRbAIzpWYuShaay64WZm7mTBr2UtMb4WRb7yidg0LutDyeIfjXK5X95485M43mKNMfNLnEbSVVPL03MiSdZTTt6qVIeWBk+Q/y3zC8E1Nct8yh3bWdR17ngJKqxOwKFp2Um3Pwi8kiUFc0D23hnejxLYZPb4b/vUN8Ktz/RbnIvURdDKT9fGSSC7p+VuIcJ6qYfTS2+Ef+8JCcHFHVMAwSq2LVryLa6QMNO+vV5VfXFDSGSKTc+Or24fERbVNCjLdJXusEHttL3lx39x/rJ6B3qgUAnfZ7olCljlOKNZLccoI9tzA79IAM7v9vbzJ5wJ593hUKhWwbDpqUYi0ryum7LM8G18hIHC76S2LBskuCcqsoey0cLnoYWNPz7pS7bGe7APZnLn29ZFjeu4yDKR+H8yvgITtdq2aPU79hvi+Wi0Fn1XRqOl8aSDkIu1Kaajd/vIrpDrhVcg3KjvJItJnJ1JWehaW0t6BXS31yN+TgqTBgGjfGzxxH8xEvrxyUdZUMHN7++IzHSHuEPOqrNfKnDIN/xFcBsyKH/5viWplc9Xkf5rJlHKVeMjc9Q/4usGAsjQqujn4obKc461vdoHK2Xhos+LCChjlDeBmYzHs31+4gmR9zRfi7CKdKS0iCH6jwI=';

        $url = "https://graph.microsoft.com/v1.0/me/drive/root:/backup/$filename:/createUploadSession";

        $data = [
            "item" => [
                "@microsoft.graph.conflictBehavior" => "rename",
                "description" => "description",
                "fileSystemInfo" => ["@odata.type" => "microsoft.graph.fileSystemInfo"],
                "name" => $filename
            ]
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $accessTokenFile",
        ];

        $response = Http::withHeaders($headers)->post($url, $data);

        $result = $response->json();
        $graphUrl = $result['uploadUrl'];

        $fragSize = 320 * 1024;
        $file = file_get_contents($filepath);
        $fileSize = strlen($file);
        $numFragments = ceil($fileSize / $fragSize);
        $bytesRemaining = $fileSize;
        $i = 0;

        while ($i < $numFragments) {
            $chunkSize = $numBytes = $fragSize;
            $start = $i * $fragSize;
            $end = $i * $fragSize + $chunkSize - 1;
            $offset = $i * $fragSize;

            if ($bytesRemaining < $chunkSize) {
                $chunkSize = $numBytes = $bytesRemaining;
                $end = $fileSize - 1;
            }

            $dataChunk = substr($file, $offset, $chunkSize);

            $contentRange = "bytes $start-$end/$fileSize";
            $headersChunk = [
                "Content-Length" => $numBytes,
                "Content-Range" => $contentRange
            ];

            $responseChunk = Http::withHeaders($headersChunk)
                ->withBody($dataChunk, 'application/octet-stream')
                ->put($graphUrl);

            $info = $responseChunk->json(); // Adjust this part based on your needs

            $bytesRemaining = $bytesRemaining - $chunkSize;
            $i++;
        }
        dd($info);
        // File upload completed successfully
        dd('File uploaded successfully!');

        return view('upload-onedrive.index');
    }

    function fileUploadWithChunk() {
        // Mendapatkan informasi backup terbaru
        $oldestBackup = BackupDestination::create('local', 'Laravel')->oldestBackup();
        $latestBackup = BackupDestination::create('local', 'Laravel')
            ->newestBackup();
        // mendapatkan filepath dan filename
        $filepath = storage_path('app/'.$latestBackup->path());
        $filename = explode('/',$latestBackup->path())[1];

        $filepathOldest = storage_path('app/'.$oldestBackup->path());
        $filenameOldest = explode('/',$oldestBackup->path())[1];

        // Token akses
        // set file token
        $filePath = storage_path('app/token.json');
        $json = json_decode(file_get_contents($filePath), true);
        if (empty($json['accessToken']) || empty($json['refreshToken'] || empty($json['tokenExpires']))) {
            return '';
        }
        // Check if token is expired
        //Get current time + 5 minutes (to allow for time differences)
        $now = time() + 300;
        if ($json['tokenExpires'] <= $now) {
            // Token is expired (or very close to it)
            // so let's refresh
            // Initialize the OAuth client
            $api_configuration = DB::table('api_configuration')->first();
            $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
                'clientId'                => $api_configuration ? $api_configuration->oauth_app_id : config('azure.appId'),
                'clientSecret'            => $api_configuration ? $api_configuration->oauth_app_secret : config('azure.appSecret'),
                'redirectUri'             => $api_configuration ? $api_configuration->url_callback : config('azure.redirectUri'),
                'urlAuthorize'            => $api_configuration ? $api_configuration->oauth_authority.$api_configuration->oauth_authorize_endpoint : config('azure.authority').config('azure.authorizeEndpoint'),
                'urlAccessToken'          => $api_configuration ? $api_configuration->oauth_authority.$api_configuration->oauth_token_endpoint : config('azure.authority').config('azure.tokenEndpoint'),
                'urlResourceOwnerDetails' => '',
                'scopes'                  => config('azure.scopes')
            ]);

            try {
                $newToken = $oauthClient->getAccessToken('refresh_token', [
                    'refresh_token' => $json['refreshToken']
                ]);

                // Store the new values
                $this->updateTokens($newToken);

                return $newToken->getToken();
            }
            catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                return '';
            }
        }

        // Token is still valid, just return it
        $accessTokenFile = $json['accessToken'];

        // URL untuk membuat upload session di OneDrive
        $url = "https://graph.microsoft.com/v1.0/me/drive/root:/backup/$filename:/createUploadSession";

        // set data if used createUploadsession used rename
        //  "@microsoft.graph.conflictBehavior": "rename",
        $data = [
            "item" => [
                "@microsoft.graph.conflictBehavior" => "rename",
                "description" => "description",
                "fileSystemInfo" => ["@odata.type" => "microsoft.graph.fileSystemInfo"],
                "name" => $filename
            ]
        ];
        // Header untuk request
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $accessTokenFile",
        ];

        // url create session
        // Membuat upload session di OneDrive
        $response = Http::withHeaders($headers)->post($url, $data);

        $result = $response->json();
        $graphUrl = $result['uploadUrl'];

        // Ukuran fragment
        $fragSize = 320 * 1024;
        $file = file_get_contents($filepath);
        $fileSize = strlen($file);
        $numFragments = ceil($fileSize / $fragSize);
        $bytesRemaining = $fileSize;
        $i = 0;

        while ($i < $numFragments) {
            $chunkSize = $numBytes = $fragSize;
            $start = $i * $fragSize;
            $end = $i * $fragSize + $chunkSize - 1;
            $offset = $i * $fragSize;

            if ($bytesRemaining < $chunkSize) {
                $chunkSize = $numBytes = $bytesRemaining;
                $end = $fileSize - 1;
            }

            $dataChunk = substr($file, $offset, $chunkSize);

            $contentRange = "bytes $start-$end/$fileSize";
            $headersChunk = [
                "Content-Length" => $numBytes,
                "Content-Range" => $contentRange
            ];

            // Mengirim chunk data ke OneDrive
            $responseChunk = Http::withHeaders($headersChunk)
                ->withBody($dataChunk, 'application/octet-stream')
                ->put($graphUrl);

            $info = $responseChunk->json(); // Adjust this part based on your needs

            $bytesRemaining = $bytesRemaining - $chunkSize;
            $i++;
            if (!$responseChunk->successful()) {
                // Handle upload failure
                return  'Upload failed:'.$responseChunk->status().''.$responseChunk->body().'.';
            }
        }
        // Hapus file sebelumnya di OneDrive
        $previousFileName = $filenameOldest;
        $previousFileUrl = "https://graph.microsoft.com/v1.0/me/drive/root:/backup/$previousFileName";
        $responseDelete = Http::withHeaders($headers)->delete($previousFileUrl);
        // Hapus file lokal setelah berhasil diupload
        // File::delete($filepathOldest);
        if ($response->getStatusCode() == 201 || $response->getStatusCode() == 200) {
            return "File uploaded successfully! ";
        } else {
            return "Error uploading file.".$response->json()['error']['message'];
        }

        return true;
    }

    function fileUploadContent() {
        $latestBackup = BackupDestination::create('local', 'Laravel')
        ->newestBackup();

        $filepath = storage_path('app/'.$latestBackup->path());
        $filename = explode('/',$latestBackup->path())[1];

        // set file token
        $filePath = storage_path('app/token.json');
        $json = json_decode(file_get_contents($filePath), true);
        if (empty($json['accessToken']) || empty($json['refreshToken'] || empty($json['tokenExpires']))) {
            return '';
        }
        // Check if token is expired
        //Get current time + 5 minutes (to allow for time differences)
        $now = time() + 300;
        if ($json['tokenExpires'] <= $now) {
            // Token is expired (or very close to it)
            // so let's refresh

            // Initialize the OAuth client
            $api_configuration = DB::table('api_configuration')->first();
            $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
                'clientId'                => $api_configuration ? $api_configuration->oauth_app_id : config('azure.appId'),
                'clientSecret'            => $api_configuration ? $api_configuration->oauth_app_secret : config('azure.appSecret'),
                'redirectUri'             => $api_configuration ? $api_configuration->url_callback : config('azure.redirectUri'),
                'urlAuthorize'            => $api_configuration ? $api_configuration->oauth_authority.$api_configuration->oauth_authorize_endpoint : config('azure.authority').config('azure.authorizeEndpoint'),
                'urlAccessToken'          => $api_configuration ? $api_configuration->oauth_authority.$api_configuration->oauth_token_endpoint : config('azure.authority').config('azure.tokenEndpoint'),
                'urlResourceOwnerDetails' => '',
                'scopes'                  => config('azure.scopes')
            ]);

            try {
                $newToken = $oauthClient->getAccessToken('refresh_token', [
                    'refresh_token' => $json['refreshToken']
                ]);

                // Store the new values
                $this->updateTokens($newToken);

                return $newToken->getToken();
            }
            catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                return '';
            }
        }
        // Token is still valid, just return it
        $accessTokenFile = $json['accessToken'];

        $client = new Client();
        $response = $client->request('PUT', "https://graph.microsoft.com/v1.0/me/drive/root:/Backups/{$filename}:/content", [
            'headers' => [
                'Authorization' => "Bearer $accessTokenFile",
                'Content-Type'  => 'text/plain',
            ],
            'body' => file_get_contents($filepath),
        ]);
        // Check if the upload was successful
        if ($response->getStatusCode() == 201 || $response->getStatusCode() == 200) {
            echo "File uploaded successfully!";
        } else {
            echo "Error uploading file.";
        }
    }

    function monitorLog()  {
        $filepath = storage_path('logs/laravel.log');
        $fileContent = File::get($filepath); // Use File facade for simplicity
        $logLines = explode(PHP_EOL, $fileContent);

        return view('logs.index',compact('logLines'));
    }


    function callback(Request $request) {
            // Validate state
            $expectedState = session('oauthState');
            $request->session()->forget('oauthState');
            $providedState = $request->query('state');

            if (!isset($expectedState)) {
                // If there is no expected state in the session,
                // do nothing and redirect to the home page.
                return redirect()->route('dagulir.master.konfigurasi-api.index');
                }

                if (!isset($providedState) || $expectedState != $providedState) {
                return redirect()->route('dagulir.master.konfigurasi-api.index')
                    ->with('error', 'Invalid auth state')
                    ->with('errorDetail', 'The provided auth state did not match the expected value');
                }

                // Authorization code should be in the "code" query param
                $authCode = $request->query('code');
                if (isset($authCode)) {
                // Initialize the OAuth client
                $api_configuration = DB::table('api_configuration')->first();
                $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
                    'clientId'                => $api_configuration ? $api_configuration->oauth_app_id : config('azure.appId'),
                    'clientSecret'            => $api_configuration ? $api_configuration->oauth_app_secret : config('azure.appSecret'),
                    'redirectUri'             => $api_configuration ? $api_configuration->url_callback : config('azure.redirectUri'),
                    'urlAuthorize'            => $api_configuration ? $api_configuration->oauth_authority.$api_configuration->oauth_authorize_endpoint : config('azure.authority').config('azure.authorizeEndpoint'),
                    'urlAccessToken'          => $api_configuration ? $api_configuration->oauth_authority.$api_configuration->oauth_token_endpoint : config('azure.authority').config('azure.tokenEndpoint'),
                    'urlResourceOwnerDetails' => '',
                    'scopes'                  => config('azure.scopes')
                ]);

                try {
                    // Make the token request
                    $accessToken = $oauthClient->getAccessToken('authorization_code', [
                        'code' => $authCode
                    ]);

                    $graph = new Graph();
                    $graph->setAccessToken($accessToken->getToken());

                    // $user = $graph->createRequest('GET', '/me?$select=displayName,mail,mailboxSettings,userPrincipalName')
                    // ->setReturnType(Model\User::class)
                    // ->execute();
                    $tokenCache = new TokenCache();
                    $tokenCache->storeTokens($accessToken);
                    alert()->success('Sukses','Berhasil Set Token OneDrive');

                    return redirect()->route('dagulir.master.konfigurasi-api.index');
                }
                catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                    alert()->error('error','Error requesting access token');
                    return redirect()->route('dagulir.master.konfigurasi-api.index');
                    // ->with('error', 'Error requesting access token')
                    // ->with('errorDetail', json_encode($e->getResponseBody()));
                }
            }
            alert()->error('error',$request->query('error_description'));
            return redirect()->route('dagulir.master.konfigurasi-api.index')
            ->with('error', $request->query('error'))
            ->with('errorDetail', $request->query('error_description'));
    }

    public function updateTokens($accessToken) {
        $filePath = storage_path('app/token.json');
        $json = json_decode(file_get_contents($filePath), true);

        // Memperbarui data dengan token yang baru
        $json['accessToken'] = $accessToken->getToken();
        $json['refreshToken'] = $accessToken->getRefreshToken();
        $json['tokenExpires'] = $accessToken->getExpires();

        // Menulis kembali data ke dalam file JSON
        file_put_contents($filePath, json_encode($json));

        session([
            'accessToken' => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
            'tokenExpires' => $accessToken->getExpires()
        ]);
    }

}
